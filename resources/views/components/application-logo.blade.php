<svg viewBox="0 0 100 60" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    {{--
        Netumo Clone - Uptime Monitor Icon
        Original design by AI (adapted by [Your Name/Project Name])
        - Main pulse line is designed to inherit color via `currentColor`.
        - Status dot is explicitly green.
    --}}
    <title>Uptime Monitor Icon</title>

    <!-- Pulse line -->
    <path d="M5 30
             L20 30
             L28 15
             L38 45
             L45 25
             L52 30
             L65 30"
          stroke="currentColor" {{-- This will take the text color (e.g., from a Tailwind class) --}}
          stroke-width="4"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round"/>

    <!-- Status Dot (Green for 'Up') -->
    <circle cx="72" cy="30" r="6" fill="#28a745" /> {{-- Explicitly green --}}
    <!-- Optional: White outline for dot if needed, or make it contrast with background -->
    {{-- <circle cx="72" cy="30" r="6" fill="#28a745" stroke="#FFFFFF" stroke-width="1.5"/> --}}
    <!-- Optional: Inner subtle highlight for the dot -->
    {{-- <circle cx="72" cy="30" r="3" fill="#FFFFFF" fill-opacity="0.3"/> --}}
</svg>