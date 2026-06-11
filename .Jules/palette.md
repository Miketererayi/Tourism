## 2024-05-15 - Add Keyboard Focus Styles
**Learning:** Found that many interactive elements (buttons, links) lack proper `focus-visible` styles, making keyboard navigation difficult and inaccessible. Relying only on `hover` or default browser focus is insufficient for a polished, accessible app.
**Action:** Adding global `focus-visible` styles in `app.css` to ensure consistent and clear keyboard focus rings across all interactive elements.
## 2024-05-16 - Enforce Explicit Form Labels
**Learning:** Found that inline forms and search inputs across the application relied heavily on placeholders without explicit labels, creating a poor experience for screen reader users and violating accessibility guidelines.
**Action:** Adding `<label class="sr-only">` with explicitly matching `for` and `id` attributes to all form inputs to ensure they are fully accessible to screen readers without changing the visual layout.
