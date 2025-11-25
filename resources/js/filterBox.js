class FilterBox {
    constructor(buttonId, boxId, closeId) {
        this.button = document.getElementById(buttonId);
        this.box = document.getElementById(boxId);
        this.closeBtn = document.getElementById(closeId);

        this.open = this.open.bind(this);
        this.close = this.close.bind(this);
        this.handleClickOutside = this.handleClickOutside.bind(this);

        this.init();
    }

    init() {
        if (!this.button || !this.box) return;

        this.button.addEventListener("click", this.open);

        if (this.closeBtn) {
            this.closeBtn.addEventListener("click", this.close);
        }

        document.addEventListener("click", this.handleClickOutside);
    }

    open() {
        this.box.classList.remove("hidden");
        this.box.classList.add("animate-fadeIn");
    }

    close() {
        this.box.classList.add("hidden");
    }

    handleClickOutside(e) {
        if (!this.box.contains(e.target) && !this.button.contains(e.target)) {
            this.close();
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    new FilterBox("filterBtn", "filterBox", "filterClose");
});
