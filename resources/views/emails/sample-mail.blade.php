@component('mail::message')
# Hello

{{ $details['author'] }} has invited you to become an editor for the post {{ $details['post'] }}.

@component('mail::button', ['url' =>  $details['url']])
Accept Invitation
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
