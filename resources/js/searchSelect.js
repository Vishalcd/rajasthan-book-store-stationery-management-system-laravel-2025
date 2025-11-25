class SearchSelect {
    constructor(wrapper) {
        this.wrapper = wrapper;
        this.searchInput = wrapper.querySelector(".search-input");
        this.optionsBox = wrapper.querySelector(".options");
        this.optionItems = wrapper.querySelectorAll(".option");
        this.realInput = wrapper.querySelector(".real-input");

        this.registerEvents();
    }

    registerEvents() {
        // Show dropdown on focus
        this.searchInput.addEventListener("focus", () => {
            this.optionsBox.classList.remove("hidden");
        });

        // Hide dropdown when clicking outside
        document.addEventListener("click", (e) => {
            if (!this.wrapper.contains(e.target)) {
                this.optionsBox.classList.add("hidden");
            }
        });

        // Filter options
        this.searchInput.addEventListener("input", () => {
            const term = this.searchInput.value.toLowerCase();

            this.optionItems.forEach((opt) => {
                const text = opt.innerText.toLowerCase();
                opt.style.display = text.includes(term) ? "block" : "none";
            });
        });

        // Select a value
        this.optionItems.forEach((option) => {
            option.addEventListener("click", () => {
                const value = option.dataset.value;
                const label = option.innerText;

                this.realInput.value = value;
                this.searchInput.value = label;

                this.optionsBox.classList.add("hidden");
            });
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    document
        .querySelectorAll(".search-select")
        .forEach((el) => new SearchSelect(el));
});
