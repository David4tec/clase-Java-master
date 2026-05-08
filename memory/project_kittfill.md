---
name: Kittfill Storefront Project
description: Laravel 12 merch store with CRM admin; full Kittfill brand frontend built with Tailwind + Alpine.js
type: project
---

Laravel 12 app at c:\Users\dgonz\Downloads\claseJava-master. Combines a public merchandise storefront (brand: Kittfill) with a CRM admin panel.

**Why:** Student/dev project to practice full-stack web dev with a real-world design.

**Frontend stack:** Blade templates, Tailwind CSS v3, Alpine.js, Vite.

**Brand colors:** Nav gradient `#0f2460 → #1d4ed8`, page background `#c9d1ea`, card secondary `#b8c2dc`.

**Key views created (2026-04-12):**
- `layouts/storefront.blade.php` — main public layout with Kittfill nav + footer
- `layouts/guest.blade.php` — auth pages layout with Kittfill nav
- `home.blade.php` — hero carousel (Alpine.js) + New Arrivals + Shop All sections
- `auth/login.blade.php` + `auth/register.blade.php` — redesigned with brand style
- `storefront/shop.blade.php` — product grid with category filter
- `storefront/product.blade.php` — product detail with model selector + suggested products
- `storefront/cart.blade.php` — interactive cart with Alpine.js qty stepper
- `storefront/checkout.blade.php` — checkout with payment form + shipping details

**Routes added to web.php:** `/shop`, `/cart`, `/checkout`, `/product/{slug?}` (view-only, no controller logic).

**How to apply:** When adding features, follow the existing brand: blue gradient nav, periwinkle bg, white rounded cards, `kf-btn` for primary buttons.
