## 2024-05-15 - Add Keyboard Focus Styles
**Learning:** Found that many interactive elements (buttons, links) lack proper `focus-visible` styles, making keyboard navigation difficult and inaccessible. Relying only on `hover` or default browser focus is insufficient for a polished, accessible app.
**Action:** Adding global `focus-visible` styles in `app.css` to ensure consistent and clear keyboard focus rings across all interactive elements.
## 2024-06-09 - Form Input Labels and Screen Reader Context
**Learning:** Found that multiple inputs across the app relied solely on `placeholder` attributes without `<label>` elements or `aria-label`s, breaking accessibility and usability. Also noticed decorative SVGs without `aria-hidden="true"`.
**Action:** Always ensure inputs have associated labels or `aria-label`s, and hide decorative SVG icons from screen readers using `aria-hidden="true"`.
