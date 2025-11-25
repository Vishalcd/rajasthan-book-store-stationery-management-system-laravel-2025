document.addEventListener("DOMContentLoaded", () => {
    const tabButtons = document.querySelectorAll(".tab-btn");
    const tabContents = document.querySelectorAll(".tab-content");

    tabButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const target = btn.getAttribute("data-tab");

            // Reset all buttons
            tabButtons.forEach((b) => {
                b.classList.remove("text-indigo-600", "border-indigo-600");
                b.classList.add("text-gray-500", "border-transparent");
            });

            // Activate current button
            btn.classList.add("text-indigo-600", "border-indigo-600");
            btn.classList.remove("text-gray-500", "border-transparent");

            // Hide all content
            tabContents.forEach((c) => c.classList.add("hidden"));
            tabContents.forEach((c) => c.classList.remove("block"));

            // Show selected tab
            document.getElementById(`tab-${target}`).classList.remove("hidden");
            document.getElementById(`tab-${target}`).classList.add("block");
        });
    });
});
