## 2024-05-15 - Add Keyboard Focus Styles
**Learning:** Found that many interactive elements (buttons, links) lack proper `focus-visible` styles, making keyboard navigation difficult and inaccessible. Relying only on `hover` or default browser focus is insufficient for a polished, accessible app.
**Action:** Adding global `focus-visible` styles in `app.css` to ensure consistent and clear keyboard focus rings across all interactive elements.

## 2024-06-13 - Add Accessible Labels to Placeholder-Only Inputs and Preserve Form State
**Learning:** Found that placeholder-only inputs across the site (e.g. newsletter, search) lack accessible labels, rendering them inaccessible to screen readers. In addition, the "Plan Your Visit" form on the place details page lacks proper state preservation and inline validation feedback, causing a poor UX upon submission errors.
**Action:** Added `aria-label` to all placeholder-only inputs globally, and added `value="{{ old('...') }}"` and `@error` feedback blocks for the plan-visit form.
