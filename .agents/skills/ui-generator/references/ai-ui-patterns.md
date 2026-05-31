# AI-Powered UI Patterns

## Pattern 1: Prompt-to-UI Generator
User types a description → Claude generates a full HTML/React component → renders live in the artifact.

```jsx
const [prompt, setPrompt] = useState("");
const [output, setOutput] = useState("");
const [loading, setLoading] = useState(false);

async function generate() {
  setLoading(true);
  const res = await fetch("https://api.anthropic.com/v1/messages", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      model: "claude-sonnet-4-20250514",
      max_tokens: 1000,
      system: "You are a UI designer. Output only clean HTML with inline styles. No markdown, no explanations.",
      messages: [{ role: "user", content: prompt }]
    })
  });
  const data = await res.json();
  setOutput(data.content.find(b => b.type === "text")?.text || "");
  setLoading(false);
}
```

## Pattern 2: AI Content Slots
Static UI shell with AI-filled content areas — headlines, copy, labels generated on load.

```javascript
async function fillContent(slots) {
  const res = await fetch("https://api.anthropic.com/v1/messages", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      model: "claude-sonnet-4-20250514",
      max_tokens: 1000,
      system: "Return only a JSON object with keys matching the slots provided. No markdown.",
      messages: [{ role: "user", content: `Fill these UI slots for a ${context}: ${JSON.stringify(slots)}` }]
    })
  });
  const data = await res.json();
  return JSON.parse(data.content.find(b => b.type === "text")?.text || "{}");
}
```

## Pattern 3: Smart Recommender
User interacts → Claude analyzes state → suggests next action or content.

Keep conversation history in state and send full history each call.

## Pattern 4: Live Validation / Coaching
As user fills a form, Claude reviews input and provides feedback inline.
Debounce calls to avoid hammering the API (500ms delay after last keystroke).

## Error handling template
```javascript
try {
  const res = await fetch(/* ... */);
  if (!res.ok) throw new Error(`API error ${res.status}`);
  const data = await res.json();
  if (data.error) throw new Error(data.error.message);
  // process data
} catch (err) {
  setError(err.message);
  setLoading(false);
}
```

## Loading state best practices
- Show skeleton matching the shape of the expected output
- For text: use a typewriter cursor (blinking `|`) while waiting
- Never use a spinner alone — pair with a contextual message
- Disable inputs during loading to prevent double-submit
