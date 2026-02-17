document.addEventListener("DOMContentLoaded", function() {
    console.log("✅ basket.js loaded - Optimal Version");

    // --- 1 - Select Elements ---
    const checkoutBtns = document.querySelectorAll('.checkout-validate'); 
    const subtotalEl = document.getElementById('subtotal-amount');
    const deliveryCostEl = document.getElementById('delivery-cost');
    const totalEl = document.getElementById('checkout-total');
    
    const applyButton = document.getElementById('apply-btn');
    const inputField = document.getElementById('discount-input');
    const messageArea = document.getElementById('message-area');

    const checkboxes = document.querySelectorAll('.delivery-group-checkbox');
    const deliveryErrorMsg = document.getElementById('delivery-error-msg');
    
    // --- 2 - State & Restoration ---
    // Read the CSRF Token (The Security Key)
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Read Server State (Passed from Controller -> Blade -> Here)
    const sessionCode = document.getElementById('session-discount-code')?.value;
    const sessionMultiplier = document.getElementById('session-discount-multiplier')?.value;

    // Initialise state strictly from Server Data
    let discountMultiplier = sessionMultiplier ? parseFloat(sessionMultiplier) : 1;

    // RESTORE UI - Only runs if the server actually remembers a discount
    function restoreDiscountUI() {
        if (discountMultiplier < 1 && inputField && applyButton) {
            // Fill the input with the saved code
            inputField.value = sessionCode || '';
            
            // Calculate percentage for display
            let pct = Math.round((1 - discountMultiplier) * 100);
            messageArea.textContent = `Discount Active! ${pct}% off applied.`;
            messageArea.style.color = "#155724";

            // Lock the UI
            applyButton.disabled = true;
            applyButton.style.backgroundColor = "#ccc";
            applyButton.style.cursor = "not-allowed";
            applyButton.textContent = "Applied";
        }
    }

    // --- 3 - Calculation Logic ---
    function updateTotals() {
        if (!subtotalEl) return false;

        let subtotalRaw = parseFloat(subtotalEl.innerText.replace(/[£,]/g, ''));
        if (isNaN(subtotalRaw)) subtotalRaw = 0;

        let deliveryPrice = 0;
        let deliveryText = "--";
        let isDeliverySelected = false;

        // Delivery Logic
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
            deliveryCostEl.style.color = (deliveryText === "FREE") ? "#2ecc71" : ""; 
            deliveryCostEl.style.fontWeight = (deliveryText === "FREE") ? "bold" : "";
        }

        // Grand Total Calculation
        let discountedSubtotal = subtotalRaw * discountMultiplier;
        let finalTotal = discountedSubtotal + deliveryPrice;

        if (totalEl) {
            totalEl.innerText = '£' + finalTotal.toFixed(2);
        }

        return isDeliverySelected;
    }

    // --- 4 - Apply Discount Listener ---
    if (applyButton) {
        applyButton.addEventListener('click', function() {
            const code = inputField.value.trim();
            if (!code) return;

            // Security Check
            if (!csrfToken) {
                console.error("❌ CSRF Token missing. Check layouts/app.blade.php");
                messageArea.textContent = "System Error: Cannot verify security token.";
                messageArea.style.color = "#dc3545";
                return;
            }

            // Send to Server
            fetch('/apply-discount', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Pass the key!
                },
                body: JSON.stringify({ code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // SUCCESS: Server saved it. Now update the UI
                    // Reload the page to ensure the Session & View are synced
                    // Fixes the refresh bug permanently
                    location.reload(); 
                } else {
                    // FAILURE: Server rejected it, Show error
                    messageArea.textContent = data.message || "Invalid Code";
                    messageArea.style.color = "#dc3545";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageArea.textContent = "Connection Error. Please try again.";
                messageArea.style.color = "#dc3545";
            });
        });
    }

    // --- 5 - Delivery Checkboxes ---
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

    // --- 6 - Checkout Validation ---
    if (checkoutBtns.length > 0) {
        checkoutBtns.forEach(btn => {
            btn.addEventListener('click', function(event) {
                const isSelected = updateTotals();
                if (isSelected === false) { 
                    event.preventDefault(); 
                    if (deliveryErrorMsg) {
                        deliveryErrorMsg.style.display = 'block';
                        deliveryErrorMsg.innerText = "Please select a delivery method";
                        deliveryErrorMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        });
    }

    // --- 7 - Initial Run ---
    restoreDiscountUI(); 
    updateTotals();      
});