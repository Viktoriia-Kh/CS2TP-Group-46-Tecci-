document.addEventListener("DOMContentLoaded", function() {
    console.log("basket.js loaded - Dynamic Names Version");

    // --- 1. Select Elements ---
    const checkoutBtns = document.querySelectorAll('.checkout-validate'); 
    const subtotalEl = document.getElementById('subtotal-amount');
    const deliveryCostEl = document.getElementById('delivery-cost');
    const totalEl = document.getElementById('checkout-total');
    const applyButton = document.getElementById('apply-btn');
    const inputField = document.getElementById('discount-input');
    const messageArea = document.getElementById('message-area');
    const checkboxes = document.querySelectorAll('.delivery-group-checkbox');
    const deliveryErrorMsg = document.getElementById('delivery-error-msg');
    const cartBadge = document.querySelector('.cart-badge');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Server State
    const sessionMultiplier = document.getElementById('session-discount-multiplier')?.value;
    const sessionCode = document.getElementById('session-discount-code')?.value;
    let discountMultiplier = sessionMultiplier ? parseFloat(sessionMultiplier) : 1;

    // --- 2. Shared Calculation Logic ---
    function updateTotals(serverSubtotal = null) {
        if (!subtotalEl) return false;
        if (serverSubtotal !== null) subtotalEl.innerText = '£' + parseFloat(serverSubtotal).toFixed(2);

        let subtotalRaw = parseFloat(subtotalEl.innerText.replace(/[£,]/g, '')) || 0;
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

        if (deliveryCostEl) {
            deliveryCostEl.innerText = deliveryText;
            deliveryCostEl.style.color = (deliveryText === "FREE") ? "#2ecc71" : "#64748b"; 
            deliveryCostEl.style.fontWeight = (deliveryText === "FREE") ? "700" : "400";
        }

        const discountMult = parseFloat(document.getElementById('session-discount-multiplier')?.value || 1);
        let finalTotal = (subtotalRaw * discountMult) + deliveryPrice;
        if (totalEl) totalEl.innerText = '£' + finalTotal.toFixed(2);
        return isDeliverySelected;
    }

    // --- 3. AJAX Logic (Updated for Product Names) ---
    // We added 'productName' as a 3rd argument here
    function sendBasketUpdate(productId, action, productName, productImage) {
        fetch('/basket/update-ajax', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ id: productId, action: action })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const input = document.getElementById(`qty-input-${productId}`);
                if (input && data.newQuantity > 0) input.value = data.newQuantity;

                if (action === 'remove' || data.action === 'remove') {
                    const btn = document.querySelector(`.ajax-remove-btn[data-id="${productId}"]`);
                    if(btn) {
                        const row = btn.closest('.basket-item-row');
                        row.style.transition = "opacity 0.3s, transform 0.3s";
                        row.style.opacity = '0';
                        setTimeout(() => row.remove(), 300);
                    }
                    // DYNAMIC REMOVE MESSAGE
                    showToast("Item Removed", `${productName} was removed from your basket`, "error", productImage);
                } else {
                    // DYNAMIC UPDATE MESSAGE
                    showToast("Basket Updated", `Updated quantity for ${productName}`, "success", productImage);
                }

                if (cartBadge) {
                    cartBadge.innerText = data.totalQty;
                    cartBadge.style.display = data.totalQty > 0 ? 'flex' : 'none';
                }
                updateTotals(data.subtotalRaw);
                if (data.itemCount === 0) setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(err => console.error("AJAX Error:", err));
    }

    // --- 4. Event Listeners ---
    document.querySelectorAll('.ajax-qty-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            // Pass the name from the data attribute
            sendBasketUpdate(this.dataset.id, this.dataset.action, this.dataset.name, this.dataset.image);
        });
    });

    document.querySelectorAll('.ajax-remove-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            // Pass the name from the data attribute
            sendBasketUpdate(this.dataset.id, 'remove', this.dataset.name, this.dataset.image);
        });
    });

    checkboxes.forEach(box => {
    box.addEventListener('change', function() {
        if(this.checked) {
            checkboxes.forEach(other => { if(other !== this) other.checked = false; });
            if(deliveryErrorMsg) deliveryErrorMsg.style.display = 'none';
            
            // Save delivery cost to session via AJAX
            let deliveryCost = 0;
            if (this.id === 'delivery-standard') {
                const subtotalRaw = parseFloat(subtotalEl.innerText.replace(/[£,]/g, '')) || 0;
                deliveryCost = subtotalRaw >= 60 ? 0 : 3.99;
            } else if (this.id === 'delivery-premium') {
                deliveryCost = 4.99;
            }
            
            // Save to session
            fetch('/basket/save-delivery', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ delivery_cost: deliveryCost })
            });
        }
        updateTotals();
    });
});

    if (applyButton) {
        applyButton.addEventListener('click', function() {
            const code = inputField.value.trim();
            if (!code) return;
            if (!csrfToken) return; // Silent fail if no token

            fetch('/apply-discount', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ code: code })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload(); 
                else {
                    messageArea.textContent = data.message || "Invalid Code";
                    messageArea.style.color = "#dc3545";
                }
            })
            .catch(err => console.error(err));
        });
    }

    if (checkoutBtns.length > 0) {
        checkoutBtns.forEach(btn => {
            btn.addEventListener('click', function(event) {
                const isSelected = updateTotals();
                if (!isSelected) { 
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

    // --- 5. Restore UI ---
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

    // --- 6 - Toast Notification ---
    function showToast(title, message, type = 'success', imageUrl = null) {
        
        // a) Finds the container, or creates it if it doesn't exist yet
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            document.body.appendChild(container);
        }

        // b) Creates the individual Toast
        const toast = document.createElement('div');
        toast.className = 'toast-notification'; 
        
        const color = type === 'success' ? '#2ecc71' : '#e74c3c';
        const icon = type === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-trash-alt"></i>';
        const imageHtml = imageUrl ? `<img src="${imageUrl}" class="toast-product-image" alt="Product">` : '';
        
        toast.style.borderLeft = `5px solid ${color}`;
        toast.innerHTML = `
            <div class="toast-icon" style="color: ${color}">${icon}</div>
            <div class="toast-content">
                <span class="toast-title" style="color: #333">${title}</span>
                <span class="toast-message" style="text-transform: capitalize;">${message}</span>
            </div>
            ${imageHtml}
            <div class="toast-progress" style="background-color: ${color}"></div>
        `;
        
        // c) Appends to the CONTAINER, not the body
        container.appendChild(toast);
        
        // d) Removes notifications gracefully
        setTimeout(() => {
            toast.style.transform = "translateX(120%)"; // Slide out to the right
            toast.style.opacity = "0"; // Fade out
            
            // Wait for slide out, then shrink the margin so the notifications below slide UP smoothly
            setTimeout(() => {
                toast.style.marginTop = `-${toast.offsetHeight + 15}px`; 
                
                // Finally remove it from the DOM
                setTimeout(() => toast.remove(), 400); 
            }, 400); 
            
        }, 3000);
    }

    restoreDiscountUI(); 
    updateTotals();      
});