<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Target; 
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Log; 
use App\Models\StatusLog;
use App\Models\SslCheck;
use App\Models\Alert;
use App\Models\User; 
use Illuminate\Support\Facades\Mail;
use App\Mail\SiteAlertMail; 
use Carbon\Carbon; 

class MonitorSites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:sites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor registered websites for uptime and SSL certificate validity.';

    private function shouldOutput(): bool
    {
        return $this->output !== null && app()->runningInConsole();
    }

    private function consoleInfo(string $message): void
    {
        if ($this->shouldOutput()) {
            $this->info($message);
        }
    }

    private function consoleLine(string $message): void
    {
        if ($this->shouldOutput()) {
            $this->line($message);
        }
    }

    private function consoleWarn(string $message): void
    {
        if ($this->shouldOutput()) {
            $this->warn($message);
        }
    }

    private function consoleError(string $message): void
    {
        if ($this->shouldOutput()) {
            $this->error($message);
        }
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->consoleInfo('Starting site monitoring...');

        // Prioritize targets that haven't been checked recently or have active alerts.
        // This is a simple way. Remeber to Ask CHATGPT if this is the best solution
        $targets = Target::orderBy('updated_at', 'asc')->get(); // Or a dedicated 'last_checked_at' on Target model

        if ($targets->isEmpty()) {
            $this->consoleInfo('No targets to monitor.');
            return 0;
        }

        foreach ($targets as $target) {
            $this->consoleInfo("Processing target: {$target->url} (ID: {$target->id})");
            $this->checkUptime($target);

            // Check SSL certificate less frequently 
            $latestSslCheck = $target->sslChecks()->latest()->first();
            if (!$latestSslCheck || $latestSslCheck->created_at < Carbon::now()->subHours(23)) {
                $this->consoleLine("  Proceeding with SSL check for {$target->url} (last check older than 23 hours or non-existent).");
                Log::info("Proceeding with SSL check for {$target->url} (last check older than 23 hours or non-existent).");
                $this->checkSslCertificate($target);
            } else {
                $this->consoleLine("  Skipping SSL check for {$target->url} (last check was at {$latestSslCheck->created_at}).");
                Log::info("Skipping SSL check for {$target->url} (last check was at {$latestSslCheck->created_at}).");
            }
            
            // Touch the target's updated_at timestamp to cycle it in the priority
            $target->touch(); 
        }

        $this->consoleInfo('Site monitoring completed.');
        return 0;
    }

    public function checkUptime(Target $target)
    {
        $this->consoleLine("  Checking uptime for: {$target->url}");
        Log::debug("Initiating uptime check for {$target->url}");
        $startTime = microtime(true);
        $status = null;
        $errorMessage = null;

        try {
            $response = Http::timeout(30)->get($target->url);
            $status = $response->status();
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            $status = 0; 
            $errorMessage = 'ConnectionException: ' . $e->getMessage();
            Log::warning("Uptime check failed for {$target->url}: {$errorMessage}");
        } catch (\Exception $e) {
            $status = -1; 
            $errorMessage = 'Exception: ' . $e->getMessage();
            Log::error("Unexpected error during uptime check for {$target->url}: {$errorMessage}");
        }

        $responseTime = round((microtime(true) - $startTime) * 1000);

        StatusLog::create([
            'target_id' => $target->id,
            'status_code' => $status,
            'response_time' => $responseTime,
            'error_message' => $errorMessage,
        ]);

        $this->consoleLine("    Status: {$status}, Response Time: {$responseTime}ms");
        Log::debug("Uptime check for {$target->url} - Status: {$status}, Response Time: {$responseTime}ms");

        $isDown = $status === 0 || $status === -1 || ($status >= 400);
        $user = $target->user;

        if ($isDown) {
            $recentLogs = StatusLog::where('target_id', $target->id)
                                   ->orderBy('created_at', 'desc')
                                   ->take(2)
                                   ->get();

            if ($recentLogs->count() >= 2) {
                $allRecentLogsFailed = $recentLogs->every(function ($log) {
                    return $log->status_code === 0 || $log->status_code === -1 || ($log->status_code >= 400);
                });

                if ($allRecentLogsFailed) {
                    $alertMessage = "Site {$target->url} appears to be down. Last two checks failed. Last status: {$status}.";
                    if ($errorMessage) {
                        $alertMessage .= " Error: " . $errorMessage;
                    }

                    // Send email every time two consecutive failures are detected
                    if ($user) {
                        $this->sendAlertEmail($user, $alertMessage, "Downtime Alert: {$target->url}");
                        Log::info("EMAIL (Downtime): Notified user {$user->email} about consecutive downtime for {$target->url}.");
                    }
                    
                    // Ensure UI alert is created if not already active
                    $this->ensureAlertExists($target, 'downtime', $alertMessage);
                }
            }
        } else { // Site is UP
            // Resolve existing downtime UI alert if any
            $resolvedDowntime = $this->resolveAlert($target, 'downtime', "Site {$target->url} is back up. Status: {$status}, Response Time: {$responseTime}ms.");
            
            if ($resolvedDowntime && $user) {
                $recoveryMessage = "Site {$target->url} is back up. Status: {$status}, Response Time: {$responseTime}ms.";
                $this->sendAlertEmail($user, $recoveryMessage, "Site Recovery: {$target->url}");
                Log::info("EMAIL (Downtime Recovery): Notified user {$user->email} about site recovery for {$target->url}.");
            }
        }
    }

    public function checkSslCertificate(Target $target)
    {
        $this->consoleLine("  Checking SSL certificate for: {$target->url}");
        Log::debug("Initiating SSL check for {$target->url}");

        $urlParts = parse_url($target->url);
        if (!isset($urlParts['host']) || !isset($urlParts['scheme']) || $urlParts['scheme'] !== 'https') {
            $this->consoleLine("    Skipping SSL check: URL is not HTTPS or host is not parseable.");
            Log::info("Skipping SSL check for {$target->url}: URL is not HTTPS or host not parseable.");
            $sslCheck = SslCheck::create([
                'target_id' => $target->id,
                'is_valid' => false,
                'error_message' => 'URL is not HTTPS or host not parseable.',
            ]);
            // Send email every time for this specific failure type
            if ($target->user) {
                $this->sendAlertEmail($target->user, "The SSL certificate for {$target->url} could not be checked because it's not a valid HTTPS URL or the host is not parseable.", "SSL Check Error: {$target->url}");
                Log::info("Notified user about SSL check error (not HTTPS/host not parseable) for {$target->url}.");
            }
            // Ensure UI alert is created if not already active
            $this->ensureAlertExists($target, 'ssl_invalid', "SSL check failed for {$target->url}: URL is not HTTPS or host not parseable.");
            return;
        }

        $host = $urlParts['host'];
        $port = $urlParts['port'] ?? 443;
        $daysWarning = 14; // Days before expiry to warn

        $sslValid = false;
        $daysToExpiry = null;
        $issuedBy = null;
        $expiresAt = null;
        $errorMessage = null;

        try {
            $streamContext = stream_context_create([
                "ssl" => [
                    "capture_peer_cert" => true,
                    "verify_peer" => true,
                    "verify_peer_name" => true,
                    "allow_self_signed" => false,
                    "sni_enabled" => true,
                    "SNI_server_name" => $host,
                    "timeout" => 30,
                ]
            ]);

            $client = @stream_socket_client(
                "ssl://{$host}:{$port}",
                $errno,
                $errstr,
                15, // Connection timeout
                STREAM_CLIENT_CONNECT,
                $streamContext
            );

            if ($client) {
                $certParams = stream_context_get_params($client);
                $peerCert = $certParams['options']['ssl']['peer_certificate'] ?? null;
                fclose($client);

                if ($peerCert) {
                    $certInfo = openssl_x509_parse($peerCert);
                    if ($certInfo && isset($certInfo['validTo_time_t']) && isset($certInfo['issuer']['CN'])) {
                        $sslValid = true; // Basic validity if we got cert info
                        $expiresAt = Carbon::createFromTimestamp($certInfo['validTo_time_t']);
                        $daysToExpiry = Carbon::now()->diffInDays($expiresAt, false); // false = don't get absolute value
                        $issuedBy = $certInfo['issuer']['CN'];

                    } else {
                        $errorMessage = 'Failed to parse certificate details.';
                        Log::warning("SSL check for {$target->url}: {$errorMessage}");
                    }
                } else {
                    $errorMessage = 'Failed to retrieve peer certificate.';
                    Log::warning("SSL check for {$target->url}: {$errorMessage}");
                }
            } else {
                $errorMessage = "Failed to connect for SSL check. Error {$errno}: {$errstr}";
                Log::warning("SSL check connection failed for {$target->url}: {$errorMessage}");
            }
        } catch (\Exception $e) {
            $errorMessage = 'Exception during SSL check: ' . $e->getMessage();
            Log::error("SSL check for {$target->url} threw an exception: {$errorMessage}");
        }

        $sslCheckLog = SslCheck::create([
            'target_id' => $target->id,
            'is_valid' => $sslValid,
            'expires_at' => $expiresAt,
            'days_to_expiry' => $daysToExpiry,
            'issued_by' => $issuedBy,
            'error_message' => $errorMessage,
        ]);

        $this->consoleLine("    SSL Valid: " . ($sslValid ? 'Yes' : 'No') . ", Days to expiry: " . ($daysToExpiry ?? 'N/A'));
        Log::debug("SSL check for {$target->url} - Valid: " . ($sslValid ? 'Yes' : 'No') . ", Days: " . ($daysToExpiry ?? 'N/A') . ($errorMessage ? ", Error: $errorMessage" : ""));
        
        $user = $target->user;

        if (!$sslValid) {
            $emailMessage = "The SSL certificate for {$target->url} is invalid or could not be verified." . ($errorMessage ? " Error: {$errorMessage}" : " Please check the certificate details.");
            $emailSubject = "SSL Invalid Alert: {$target->url}";

            if ($user) {
                $this->sendAlertEmail($user, $emailMessage, $emailSubject);
                Log::info("EMAIL (SSL Invalid): Notified user {$user->email} about invalid SSL for {$target->url}. Message: {$errorMessage}");
            }
            $this->ensureAlertExists($target, 'ssl_invalid', $emailMessage);
            // If it becomes valid, existing 'ssl_expiry' should also be resolved
            $this->resolveAlert($target, 'ssl_expiry');

        } elseif ($daysToExpiry !== null && $daysToExpiry <= $daysWarning) {
            $emailMessage = "The SSL certificate for {$target->url} is expiring in {$daysToExpiry} days (on " . ($expiresAt ? $expiresAt->format('Y-m-d') : 'N/A') . "). Please renew it soon.";
            $emailSubject = "SSL Expiry Warning: {$target->url}";

            if ($user) {
                $this->sendAlertEmail($user, $emailMessage, $emailSubject);
                Log::info("EMAIL (SSL Expiry): Notified user {$user->email} about SSL expiring soon for {$target->url} ({$daysToExpiry} days).");
            }
            $this->ensureAlertExists($target, 'ssl_expiry', $emailMessage);
            // If it's expiring, it's not "invalid" in the sense of a broken chain, so resolve 'ssl_invalid' if it existed.
            $this->resolveAlert($target, 'ssl_invalid', "SSL certificate for {$target->url} is now valid but expiring soon (in {$daysToExpiry} days).");

        } else { // SSL is valid and not expiring soon
            $resolvedInvalid = $this->resolveAlert($target, 'ssl_invalid', "SSL certificate for {$target->url} is now valid.");
            $resolvedExpiry = $this->resolveAlert($target, 'ssl_expiry', "SSL certificate for {$target->url} is now valid and not expiring soon (expires in {$daysToExpiry} days).");

            if (($resolvedInvalid || $resolvedExpiry) && $user) {
                $recoveryMessage = "The SSL certificate issues for {$target->url} have been resolved. The certificate is valid and expires in {$daysToExpiry} days.";
                $this->sendAlertEmail($user, $recoveryMessage, "SSL Certificate Healthy: {$target->url}");
                Log::info("EMAIL (SSL Healthy): Notified user {$user->email} about SSL resolution for {$target->url}.");
            }
        }
    }

    /**
     * Ensures an alert of a specific type exists for the target, creating it if not.
     */
    private function ensureAlertExists(Target $target, string $type, string $message): void
    {
        $existingAlert = Alert::where('target_id', $target->id)
                              ->where('type', $type)
                              ->whereNull('resolved_at')
                              ->first();

        if (!$existingAlert) {
            Alert::create([
                'target_id' => $target->id,
                'user_id' => $target->user_id,
                'type' => $type,
                'message' => $message,
            ]);
            $this->consoleWarn("    ALERT CREATED ({$type}): {$message}");
            Log::warning("UI Alert created ({$type}) for {$target->url}: {$message}");
        }
    }

    /**
     * Resolves an active alert of a specific type for the target.
     * Returns true if an alert was resolved, false otherwise.
     */
    private function resolveAlert(Target $target, string $type, ?string $resolutionMessagePrefix = null): bool
    {
        $alert = Alert::where('target_id', $target->id)
                        ->where('type', $type)
                        ->whereNull('resolved_at')
                        ->first();

        if ($alert) {
            $alert->update(['resolved_at' => now()]);
            $logMsg = ($resolutionMessagePrefix ?? "Alert {$type} for {$target->url}") . " has been resolved.";
            $this->consoleInfo("    INFO: {$logMsg}");
            Log::info($logMsg);
            return true;
        }
        return false;
    }

    protected function sendAlertEmail(User $user, string $message, string $subject)
    {
        try {
            if ($user->email && $user->name) {
                 Mail::to($user->email)->send(new SiteAlertMail($user, $message, $subject));
                 $this->consoleInfo("    Email sent to {$user->email} regarding: {$subject}");
                 Log::info("Alert email queued for {$user->email} - Subject: {$subject}");
            } else {
                Log::warning("Skipping email for user ID {$user->id} due to missing email or name.");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send alert email to user ID {$user->id} ({$user->email}): " . $e->getMessage());
            $this->consoleError("    Failed to send alert email to {$user->email}: " . $e->getMessage());
        }
    }
}
