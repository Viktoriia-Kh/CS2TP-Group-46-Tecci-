<style>
    /* Styling isolated to this component */
    .discount-wrapper {
        margin-bottom: 20px; 
        border-top: 1px solid #eee; 
        padding-top: 15px;
    }
    .discount-container {
        display: flex; 
        gap: 10px;
    }
    #discount-input {
        flex-grow: 1; 
        padding: 10px; 
        border: 1px solid #ccc; 
        border-radius: 5px;
    }
    #apply-btn {
        padding: 10px 15px; 
        background: #333; 
        color: white; 
        border: none; 
        border-radius: 5px; 
        cursor: pointer;
    }
    #apply-btn:hover { background: #555; }
    #message-area {
        font-size: 0.9rem; 
        margin-top: 5px; 
        min-height: 1.5em; 
        margin-bottom: 0;
    }
</style>

<div class="discount-wrapper">
  <div class="discount-container">
    <input type="text" id="discount-input" placeholder="Discount code">
    <button type="button" id="apply-btn">Apply</button>
  </div>
  <p id="message-area"></p>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const applyButton = document.getElementById('apply-btn');
    const inputField = document.getElementById('discount-input');
    const messageArea = document.getElementById('message-area');
    
    // --- CONNECTION POINT ---
    // Script looks for an ID that doesn't exist yet. 
    // It will sit quietly and wait until added.
    const priceElement = document.getElementById('checkout-total'); 

    // Safety Check: If price isn't there yet, stop
    if(!priceElement) {
       console.log("Discount Component: Waiting for 'checkout-total' element...");
       return;
    }

    applyButton.addEventListener('click', function() {
      let currentPriceText = priceElement.innerText.replace(/[^0-9.]/g, '');
      let originalPrice = parseFloat(currentPriceText);
      
      if (isNaN(originalPrice)) return;

      const code = inputField.value.trim().toLowerCase();
      let isDiscountActive = false;
      
      if (code === 'xmas10') {
        const newPrice = originalPrice * 0.90; 
        priceElement.innerText = '£' + newPrice.toFixed(2);
        messageArea.textContent = "Success! 10% discount applied.";
        messageArea.style.color = "#155724";
        isDiscountActive = true;
      } else if (code === 'welcome20') {
        const newPrice = originalPrice * 0.80;
        priceElement.innerText = '£' + newPrice.toFixed(2);
        messageArea.textContent = "Success! 20% discount applied.";
        messageArea.style.color = "#155724";
        isDiscountActive = true;
      } else if (code === '') {
        messageArea.textContent = "Please enter a code.";
        messageArea.style.color = "#dc3545";
      } else {
        messageArea.textContent = "Invalid discount code.";
        messageArea.style.color = "#dc3545";
      }
    });
  });
</script>