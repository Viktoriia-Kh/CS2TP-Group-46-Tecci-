document.addEventListener("DOMContentLoaded", function() {
    console.log("✅ basket.js loaded successfully");

    // --- Select All Necessary Elements ---
    const applyButton = document.getElementById('apply-btn');
    const inputField = document.getElementById('discount-input');
    const messageArea = document.getElementById('message-area');
    const priceElement = document.getElementById('checkout-total'); 
    
    // Select the Checkout Button and Error Message
    const checkoutBtn = document.getElementById('checkout-btn');
    const deliveryErrorMsg = document.getElementById('delivery-error-msg');

    // Select the Delivery Checkboxes (The fix for your issue)
    const checkboxes = document.querySelectorAll('.delivery-group-checkbox');

    // --- Auto-Uncheck Logic (Mutual Exclusivity) ---
    // This ensures only ONE box can be ticked at a time
    if (checkboxes.length > 0) {
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    // If this one is turned ON, turn the others OFF
                    checkboxes.forEach((other) => {
                        if (other !== this) {
                            other.checked = false;
                        }
                    });
                    
                    // Hide the error message immediately since a selection was made
                    if (deliveryErrorMsg) {
                        deliveryErrorMsg.style.display = 'none';
                    }
                    
                    console.log(`Selected: ${this.nextElementSibling.innerText.trim()}`);
                    // We will add price updating logic here later
                }
            });
        });
    }

    // --- Checkout Validation ---
    // Prevents moving to the next page if nothing is selected
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function(event) {
            let isAnyChecked = false;
            
            // Check if at least one box is ticked
            checkboxes.forEach((box) => {
                if (box.checked) isAnyChecked = true;
            });

            // If nothing checked, stop!
            if (!isAnyChecked) {
                event.preventDefault(); // Stop the link from working
                if (deliveryErrorMsg) {
                    deliveryErrorMsg.style.display = 'block';
                    deliveryErrorMsg.textContent = 'Please select a delivery method';
                }
            } 
        });
    }

    // --- Discount Logic (Your Existing Code) ---
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