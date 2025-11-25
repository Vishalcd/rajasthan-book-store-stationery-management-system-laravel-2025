class ExtraItems {
    constructor(bundlePrice) {
        this.items = [];
        this.bundlePrice = Number(bundlePrice);

        this.container = document.getElementById("extraItemsContainer");
        this.extraTotal = document.getElementById("extraTotal");
        this.finalPay = document.getElementById("finalPay");
        this.finalPayBtn = document.getElementById("finalPayBtn");
    }

    addItem() {
        let index = this.items.length;

        let row = document.createElement("div");
        row.style.display = "grid";
        row.style.gridTemplateColumns = "2fr 1fr 1fr 1fr auto";
        row.style.alignItems = "center";
        row.style.gap = "12px";
        row.style.marginBottom = "12px";

        row.innerHTML = `
            <!-- Item Name -->
            <input type="text"
                name="extra_items[${index}][name]"
                style="border:1px solid #d1d5db;border-radius:6px;padding:8px;width:100%;"
                placeholder="Item name" required>

            <!-- Price -->
            <input type="number"
                name="extra_items[${index}][price]"
                class="extraPriceInput"
                style="border:1px solid #d1d5db;border-radius:6px;padding:8px;width:100%;"
                placeholder="Price" min="0" step="0.01" required>

            <!-- Quantity -->
            <input type="number"
                name="extra_items[${index}][quantity]"
                class="extraQtyInput"
                style="border:1px solid #d1d5db;border-radius:6px;padding:8px;width:100%;"
                placeholder="Qty" min="1" value="1" required>

            <!-- Auto Total (readonly) -->
            <input type="number"
                class="extraRowTotal"
                style="border:1px solid #d1d5db;border-radius:6px;padding:8px;width:100%;background:#f3f4f6;"
                readonly>

            <!-- Delete Button -->
            <button type="button"
                class="removeItemBtn"
                style="width:40px;height:40px;display:flex;justify-content:center;align-items:center;
                       border-radius:6px;color:#ef4444;background:transparent;border:1px solid #ef4444;cursor:pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
            </button>
        `;

        this.container.appendChild(row);
        this.items.push(row);

        this.attachEvents(row);
        this.updateTotals();
    }

    attachEvents(row) {
        const priceInput = row.querySelector(".extraPriceInput");
        const qtyInput = row.querySelector(".extraQtyInput");

        priceInput.addEventListener("input", () => this.updateTotals());
        qtyInput.addEventListener("input", () => this.updateTotals());

        row.querySelector(".removeItemBtn").addEventListener("click", () => {
            row.remove();
            this.items = this.items.filter((i) => i !== row);
            this.updateTotals();
        });
    }

    updateTotals() {
        let extra = 0;

        this.items.forEach((row) => {
            const price = Number(
                row.querySelector(".extraPriceInput")?.value || 0
            );
            const qty = Number(row.querySelector(".extraQtyInput")?.value || 0);
            const rowTotal = price * qty;

            // Set row total
            row.querySelector(".extraRowTotal").value = rowTotal.toFixed(2);

            extra += rowTotal;
        });

        // Update UI totals
        this.extraTotal.innerText = `₹${extra.toFixed(2)}`;
        let final = this.bundlePrice + extra;
        this.finalPay.innerText = `₹${final.toFixed(2)}`;
        this.finalPayBtn.innerText = `Pay ₹${final.toFixed(2)}`;
    }
}

window.addEventListener("DOMContentLoaded", () => {
    const bundlePrice = document.getElementById("bundlePrice");
    if (!bundlePrice) return;

    const extra = new ExtraItems(bundlePrice.dataset.price.trim());
    document
        .getElementById("addItemBtn")
        .addEventListener("click", () => extra.addItem());
});
