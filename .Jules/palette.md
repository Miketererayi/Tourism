## 2024-05-15 - Add Keyboard Focus Styles
**Learning:** Found that many interactive elements (buttons, links) lack proper `focus-visible` styles, making keyboard navigation difficult and inaccessible. Relying only on `hover` or default browser focus is insufficient for a polished, accessible app.
**Action:** Adding global `focus-visible` styles in `app.css` to ensure consistent and clear keyboard focus rings across all interactive elements.
## 2024-05-18 - Missing ARIA Labels on Placeholder-Only Inputs
**Learning:** Found multiple instances where form inputs (search bars, newsletter signups, quick contact forms) rely solely on the `placeholder` attribute for context and lack an explicit `<label>` or `aria-label`. This makes them inaccessible to screen readers.
**Action:** Always verify that every `<input>` and `<textarea>` either has a linked `<label>` or an `aria-label` attribute if a visual label breaks the design constraints.
