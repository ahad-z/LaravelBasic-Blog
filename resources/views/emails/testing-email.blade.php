@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => $url])
verification
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

