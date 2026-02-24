(() => {
  const launcher = document.getElementById("tecci-chatbot-launcher");
  const win = document.getElementById("tecci-chatbot-window");
  const closeBtn = document.getElementById("tecci-chatbot-close");
  const minimiseBtn = document.getElementById("tecci-chatbot-minimise");
  const expandBtn = document.getElementById("tecci-chatbot-expand");
  const form = document.getElementById("tecci-chatbot-form");
  const input = document.getElementById("tecci-chatbot-input");
  const messages = document.getElementById("tecci-chatbot-messages");

  if (!launcher || !win || !messages) return;

  const replyMap = {
    refunds:
      "Refunds: You can request a refund within our return window. Please go to the Returns/Refunds page or contact support with your order number.",
    stock:
      "Product stock: Tell me the product name and I’ll help you check availability. (Backend connection will be added next.)",
    forgot_password:
      "Forgot password: Use the password reset flow on the login page. If you still can’t access your account, contact support.",
    forgot_email:
      "Forgot email: If you used another email, contact support with your name + order details so we can help verify your account."
  };

  function openChat() {
    win.classList.remove("tecci-chatbot__window--hidden");
    input?.focus();
  }

  function closeChat() {
    win.classList.add("tecci-chatbot__window--hidden");
    win.classList.remove("tecci-chatbot__window--expanded");
  }

  function toggleExpand() {
    win.classList.toggle("tecci-chatbot__window--expanded");
  }

  function addMsg(text, who = "bot") {
    const row = document.createElement("div");
    row.className = `tecci-chatbot__msg tecci-chatbot__msg--${who}`;

    const bubble = document.createElement("div");
    bubble.className = "tecci-chatbot__bubble";
    bubble.textContent = text;

    row.appendChild(bubble);
    messages.appendChild(row);
    messages.scrollTop = messages.scrollHeight;
  }

  launcher.addEventListener("click", () => {
    if (win.classList.contains("tecci-chatbot__window--hidden")) openChat();
    else closeChat();
  });

  closeBtn?.addEventListener("click", closeChat);
  minimiseBtn?.addEventListener("click", closeChat);
  expandBtn?.addEventListener("click", toggleExpand);

  messages.addEventListener("click", (e) => {
    const btn = e.target.closest(".tecci-chatbot__chip");
    if (!btn) return;
    const action = btn.getAttribute("data-action");

    addMsg(btn.textContent, "user");
    setTimeout(() => addMsg(replyMap[action] || "How can I help?"), 300);
  });

  form?.addEventListener("submit", (e) => {
    e.preventDefault();
    const text = (input?.value || "").trim();
    if (!text) return;

    addMsg(text, "user");
    input.value = "";

    setTimeout(() => addMsg("Thanks — I can help with refunds, stock, and account issues. Choose an option above.", "bot"), 350);
  });
})();
