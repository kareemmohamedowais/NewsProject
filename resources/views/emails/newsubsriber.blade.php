<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="route('frontend.index')">
visit our website
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
