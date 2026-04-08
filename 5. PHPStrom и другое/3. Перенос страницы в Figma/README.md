Сперва надо получить captureId и endpoint, для этого нужен сервис с подключением к Figma MCP (например Codex) и ссылка на дизайн Figma
Например 
```
Capture https://rolapp.ru/contacts/ into existing Figma file https://www.figma.com/design/JzS2xENQbOXHXZ1AG7Mfwy/Untitled?node-id=0-1
```

Вставить в консоль captureId и endpoint подставить из предыдущего пункта

```JS
(async () => {
  const captureId = 'ТВОЙ_CAPTURE_ID';
  const endpoint = `https://mcp.figma.com/mcp/capture/${captureId}/submit`;

  if (!window.figma?.captureForDesign) {
    const r = await fetch('https://mcp.figma.com/mcp/html-to-design/capture.js');
    const code = await r.text();
    const s = document.createElement('script');
    s.textContent = code;
    document.head.appendChild(s);
    await new Promise(res => setTimeout(res, 800));
  }

  const result = await window.figma.captureForDesign({
    captureId,
    endpoint,
    selector: 'body'
  });

  console.log(result);
})();

```