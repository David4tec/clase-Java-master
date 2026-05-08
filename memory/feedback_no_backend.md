---
name: No Backend Changes
description: User wants frontend-only work; do not touch controllers, models, or migrations
type: feedback
---

Do not modify any PHP backend files (controllers, models, migrations, seeders) unless explicitly asked.

**Why:** User stated "el back ya esta completamente terminado, no quiero que le muevas nada al back" — the CRM/business logic is done and should not be touched.

**How to apply:** Work only with Blade views, CSS, JS, and minimal Route::view() declarations. If backend changes are truly required to implement a feature, ask the user first before proceeding.
