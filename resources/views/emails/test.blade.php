<x-mail::message>
# Integração de email configurada

Este é um email de teste enviado através da conta Google Workspace configurada no **{{ config('app.name') }}**.

<x-mail::panel>
Mailer: **{{ config('mail.default') }}**<br>
Enviado em: {{ now()->format('d/m/Y H:i:s') }}
</x-mail::panel>

<x-mail::button :url="config('app.url')">
Aceder ao {{ config('app.name') }}
</x-mail::button>

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>
