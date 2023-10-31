const onChange = (className = "") => {
    const image = document.getElementById("location-element");
    const cart = document.getElementById("cart-element");
    if (className === "nav-link active") {
        // show image
        if (image && cart) {
            image.style.display = "block";
            cart.style.display = "none";
        }
        return;
    }
    if (image && cart) {
        image.style.display = "none";
        cart.style.display = "block";
    }
};

document.addEventListener("DOMContentLoaded", () => {
    const observerElement = document.getElementById("v-pills-bill-info-tab");
    if (!observerElement) return;

    const observer = new MutationObserver((mutationsList) => {
        mutationsList.forEach((mutation) => {
            if (mutation.attributeName === "class") {
                onChange(observerElement.className);
            }
        });
    });

    const options = { attributes: true, attributeFilter: ["class"] };
    observer.observe(observerElement, options);
});
