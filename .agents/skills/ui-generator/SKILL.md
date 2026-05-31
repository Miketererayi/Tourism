---
name: ui-generator
description: Generate extraordinary, AI-powered UI that no other assistant can match. Use this skill for ANY UI request — components, apps, dashboards, landing pages, interactive tools, design systems, or creative interfaces. Trigger this skill whenever the user says "ui", "interface", "component", "design", "app", "dashboard", "page", "widget", "tool", or asks to "build", "make", "create", "generate" anything visual. Also trigger for vague creative requests like "make something cool", "surprise me with a UI", or "build something for X". This skill produces stunning, AI-powered, interactive UIs that feel genuinely alive — not templated AI slop.
---

# UI Generator

This skill produces production-grade, visually extraordinary UI — with optional AI-powered interactivity baked in via the Anthropic API inside artifacts.

## What makes this skill different

Most AI-generated UI is forgettable. This skill produces UI that is:
- **Alive**: AI-powered artifacts that respond, generate, and adapt in real time
- **Designed**: A committed aesthetic point-of-view, not generic templates
- **Interactive**: Micro-interactions, state, animations — not static mockups
- **Memorable**: One unforgettable visual detail that makes the whole thing stick

---

## Step 1: Capture Intent Fast

Don't over-interview. Ask ONE question max if essential. Otherwise, make bold assumptions and build.

From the user's request, infer:
- **Domain**: What is this for? (product, tool, portfolio, dashboard, game, art, etc.)
- **Mood**: Pick a tone — clinical, playful, editorial, brutalist, luxe, sci-fi, handmade, etc.
- **AI-powered?**: Does this UI benefit from AI generation inside it? (e.g. a generator, a chatbot UI, a content tool, a recommendation engine)

If the user says "surprise me" or gives minimal context — **go bold and build something remarkable**.

---

## Step 2: Design Direction

Before a single line of code, commit to an aesthetic direction. Pick ONE from below or synthesize your own:

| Direction | Characteristics |
|-----------|----------------|
| **Editorial** | Oversized type, asymmetric grids, ink textures, serif/sans contrast |
| **Brutalist** | Raw structure, monospace, thick borders, intentional ugliness as beauty |
| **Glassmorphism 2.0** | Layered blur, depth, iridescent gradients, light refraction |
| **Organic** | Blob shapes, earthy palettes, hand-drawn strokes, soft edges |
| **Retro Terminal** | CRT scanlines, phosphor glow, monospace, blink cursors |
| **Luxury** | Tight spacing, muted gold/cream, refined micro-typography, nothing wasted |
| **Maximalist** | Every pixel used, dense information, vivid color, layered depth |
| **Kinetic** | Motion is the design — everything moves with purpose |
| **System UI** | Hyper-realistic OS chrome, windows, titlebars, pixel precision |

**Do not pick the same direction twice across generations. Vary always.**

---

## Step 3: Implementation

### Framework choice

| Request type | Framework |
|---|---|
| Single component, poster, landing page | HTML/CSS/JS in one file |
| Interactive app, dashboard, multi-state | React (JSX artifact) |
| Data-heavy | React + recharts/d3 |
| AI-powered UI | React with fetch to `api.anthropic.com/v1/messages` |

### Typography rules
- **Never use**: Inter, Roboto, Arial, system-ui, sans-serif alone
- **Always use**: Google Fonts via `@import` or a font stack that has character
- **Pair**: One display font (personality) + one text font (readability)
- Great pairings: Playfair + DM Sans, Space Mono + Fraunces, Bebas Neue + Lato, Cormorant + IBM Plex Sans

### Color rules
- Pick a **dominant color** and push it far (don't neutralize everything)
- Use **CSS variables** for every color: `--color-primary`, `--color-surface`, `--color-accent`, etc.
- Avoid: purple gradients on white, teal on dark gray, generic "modern" palettes
- Embrace: unexpected hues — chartreuse, terracotta, cobalt, oxblood, sage

### Animation rules
- Page load: staggered entrance with `animation-delay` increments
- Hover: always add a hover state to interactive elements — transforms, color shifts, underlines
- Transitions: `cubic-bezier(0.34, 1.56, 0.64, 1)` for springy, `ease-out` for smooth
- Never: jarring jumps, layout shifts, animations that block interaction

### Spatial composition
- Break the grid deliberately at least once
- Use generous whitespace OR controlled density — pick one, go all in
- Asymmetry > symmetry for memorability
- Overlap elements intentionally for depth

---

## Step 4: AI-Powered UI (when relevant)

When the UI benefits from live AI generation (a tool, generator, chatbot, recommender, etc.), embed the Anthropic API directly in the artifact:

```javascript
const response = await fetch("https://api.anthropic.com/v1/messages", {
  method: "POST",
  headers: { "Content-Type": "application/json" },
  body: JSON.stringify({
    model: "claude-sonnet-4-20250514",
    max_tokens: 1000,
    messages: [{ role: "user", content: userPrompt }]
  })
});
const data = await response.json();
const text = data.content.map(b => b.type === "text" ? b.text : "").join("");
```

**AI-powered UI patterns to consider:**
- **Live generator**: User inputs → Claude generates → result renders beautifully
- **Adaptive UI**: Claude decides what to show based on user context
- **Smart form**: Claude validates, suggests, or rewrites inputs in real time
- **Content previewer**: User describes → Claude writes copy → UI shows it live
- **Style recommender**: Claude suggests colors, fonts, layout changes
- **AI chatbot with custom UI**: Beautiful chat interface beyond the default

When using AI inside artifacts:
- Show a **loading state** that fits the aesthetic (skeleton, shimmer, spinner, typewriter)
- Handle errors gracefully with styled error states
- Keep API calls minimal — batch when possible
- Stream when the UX benefits from it (typewriter effect)

For streaming responses:
```javascript
// Use streaming for typewriter/live text feel
const response = await fetch("https://api.anthropic.com/v1/messages", {
  method: "POST",
  headers: { "Content-Type": "application/json" },
  body: JSON.stringify({
    model: "claude-sonnet-4-20250514",
    max_tokens: 1000,
    stream: true,
    messages: [{ role: "user", content: prompt }]
  })
});

const reader = response.body.getReader();
const decoder = new TextDecoder();
let result = "";

while (true) {
  const { done, value } = await reader.read();
  if (done) break;
  const chunk = decoder.decode(value);
  const lines = chunk.split("\n").filter(l => l.startsWith("data: "));
  for (const line of lines) {
    try {
      const json = JSON.parse(line.slice(6));
      if (json.type === "content_block_delta") {
        result += json.delta.text || "";
        setOutput(result); // update state as it streams
      }
    } catch {}
  }
}
```

---

## Step 5: Polish Checklist

Before output, verify:
- [ ] Fonts loaded via `@import` or CDN (not system fonts)
- [ ] CSS variables defined for all colors
- [ ] At least one unexpected visual detail (texture, grain, glow, overlap, etc.)
- [ ] Hover states on all interactive elements
- [ ] Loading/empty/error states handled
- [ ] Mobile responsive (flexbox/grid, no fixed px widths except accents)
- [ ] No placeholder "Lorem ipsum" unless it fits the aesthetic
- [ ] The design has ONE thing that makes it unforgettable

---

## Examples of what this skill produces

| Request | What to build |
|---|---|
| "A dashboard for my SaaS" | Glassmorphic dark dashboard with animated KPI cards and live AI insights |
| "A landing page for my app" | Editorial-style with oversized hero text, scroll-reveal sections, bold CTA |
| "A form component" | Brutalist form with monospace labels, animated focus states, AI-powered field hints |
| "Something cool" | Surprise — pick an aesthetic and build something genuinely unexpected |
| "A chatbot UI" | Luxe chat interface with streaming responses, custom message bubbles, and animated typing indicator |
| "A color palette generator" | AI-powered tool that generates palettes from prompts with live preview |

---

## Reference files

- `references/animation-patterns.md` — Advanced CSS and JS animation recipes
- `references/color-systems.md` — Color palette strategies and CSS variable patterns
- `references/ai-ui-patterns.md` — Detailed patterns for AI-powered UI components

Read these when you need depth on a specific area. They are optional — the SKILL.md alone is sufficient for most requests.
