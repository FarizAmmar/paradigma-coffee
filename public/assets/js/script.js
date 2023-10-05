// Quantity Control
$(document).ready(function () {
    // Menangani penambahan jumlah
    $(".cs-increase").click(function () {
        var $quantityInput = $(this).siblings(".cs-form-quantity");
        var currentValue = parseInt($quantityInput.val());
        var maxValue = parseInt($quantityInput.attr("max"));

        if (
            !isNaN(currentValue) &&
            (isNaN(maxValue) || currentValue < maxValue)
        ) {
            $quantityInput.val(currentValue + 1);
        }
    });

    // Menangani pengurangan jumlah
    $(".cs-decrease").click(function () {
        var $quantityInput = $(this).siblings(".cs-form-quantity");
        var currentValue = parseInt($quantityInput.val());
        var minValue = parseInt($quantityInput.attr("min"));

        if (
            !isNaN(currentValue) &&
            (isNaN(minValue) || currentValue > minValue)
        ) {
            $quantityInput.val(currentValue - 1);
        }
    });

    // Memastikan bahwa input hanya menerima angka
    $(".cs-form-quantity").on("input", function () {
        var $this = $(this);
        var value = $this.val().replace(/[^0-9]/g, "");
        $this.val(value);
    });
});
