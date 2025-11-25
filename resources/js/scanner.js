class BarcodeScanner {
    constructor() {
        this.scannedData = "";
        this.timeout = null;

        // Bind methods
        this.onKeyDown = this.onKeyDown.bind(this);
        this.handleScan = this.handleScan.bind(this);

        // Attach listener
        window.addEventListener("keydown", this.onKeyDown);
    }

    onKeyDown(e) {
        // Ignore all key events when user is typing in input, textarea, select, or editable fields
        const active = document.activeElement;
        if (
            active &&
            (active.tagName === "INPUT" ||
                active.tagName === "TEXTAREA" ||
                active.tagName === "SELECT" ||
                active.isContentEditable)
        ) {
            return; // Prevent scanner processing when typing
        }

        // Scanner sends ENTER at the end
        if (e.key === "Enter") {
            if (this.scannedData && this.scannedData.length > 0) {
                console.log("SCANNED:", this.scannedData);
                this.handleScan(this.scannedData);
                this.scannedData = "";
            }
            return;
        }

        // Only capture normal printable characters
        if (e.key.length === 1) {
            if (!this.scannedData) this.scannedData = ""; // safety restore

            this.scannedData += e.key;

            // Reset slow manual typing
            if (this.timeout) clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.scannedData = "";
            }, 70);
        }
    }

    // Handle scan
    handleScan(code) {
        console.log("Redirecting to:", code);
        window.open(code, "_blank");
    }
}

// Init when DOM ready
document.addEventListener("DOMContentLoaded", () => {
    new BarcodeScanner();
});
