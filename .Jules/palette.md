## 2024-05-15 - Add Keyboard Focus Styles
**Learning:** Found that many interactive elements (buttons, links) lack proper `focus-visible` styles, making keyboard navigation difficult and inaccessible. Relying only on `hover` or default browser focus is insufficient for a polished, accessible app.
**Action:** Adding global `focus-visible` styles in `app.css` to ensure consistent and clear keyboard focus rings across all interactive elements.

## 2024-06-08 - Add Skip to Main Content Link
**Learning:** Discovered that the application was missing a "Skip to main content" link, making keyboard and screen-reader navigation tedious as users had to tab through the entire navigation menu on every page load.
**Action:** Implemented a visually hidden skip link at the start of the document body that becomes visible on focus, directing users straight to the `<main>` content area. Utilized existing Tailwind utility classes (`sr-only`, `focus:not-sr-only`, etc.) to keep changes minimal and avoid custom CSS.
