//
import "preline";

function toggleMenu() {
    const menu = document.getElementById("mobile-menu");
    menu.classList.toggle("hidden");
}

lucide.createIcons();

const menuToggle = document.getElementById("menu-toggle");
const mobileMenu = document.getElementById("mobile-menu");
const iconMenu = document.getElementById("icon-menu");
const iconClose = document.getElementById("icon-close");

menuToggle.addEventListener("click", function () {
    const isHidden = mobileMenu.classList.contains("hidden");
    mobileMenu.classList.toggle("hidden");
    menuToggle.setAttribute("aria-expanded", String(isHidden));
    iconMenu.classList.toggle("hidden", isHidden);
    iconClose.classList.toggle("hidden", !isHidden);
});

function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("eye-icon");
    if (input.type === "password") {
        input.type = "text";
        icon.setAttribute("data-lucide", "eye");
    } else {
        input.type = "password";
        icon.setAttribute("data-lucide", "eye-off");
    }
    lucide.createIcons();
}
document.addEventListener("alpine:init", () => {
    Alpine.data("dragScroll", () => ({
        isDragging: false,
        startX: 0,
        scrollLeft: 0,
        container: null,

        initDragScroll(element) {
            this.container = element;
            this.container.style.cursor = "grab";
        },

        startDrag(event) {
            if (
                event.target.closest("button") ||
                event.target.closest("label") ||
                event.target.closest("input") ||
                event.target.closest("a")
            ) {
                return;
            }

            this.isDragging = true;
            this.startX = event.pageX - this.container.offsetLeft;
            this.scrollLeft = this.container.scrollLeft;
            this.container.style.cursor = "grabbing";
            this.container.style.userSelect = "none";
            this.container.style.scrollBehavior = "auto";
        },

        moveDrag(event) {
            if (!this.isDragging) return;
            event.preventDefault();
            const x = event.pageX - this.container.offsetLeft;
            const walk = (x - this.startX) * 1.5;
            this.container.scrollLeft = this.scrollLeft - walk;
        },

        endDrag() {
            if (this.isDragging) {
                this.isDragging = false;
                this.container.style.cursor = "grab";
                this.container.style.userSelect = "";
                this.container.style.scrollBehavior = "smooth";
            }
        },
    }));
});

document.addEventListener("DOMContentLoaded", function () {
    const containers = document.querySelectorAll(".variant-values-container");

    containers.forEach((container) => {
        let touchStartX = 0;
        let touchScrollLeft = 0;
        let isTouching = false;

        container.addEventListener(
            "touchstart",
            function (e) {
                if (
                    e.target.closest("button") ||
                    e.target.closest("label") ||
                    e.target.closest("input") ||
                    e.target.closest("a")
                ) {
                    return;
                }
                isTouching = true;
                touchStartX = e.touches[0].pageX - this.offsetLeft;
                touchScrollLeft = this.scrollLeft;
            },
            { passive: true },
        );

        container.addEventListener(
            "touchmove",
            function (e) {
                if (!isTouching) return;
                const x = e.touches[0].pageX - this.offsetLeft;
                const walk = (x - touchStartX) * 1.5;
                this.scrollLeft = touchScrollLeft - walk;
            },
            { passive: true },
        );

        container.addEventListener(
            "touchend",
            function () {
                isTouching = false;
            },
            { passive: true },
        );
    });
});
