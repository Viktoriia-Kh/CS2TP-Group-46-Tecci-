<div id="tecci-chatbot" class="tecci-chatbot">

  <!-- Floating launcher -->
  <button id="tecci-chatbot-launcher" class="tecci-chatbot__launcher" type="button" aria-label="Open Tecci chatbot">
    <i class="fa-solid fa-robot"></i>
  </button>

  
  <section id="tecci-chatbot-window" class="tecci-chatbot__window tecci-chatbot__window--hidden" aria-label="Tecci chatbot window">
    <header class="tecci-chatbot__header">
      <div class="tecci-chatbot__title">
        <div class="tecci-chatbot__avatar">
          <i class="fa-solid fa-robot"></i>
        </div>
        <div>
          <div class="tecci-chatbot__name">Tecci Assistant</div>
          <div class="tecci-chatbot__status" id="tecci-chatbot-status">Online</div>
        </div>
      </div>

      <div class="tecci-chatbot__controls">
        <button id="tecci-chatbot-expand" class="tecci-chatbot__iconbtn" type="button" aria-label="Expand chatbot">
          <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
        </button>
        <button id="tecci-chatbot-minimise" class="tecci-chatbot__iconbtn" type="button" aria-label="Minimise chatbot">
          <i class="fa-solid fa-minus"></i>
        </button>
        <button id="tecci-chatbot-close" class="tecci-chatbot__iconbtn" type="button" aria-label="Close chatbot">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
    </header>

    <div id="tecci-chatbot-messages" class="tecci-chatbot__messages">
      <div class="tecci-chatbot__msg tecci-chatbot__msg--bot">
        <div class="tecci-chatbot__bubble">
          Hi! I’m the Tecci Assistant 🤖<br>
          Pick an option below or type your question.
        </div>
      </div>

      <div class="tecci-chatbot__quick">
        <button class="tecci-chatbot__chip" type="button" data-action="refunds">Refunds</button>
        <button class="tecci-chatbot__chip" type="button" data-action="stock">Product stock</button>
        <button class="tecci-chatbot__chip" type="button" data-action="forgot_password">Forgot password</button>
        <button class="tecci-chatbot__chip" type="button" data-action="forgot_email">Forgot email</button>
      </div>
    </div>

    <form id="tecci-chatbot-form" class="tecci-chatbot__form" autocomplete="off">
      <input id="tecci-chatbot-input" class="tecci-chatbot__input" type="text" placeholder="Type a message…" />
      <button class="tecci-chatbot__send" type="submit" aria-label="Send message">
        <i class="fa-solid fa-paper-plane"></i>
      </button>
    </form>
  </section>

</div>
