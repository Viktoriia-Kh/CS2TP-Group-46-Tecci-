document.addEventListener("DOMContentLoaded", function() {
    console.log("✅ basket.js loaded - HYBRID Version (Original Logic + AJAX)");

    // --- SECTION 1 - ELEMENT SELECTION ---
    const checkoutBtns = document.querySelectorAll('.checkout-validate'); 
    const subtotalEl = document.getElementById('subtotal-amount');
    const deliveryCostEl = document.getElementById('delivery-cost');
    const totalEl = document.getElementById('checkout-total');
    
    // Discount Elements
    const applyButton = document.getElementById('apply-btn');
    const inputField = document.getElementById('discount-input');
    const messageArea = document.getElementById('message-area');

    // Delivery Elements
    const checkboxes = document.querySelectorAll('.delivery-group-checkbox');
    const deliveryErrorMsg = document.getElementById('delivery-error-msg');
    
    // Header Badge (The little red circle in the nav)
    const cartBadge = document.querySelector('.cart-badge');

    // Meta Data
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Server State
    const sessionCode = document.getElementById('session-discount-code')?.value;
    const sessionMultiplier = document.getElementById('session-discount-multiplier')?.value;
    let discountMultiplier = sessionMultiplier ? parseFloat(sessionMultiplier) : 1;


    // --- SECTION 2 - CORE CALCULATIONS (Merged) ---
    
    // Updated function to accept an optional 'serverSubtotal'
    // Allows AJAX update to pass new price directly
    function updateTotals(serverSubtotal = null) {
        if (!subtotalEl) return false;

        // 1. If AJAX provided a new number, update the text first
        if (serverSubtotal !== null) {
            subtotalEl.innerText = '£' + parseFloat(serverSubtotal).toFixed(2);
        }

        // 2. Read Subtotal from DOM
        let subtotalRaw = parseFloat(subtotalEl.innerText.replace(/[£,]/g, ''));
        if (isNaN(subtotalRaw)) subtotalRaw = 0;

        let deliveryPrice = 0;
        let deliveryText = "--";
        let isDeliverySelected = false;

        // 3. Delivery Logic
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

        // 4. Update Delivery Text
        if (deliveryCostEl) {
            deliveryCostEl.innerText = deliveryText;
            deliveryCostEl.style.color = (deliveryText === "FREE") ? "#2ecc71" : "#64748b"; 
            deliveryCostEl.style.fontWeight = (deliveryText === "FREE") ? "700" : "400";
        }

        // 5. Grand Total Calculation
        let discountedSubtotal = subtotalRaw * discountMultiplier;
        let finalTotal = discountedSubtotal + deliveryPrice;

        if (totalEl) {
            totalEl.innerText = '£' + finalTotal.toFixed(2);
        }

        return isDeliverySelected;
    }

    // --- SECTION 3 - AJAX LOGIC ---
    function sendBasketUpdate(productId, action) {
        fetch('/basket/update-ajax', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': csrfToken 
            },
            body: JSON.stringify({ id: productId, action: action })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // A. Update Quantity Input Box
                const input = document.getElementById(`qty-input-${productId}`);
                if (input && data.newQuantity > 0) input.value = data.newQuantity;

                // B. Handle Item Removal
                if (action === 'remove' || data.action === 'remove') {
                    const btn = document.querySelector(`.ajax-remove-btn[data-id="${productId}"]`);
                    if(btn) {
                        const row = btn.closest('.basket-item-row');
                        row.style.transition = "opacity 0.3s, transform 0.3s";
                        row.style.opacity = '0';
                        setTimeout(() => row.remove(), 300);
                    }
                    showToast("Item removed from basket", "error");
                } else {
                    showToast("Basket updated successfully", "success");
                }

                // C. Update Header Badge
                if (cartBadge) {
                    cartBadge.innerText = data.totalQty;
                    cartBadge.style.display = data.totalQty > 0 ? 'flex' : 'none';
                }

                // D. Update Money (Pass raw subtotal to trigger Free Delivery check)
                updateTotals(data.subtotalRaw);

                // E. Reload if empty (to show "Your basket is empty" screen)
                if (data.itemCount === 0) setTimeout(() => location.reload(), 500);
            }
        })
        .catch(err => console.error("AJAX Error:", err));
    }


    // --- SECTION 4 - RESTORED ORIGINAL FEATURES ---

    // Feature A: Restore Discount UI
    function restoreDiscountUI() {
        if (discountMultiplier < 1 && inputField && applyButton) {
            inputField.value = sessionCode || '';
            let pct = Math.round((1 - discountMultiplier) * 100);
            messageArea.textContent = `Discount Active! ${pct}% off applied.`;
            messageArea.style.color = "#155724";
            applyButton.disabled = true;
            applyButton.textContent = "Applied";
            applyButton.style.backgroundColor = "#ccc";
            applyButton.style.cursor = "not-allowed";
        }
    }

    // Feature B: Apply Discount Listener
    if (applyButton) {
        applyButton.addEventListener('click', function() {
            const code = inputField.value.trim();
            if (!code) return;

            if (!csrfToken) {
                messageArea.textContent = "System Error: Cannot verify security token.";
                messageArea.style.color = "#dc3545";
                return;
            }

            fetch('/apply-discount', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); 
                } else {
                    messageArea.textContent = data.message || "Invalid Code";
                    messageArea.style.color = "#dc3545";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageArea.textContent = "Connection Error.";
                messageArea.style.color = "#dc3545";
            });
        });
    }

    // Feature C: Delivery Checkboxes
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

    // Feature D: Checkout Validation
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

    // --- SECTION 5 - NEW EVENT LISTENERS ---
    
    // AJAX Quantity Buttons
    document.querySelectorAll('.ajax-qty-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            sendBasketUpdate(this.dataset.id, this.dataset.action);
        });
    });

    // AJAX Remove Buttons
    document.querySelectorAll('.ajax-remove-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            sendBasketUpdate(this.dataset.id, 'remove');
        });
    });

    // --- SECTION 6 - TOAST NOTIFICATIONS ---
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.id = 'toast-notification';
        toast.className = 'toast-visible';
        
        const color = type === 'success' ? '#2ecc71' : '#e74c3c';
        const icon = type === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-trash-alt"></i>';
        
        toast.style.borderLeft = `5px solid ${color}`;
        toast.innerHTML = `
            <div class="toast-icon" style="color: ${color}">${icon}</div>
            <div class="toast-content">
                <span class="toast-title" style="color: #333">${type === 'success' ? 'Success' : 'Removed'}</span>
                <span class="toast-message">${message}</span>
            </div>
            <div class="toast-progress" style="background-color: ${color}"></div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.transform = "translateX(120%)";
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    // --- Initial Run ---
    restoreDiscountUI(); 
    updateTotals();      
});