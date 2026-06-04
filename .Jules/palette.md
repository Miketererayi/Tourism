## 2024-05-15 - Add Keyboard Focus Styles
**Learning:** Found that many interactive elements (buttons, links) lack proper `focus-visible` styles, making keyboard navigation difficult and inaccessible. Relying only on `hover` or default browser focus is insufficient for a polished, accessible app.
**Action:** Adding global `focus-visible` styles in `app.css` to ensure consistent and clear keyboard focus rings across all interactive elements.

## 2024-06-04 - Missing Accessible Names on Inputs
**Learning:** Found that many decorative or inline inputs (like the newsletter signup and hero search) lacked `<label>` elements or `aria-label` attributes. Without these, screen readers announce them genericly (e.g., "edit text"), leaving users confused about the input's purpose.
**Action:** Added `aria-label` attributes to these inputs to ensure they have an accessible name, making the UI fully navigable and understandable via screen readers.
