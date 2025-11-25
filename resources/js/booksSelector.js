class BookSelector {
    constructor() {
        this.container = document.getElementById("book-selector");
        if (!this.container) return;

        this.searchUrl = this.container.dataset.searchUrl;
        this.books = JSON.parse(this.container.dataset.initialBooks || "[]");

        this.grid = document.getElementById("books-grid");
        this.loader = document.getElementById("loader");
        this.searchInput = document.getElementById("book-search");
        this.selectedBox = document.getElementById("selected-books");
        this.selectedList = document.getElementById("selected-books-list");

        this.selectedIds = new Set();

        this.renderBooks = this.renderBooks.bind(this);
        this.renderSelected = this.renderSelected.bind(this);
        this.fetchBooks = this.fetchBooks.bind(this);

        this.attachEvents();
        this.renderBooks();
    }

    attachEvents() {
        if (!this.searchInput) return;

        let debounceTimer;
        this.searchInput.addEventListener("input", (e) => {
            const query = e.target.value.trim();
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => this.fetchBooks(query), 400);
        });
    }

    // ---------------------------------------------------------
    // RENDER BOOK GRID
    // ---------------------------------------------------------
    renderBooks() {
        if (!this.grid) return;
        this.grid.innerHTML = "";

        if (!this.books.length) {
            this.grid.innerHTML = `
                <p style="grid-column: 1 / -1; text-align:center; color:#6b7280; padding:24px;">
                    No books found.
                </p>`;
            return;
        }

        this.books.forEach((book) => {
            const label = document.createElement("label");
            label.style.cursor = "pointer";
            label.style.display = "block";

            const input = document.createElement("input");
            input.type = "checkbox";
            input.name = "books[]";
            input.value = book.id;
            input.style.display = "none";
            input.checked = this.selectedIds.has(book.id);

            input.addEventListener("change", () => {
                if (input.checked) {
                    this.selectedIds.add(book.id);
                } else {
                    this.selectedIds.delete(book.id);
                }
                this.renderSelected();
                this.renderBooks();
            });

            const article = document.createElement("article");
            article.style.border = "1px solid #e5e7eb";
            article.style.overflow = "hidden";
            article.style.borderRadius = "6px";
            article.style.boxShadow = "0 1px 3px rgba(0,0,0,0.1)";
            article.style.transition = "0.2s";
            article.style.background = this.selectedIds.has(book.id)
                ? "#eef2ff"
                : "#ffffff";

            if (this.selectedIds.has(book.id)) {
                article.style.outline = "2px solid #6366f1";
                article.style.borderColor = "#6366f1";
            }

            const imgWrap = document.createElement("div");
            imgWrap.style.position = "relative";

            const img = document.createElement("img");
            img.src = `${import.meta.env.BASE_URL}${book.cover_image}`;
            img.alt = book.title;
            img.style.width = "100%";
            img.style.height = "190px";
            img.style.objectFit = "cover";

            img.onerror = function () {
                this.onerror = null;
                this.src = `${import.meta.env.BASE_URL}book-placeholder.png`;
            };

            imgWrap.appendChild(img);

            const tick = document.createElement("div");
            tick.style.position = "absolute";
            tick.style.top = "8px";
            tick.style.right = "8px";
            tick.style.width = "24px";
            tick.style.height = "24px";
            tick.style.background = "#6366f1";
            tick.style.color = "#fff";
            tick.style.display = "flex";
            tick.style.alignItems = "center";
            tick.style.justifyContent = "center";
            tick.style.borderRadius = "50%";
            tick.style.opacity = this.selectedIds.has(book.id) ? "1" : "0";
            tick.style.transition = "0.2s";

            tick.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12l5 5l10 -10"></path>
                </svg>
            `;

            imgWrap.appendChild(tick);

            const details = document.createElement("div");
            details.style.padding = "12px";
            details.style.textAlign = "center";

            details.innerHTML = `
                <h3 style="font-size:14px; font-weight:600; color:#1f2937; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                    ${book.title}
                </h3>
                <p style="font-size:12px; color:#6b7280; margin-top:4px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                    by ${book.author ?? "Unknown"}
                </p>
                <span style="font-size:13px; color:#374151; font-weight:500; display:block; margin-top:4px;">
                    ₹${parseFloat(book.selling_price).toFixed(2)}
                </span>
            `;

            article.appendChild(imgWrap);
            article.appendChild(details);

            label.appendChild(input);
            label.appendChild(article);

            this.grid.appendChild(label);
        });
    }

    // ---------------------------------------------------------
    // SELECTED BOOK TAGS
    // ---------------------------------------------------------
    renderSelected() {
        if (!this.selectedList || !this.selectedBox) return;

        this.selectedList.innerHTML = "";

        if (this.selectedIds.size === 0) {
            this.selectedBox.style.display = "none";
            return;
        }

        this.selectedBox.style.display = "block";

        this.books
            .filter((b) => this.selectedIds.has(b.id))
            .forEach((b) => {
                const tag = document.createElement("span");
                tag.style.background = "#e0e7ff";
                tag.style.color = "#4338ca";
                tag.style.padding = "4px 8px";
                tag.style.borderRadius = "6px";
                tag.style.fontSize = "13px";
                tag.style.marginRight = "6px";
                tag.style.display = "inline-block";
                tag.textContent = b.title;

                this.selectedList.appendChild(tag);
            });
    }

    // ---------------------------------------------------------
    // FETCH BOOKS
    // ---------------------------------------------------------
    async fetchBooks(query = "") {
        if (!this.loader || !this.searchUrl) return;

        this.loader.style.display = "block";

        try {
            const response = await fetch(
                `${this.searchUrl}?q=${encodeURIComponent(query)}`
            );

            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            this.books = await response.json();
        } catch (error) {
            console.error("Search failed:", error);
            this.books = [];
        } finally {
            this.loader.style.display = "none";
            this.renderBooks();
        }
    }
}

document.addEventListener("DOMContentLoaded", () => new BookSelector());
