@component('mail::message')
# Introduction

This is your password Change link!

@component('mail::button', ['url' => $url])
verification
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

