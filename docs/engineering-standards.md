# Engineering Standards (WordPress Plugin)
- Follow WordPress Coding Standards (WPCS).
- No direct output without escaping (`esc_html`, `esc_attr`, `wp_kses`).
- Verify nonces + capability checks for any admin actions.
- I18n all user-facing strings with `__()` / `esc_html__()`; text domain `zenesis-demo`.
- Prefer actions/filters; avoid globals where possible.
- Target PHP 8.1+; avoid deprecated WP APIs.
