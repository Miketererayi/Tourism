## 2024-05-15 - Add Keyboard Focus Styles
**Learning:** Found that many interactive elements (buttons, links) lack proper `focus-visible` styles, making keyboard navigation difficult and inaccessible. Relying only on `hover` or default browser focus is insufficient for a polished, accessible app.
**Action:** Adding global `focus-visible` styles in `app.css` to ensure consistent and clear keyboard focus rings across all interactive elements.

## 2024-05-16 - Accessible Inputs without Labels
**Learning:** Forms that rely exclusively on `placeholder` attributes for visual context (e.g., newsletter subscriptions or compact sidebar forms) fail screen reader accessibility because they lack an explicitly associated `<label>`.
**Action:** When a visible `<label>` breaks the desired design, always add an `aria-label` attribute directly to the `<input>` or `<textarea>` so that assistive technologies can still identify the field's purpose.
