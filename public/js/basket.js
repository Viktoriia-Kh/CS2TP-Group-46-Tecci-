document.addEventListener("DOMContentLoaded", function() {
    console.log("✅ basket.js loaded successfully");

    // --- Select Elements ---
    const subtotalEl = document.getElementById('subtotal-amount');
    const deliveryCostEl = document.getElementById('delivery-cost');
    const totalEl = document.getElementById('checkout-total');
    
    const checkboxes = document.querySelectorAll('.delivery-group-checkbox');
    const checkoutBtn = document.getElementById('checkout-btn');
    const deliveryErrorMsg = document.getElementById('delivery-error-msg');
    
    const applyButton = document.getElementById('apply-btn');
    const inputField = document.getElementById('discount-input');
    const messageArea = document.getElementById('message-area');

    // Store state
    let discountMultiplier = 1; // 1 = 100% price (no discount)

    // --- Calculation Logic ---
    function updateTotals() {
        // Get Subtotal (Remove '£' and commas)
        let subtotalRaw = parseFloat(subtotalEl.innerText.replace(/[£,]/g, ''));
        if (isNaN(subtotalRaw)) subtotalRaw = 0;

        // Determine Delivery Cost
        let deliveryPrice = 0;
        let deliveryText = "--";
        let isDeliverySelected = false;

        checkboxes.forEach(box => {
            if (box.checked) {
                isDeliverySelected = true;
                
                // CHECK ID: Standard or Premium?
                if (box.id === 'delivery-standard') {
                    // Rule: Standard FREE if subtotal >= 60, otherwise £3.99
                    if (subtotalRaw >= 60) {
                        deliveryPrice = 0;
                        deliveryText = "FREE";
                    } else {
                        deliveryPrice = 3.99;
                        deliveryText = "£3.99";
                    }
                } else if (box.id === 'delivery-premium') {
                    // Rule: Premium always £4.99
                    deliveryPrice = 4.99;
                    deliveryText = "£4.99";
                }
            }
        });

        // Update Delivery Text on Screen
        if (deliveryCostEl) {
            deliveryCostEl.innerText = deliveryText;
            // Make "FREE" green, others black
            deliveryCostEl.style.color = (deliveryText === "FREE") ? "#155724" : ""; 
            deliveryCostEl.style.fontWeight = (deliveryText === "FREE") ? "bold" : "";
        }

        // Calculate Grand Total
        // Formula: (Subtotal * Discount) + Delivery
        let discountedSubtotal = subtotalRaw * discountMultiplier;
        let finalTotal = discountedSubtotal + deliveryPrice;

        // Update Grand Total Text
        if (totalEl) {
            totalEl.innerText = '£' + finalTotal.toFixed(2);
        }

        return isDeliverySelected;
    }

    // --- Event Listeners for Checkboxes ---
    if (checkboxes.length > 0) {
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                // Mutual Exclusion (Radio Behavior)
                if (this.checked) {
                    checkboxes.forEach((other) => {
                        if (other !== this) other.checked = false;
                    });
                    if (deliveryErrorMsg) deliveryErrorMsg.style.display = 'none';
                }
                
                // Recalculate totals immediately when clicked
                updateTotals();
            });
        });
    }

    // --- Checkout Validation ---
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function(event) {
            // Run calculation to see if anything is selected
            const isSelected = updateTotals();

            if (!isSelected) {
                event.preventDefault();
                if (deliveryErrorMsg) {
                    deliveryErrorMsg.style.display = 'block';
                    deliveryErrorMsg.innerText = "Please select a delivery method";
                }
            }
        });
    }

    // --- Discount Logic ---
    if (applyButton) {
        applyButton.addEventListener('click', function() {
            if (discountMultiplier < 1) {
                messageArea.textContent = "A discount is already applied!";
                messageArea.style.color = "#dc3545";
                return;
            }

            const code = inputField.value.trim().toLowerCase();
            
            if (code === 'xmas10') {
                discountMultiplier = 0.90; // 10% off
                messageArea.textContent = "Success! 10% discount applied.";
                messageArea.style.color = "#155724";
            } else if (code === 'welcome20') {
                discountMultiplier = 0.80; // 20% off
                messageArea.textContent = "Success! 20% discount applied.";
                messageArea.style.color = "#155724";
            } else if (code === '') {
                messageArea.textContent = "Please enter a code.";
                messageArea.style.color = "#dc3545";
                return;
            } else {
                messageArea.textContent = "Invalid discount code.";
                messageArea.style.color = "#dc3545";
                return;
            }

            // Lock the button
            applyButton.disabled = true;
            applyButton.style.backgroundColor = "#ccc";
            applyButton.style.cursor = "not-allowed";

            // Recalculate numbers with new discount
            updateTotals();
        });
    }
    
    // Initial Run to set defaults
    updateTotals();
});