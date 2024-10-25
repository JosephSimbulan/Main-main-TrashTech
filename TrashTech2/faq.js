document.addEventListener("DOMContentLoaded", function() {
    const faqItems = document.querySelectorAll(".faq-item");

    faqItems.forEach(item => {
        const question = item.querySelector(".faq-question");
        const answer = item.querySelector(".faq-answer");
        const toggle = item.querySelector(".faq-toggle");

        question.addEventListener("click", () => {
            // Toggle visibility using classList
            answer.classList.toggle("active");

            // Set max-height for smooth expansion based on content height
            if (answer.classList.contains("active")) {
                answer.style.maxHeight = answer.scrollHeight + "px";
                toggle.textContent = "-";
            } else {
                answer.style.maxHeight = null; // Collapse it
                toggle.textContent = "+";
            }
        });
    });
});
