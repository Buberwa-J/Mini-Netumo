<x-mail::message>
# {{ $greeting }}

{{ $alertMessage }}

@isset($url)
<x-mail::button :url="$url">
View Dashboard
</x-mail::button>
@endisset

{{ $salutation }}
</x-mail::message>
