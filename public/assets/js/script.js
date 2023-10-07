// Quantity Control
function DecreaseQty() {
    var currentValue = parseInt($("#quantityInput").val(), 10);
    if (currentValue > 1) {
        $("#quantityInput").val(currentValue - 1);
    }
}

function IncreaseQty() {
    var currentValue = parseInt($("#quantityInput").val(), 10);
    if (currentValue < 99) {
        $("#quantityInput").val(currentValue + 1);
    }
}
