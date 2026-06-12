## 2026-06-12 - Auditing Placeholder-Only Inputs
**Learning:** Inputs that rely solely on `placeholder` text or adjacent icons without a visible `<label>` are inaccessible to screen reader users. This pattern is common in search bars and minimalist contact forms.
**Action:** Always audit form inputs for proper labeling. If a visual label breaks the design, add an `aria-label` attribute or an `sr-only` label to ensure the input's purpose is announced to assistive technologies.
