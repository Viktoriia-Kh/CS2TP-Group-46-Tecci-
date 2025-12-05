document.addEventListener("DOMContentLoaded", function() {
    console.log("✅ basket.js loaded successfully");

    // Select Elements
    
    // Checkout Buttons (Top and Bottom)
    const checkoutBtns = document.querySelectorAll('.checkout-validate'); 

    // Totals & Display
    const subtotalEl = document.getElementById('subtotal-amount');
    const deliveryCostEl = document.getElementById('delivery-cost');
    const totalEl = document.getElementById('checkout-total');
    
    // Inputs
    const applyButton = document.getElementById('apply-btn');
    const inputField = document.getElementById('discount-input');
    const messageArea = document.getElementById('message-area');

    // Delivery Selection
    const checkboxes = document.querySelectorAll('.delivery-group-checkbox');
    const deliveryErrorMsg = document.getElementById('delivery-error-msg');
    
    // State Tracking
    let discountMultiplier = 1; 

    // Calculation Logic
    function updateTotals() {
        // safety check - If subtotal ID missing, stop calculation but don't crash app
        if (!subtotalEl) {
            console.warn("⚠️ Warning: Could not find element with id 'subtotal-amount'. Calculations paused.");
            return false;
        }

        // Get Subtotal
        let subtotalRaw = parseFloat(subtotalEl.innerText.replace(/[£,]/g, ''));
        if (isNaN(subtotalRaw)) subtotalRaw = 0;

        // Determine Delivery Cost
        let deliveryPrice = 0;
        let deliveryText = "--";
        let isDeliverySelected = false;

        if (checkboxes.length > 0) {
            checkboxes.forEach(box => {
                if (box.checked) {
                    isDeliverySelected = true;
                    if (box.id === 'delivery-standard') {
                        if (subtotalRaw >= 60) {
                            deliveryPrice = 0;
                            deliveryText = "FREE";
                        } else {
                            deliveryPrice = 3.99;
                            deliveryText = "£3.99";
                        }
                    } else if (box.id === 'delivery-premium') {
                        deliveryPrice = 4.99;
                        deliveryText = "£4.99";
                    }
                }
            });
        }

        // Update Delivery Text
        if (deliveryCostEl) {
            deliveryCostEl.innerText = deliveryText;
            deliveryCostEl.style.color = (deliveryText === "FREE") ? "#155724" : ""; 
            deliveryCostEl.style.fontWeight = (deliveryText === "FREE") ? "bold" : "";
        }

        // Calculate Grand Total
        let discountedSubtotal = subtotalRaw * discountMultiplier;
        let finalTotal = discountedSubtotal + deliveryPrice;

        // Update Grand Total Text
        if (totalEl) {
            totalEl.innerText = '£' + finalTotal.toFixed(2);
        }

        return isDeliverySelected;
    }

    // Discount Logic ---
    if (applyButton) {
        applyButton.addEventListener('click', function() {
            // Check if discount already applied
            if (discountMultiplier < 1) {
                if(messageArea) {
                    messageArea.textContent = "A discount is already applied!";
                    messageArea.style.color = "#dc3545";
                }
                return;
            }

            // Check input exists
            if (!inputField) return;

            const code = inputField.value.trim().toLowerCase();
            let msg = "";
            let color = "";

            if (code === 'xmas10') {
                discountMultiplier = 0.90; 
                msg = "Success! 10% discount applied.";
                color = "#155724";
            } else if (code === 'welcome20') {
                discountMultiplier = 0.80; 
                msg = "Success! 20% discount applied.";
                color = "#155724";
            } else if (code === '') {
                msg = "Please enter a code.";
                color = "#dc3545";
            } else {
                msg = "Invalid discount code.";
                color = "#dc3545";
            }

            // Show Message
            if (messageArea) {
                messageArea.textContent = msg;
                messageArea.style.color = color;
            }

            // Only lock button if success
            if (discountMultiplier < 1) {
                applyButton.disabled = true;
                applyButton.style.backgroundColor = "#ccc";
                applyButton.style.cursor = "not-allowed";
                updateTotals(); // Update prices
            }
        });
    } else {
        console.error("❌ Error: Could not find 'apply-btn'. Discounts will not work.");
    }

    // Event Listeners for Checkboxes ---
    if (checkboxes.length > 0) {
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes.forEach((other) => {
                        if (other !== this) other.checked = false;
                    });
                    if (deliveryErrorMsg) deliveryErrorMsg.style.display = 'none';
                }
                updateTotals();
            });
        });
    }

    // Checkout Validation (Using the buttons defined at top)
    if (checkoutBtns.length > 0) {
        checkoutBtns.forEach(btn => {
            btn.addEventListener('click', function(event) {
                const isSelected = updateTotals();
                if (isSelected === false) { // Explicit check for false
                    event.preventDefault(); 
                    if (deliveryErrorMsg) {
                        deliveryErrorMsg.style.display = 'block';
                        deliveryErrorMsg.innerText = "Please select a delivery method";
                        deliveryErrorMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        });
    } else {
        console.warn("⚠️ Warning: No checkout buttons found with class 'checkout-validate'");
    }

    // Run once on load to set initial state
    updateTotals();
});