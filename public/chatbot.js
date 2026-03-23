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

  const API = {
    categories: "/chatbot/categories",
    faqsByCategory: (id) => `/chatbot/categories/${id}/faqs`,
    faqAnswer: (id) => `/chatbot/faqs/${id}`,
  };

  let currentCategoryId = null;
  let currentCategoryTitle = null;

  function openChat() {
    win.classList.remove("tecci-chatbot__window--hidden");
    input?.focus();

    messages.innerHTML = "";
    addMsg("Hi 👋 Choose a topic:", "bot");
    loadCategories().catch((err) => {
      console.error("Failed to load categories:", err);
      addMsg("Sorry — I couldn’t load topics right now.", "bot");
    });
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

  function clearChips() {
    messages.querySelectorAll(".tecci-chatbot__chips").forEach((chips) => {
      chips.parentElement?.remove();
    });
  }

  function addChips(chips = []) {
    const row = document.createElement("div");
    row.className = "tecci-chatbot__msg tecci-chatbot__msg--bot";

    const wrap = document.createElement("div");
    wrap.className = "tecci-chatbot__chips";

    chips.forEach((c) => {
      const btn = document.createElement("button");
      btn.type = "button";
      btn.className = "tecci-chatbot__chip";
      btn.textContent = c.label;

      btn.dataset.action = c.action;

      if (c.categoryId != null) btn.dataset.categoryId = String(c.categoryId);
      if (c.categoryTitle != null) btn.dataset.categoryTitle = String(c.categoryTitle);
      if (c.faqId != null) btn.dataset.faqId = String(c.faqId);

      wrap.appendChild(btn);
    });

    row.appendChild(wrap);
    messages.appendChild(row);
    messages.scrollTop = messages.scrollHeight;
  }

  async function fetchJson(url) {
    const res = await fetch(url, { headers: { Accept: "application/json" } });
    if (!res.ok) throw new Error(`Request failed: ${res.status}`);
    return res.json();
  }

  async function loadCategories() {
    currentCategoryId = null;
    currentCategoryTitle = null;

    clearChips();

    const cats = await fetchJson(API.categories);

    if (!Array.isArray(cats) || cats.length === 0) {
      addMsg("No topics available right now.", "bot");
      return;
    }

    addChips(
      cats.map((c) => ({
        label: c.title,
        action: "open_category",
        categoryId: c.id,
        categoryTitle: c.title,
      }))
    );
  }

  async function loadFaqs(categoryId, categoryTitle) {
    currentCategoryId = categoryId;
    currentCategoryTitle = categoryTitle;

    clearChips();

    const data = await fetchJson(API.faqsByCategory(categoryId));
    const faqs = data?.faqs || [];

    if (!Array.isArray(faqs) || faqs.length === 0) {
      addMsg(`${categoryTitle}: No FAQs found yet.`, "bot");
      addChips([{ label: "Back to topics", action: "back_topics" }]);
      return;
    }

    addMsg(`${categoryTitle} — choose a question:`, "bot");

    addChips([
      ...faqs.map((f) => ({
        label: f.question,
        action: "open_faq",
        faqId: f.id,
      })),
      { label: "Back to topics", action: "back_topics" },
    ]);
  }

  async function loadAnswer(faqId) {
    clearChips();

    const data = await fetchJson(API.faqAnswer(faqId));

    addMsg(data.answer || "Sorry — I couldn’t find that answer.", "bot");

    addChips([
      {
        label: "Back to questions",
        action: "back_questions",
        categoryId: data?.category?.id ?? currentCategoryId,
        categoryTitle: data?.category?.title ?? currentCategoryTitle,
      },
      { label: "Back to topics", action: "back_topics" },
    ]);
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
    const label = btn.textContent?.trim() || "Option";

    addMsg(`Selected: ${label}`, "user");

    if (action === "open_category") {
      const categoryId = Number(btn.dataset.categoryId);
      const categoryTitle = btn.dataset.categoryTitle || label;

      loadFaqs(categoryId, categoryTitle).catch(() =>
        addMsg("Sorry — I couldn’t load FAQs right now.", "bot")
      );
      return;
    }

    if (action === "open_faq") {
      const faqId = Number(btn.dataset.faqId);

      loadAnswer(faqId).catch(() =>
        addMsg("Sorry — I couldn’t load that answer right now.", "bot")
      );
      return;
    }

    if (action === "back_topics") {
      addMsg("Choose a topic:", "bot");
      loadCategories().catch(() => addMsg("Sorry — I couldn’t load topics right now.", "bot"));
      return;
    }

    if (action === "back_questions") {
      const categoryId = Number(btn.dataset.categoryId || currentCategoryId);
      const categoryTitle = btn.dataset.categoryTitle || currentCategoryTitle || "Topic";

      if (!categoryId) {
        addMsg("Choose a topic:", "bot");
        loadCategories().catch(() => addMsg("Sorry — I couldn’t load topics right now.", "bot"));
        return;
      }

      loadFaqs(categoryId, categoryTitle).catch(() =>
        addMsg("Sorry — I couldn’t load FAQs right now.", "bot")
      );
      return;
    }

    addMsg("How can I help?", "bot");
  });

  form?.addEventListener("submit", (e) => {
    e.preventDefault();
    const text = (input?.value || "").trim();
    if (!text) return;

    addMsg(text, "user");
    input.value = "";

    setTimeout(() => {
addMsg(
  `${data?.category?.title ?? currentCategoryTitle}: ${data.answer || "Sorry — I couldn’t find that answer."}`,
  "bot"
);      loadCategories().catch(() => addMsg("Sorry — I couldn’t load topics right now.", "bot"));
    }, 250);
  });
})();