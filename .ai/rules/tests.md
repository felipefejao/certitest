---
paths:
  - 'tests/**'
---

# Tests

## Send Accept-Language in feature tests
SetLocale middleware detects the browser language from Accept-Language, and Symfony's Request::create defaults it to en-us,en — so test requests render English. Tests asserting Portuguese UI strings must call ->withHeader('Accept-Language', 'pt-BR'). Supported locales: pt_BR (default), en, de, fr; translations live in lang/{locale}/ui.php.
