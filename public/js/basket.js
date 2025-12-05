document.addEventListener("DOMContentLoaded", function() {
    console.log("✅ basket.js loaded successfully");

    const applyButton = document.getElementById('apply-btn');
    const inputField = document.getElementById('discount-input');
    const messageArea = document.getElementById('message-area');
    const priceElement = document.getElementById('checkout-total'); 

    // STATE TRACKING: Keep track if discount is used
    let discountApplied = false;

    if (!priceElement) {
        console.error("❌ Error: Could not find 'checkout-total'");
        return;
    }

    applyButton.addEventListener('click', function() {
      // CHECK: If already applied, stop immediately
      if (discountApplied) {
          messageArea.textContent = "A discount is already applied!";
          messageArea.style.color = "#dc3545"; // Red color
          return; 
      }

      let currentPriceText = priceElement.innerText;
      let cleanPrice = currentPriceText.replace(/[^0-9.]/g, '');
      let originalPrice = parseFloat(cleanPrice);
      
      if (isNaN(originalPrice)) return;

      const code = inputField.value.trim().toLowerCase();
      
      if (code === 'xmas10') {
        const newPrice = originalPrice * 0.90; 
        priceElement.innerText = '£' + newPrice.toFixed(2);
        
        messageArea.textContent = "Success! 10% discount applied.";
        messageArea.style.color = "#155724"; // Green color
        
        // LOCK: Mark discount as applied so it can't happen again
        discountApplied = true;
        
        // Disable the button so they can't even click it
        applyButton.disabled = true;
        applyButton.style.backgroundColor = "#ccc";
        applyButton.style.cursor = "not-allowed";

      } else if (code === 'welcome20') {
        const newPrice = originalPrice * 0.80;
        priceElement.innerText = '£' + newPrice.toFixed(2);
        
        messageArea.textContent = "Success! 20% discount applied.";
        messageArea.style.color = "#155724";
        
        // LOCK
        discountApplied = true;
        applyButton.disabled = true;
        applyButton.style.backgroundColor = "#ccc";
        applyButton.style.cursor = "not-allowed";

      } else if (code === '') {
        messageArea.textContent = "Please enter a code.";
        messageArea.style.color = "#dc3545";
      } else {
        messageArea.textContent = "Invalid discount code.";
        messageArea.style.color = "#dc3545";
      }
    });
});