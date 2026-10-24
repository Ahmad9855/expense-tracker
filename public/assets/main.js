
function validateAmount(amount) {
    if (amount === "" || amount === null || amount === undefined) {
        return false;
    }

    const value = Number(amount);

    return Number.isFinite(value) && value > 0;
}

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const amountInput = document.getElementById("amount");

    if (!form || !amountInput) {
        return;
    }

    form.addEventListener("submit", function (event) {
        if (!validateAmount(amountInput.value)) {
            event.preventDefault();
            alert("يرجى إدخال مبلغ أكبر من صفر.");
            amountInput.focus();
        }
    });
});
