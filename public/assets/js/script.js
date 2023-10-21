// Function to handle decrease button
function OnDecrease(button) {
    var container = $(button).closest(".container");
    var inputElement = container.find(".order-qty");
    var currentQuantity = parseInt(inputElement.val());

    if (currentQuantity > 1) {
        inputElement.val(currentQuantity - 1);
        updateTotalPrice(container);
    }
}

// Function to handle increase button
function OnIncrease(button) {
    var container = $(button).closest(".container");
    var inputElement = container.find(".order-qty");
    var currentQuantity = parseInt(inputElement.val());
    var maxQuantity = parseInt(inputElement.attr("max"));

    if (currentQuantity < maxQuantity) {
        inputElement.val(currentQuantity + 1);
        updateTotalPrice(container);
    }
}

// Function to update the total price
function updateTotalPrice(container) {
    var totalElement = container.find(".total-price");
    var orderQtyElement = container.find(".order-qty");
    var menuId = container.find("[name='menu_id[]']").val();
    var menuPrice = container.find("[name='menu_price[]']").val();
    var currentQuantity = parseInt(orderQtyElement.val());

    var userId = $("input[name='user_id']").val();

    var url =
        "/order/menu/update/" + userId + "/" + menuId + "/" + currentQuantity;

    $.ajax({
        type: "GET",
        url: url,
        data: {
            menuId: menuId,
            newQuantity: currentQuantity + 1,
        },
        success: function (data) {
            var totalPrice = menuPrice * data.cart.order_qty;
            totalElement.text("Rp." + totalPrice);
            $("#sub-total").text("Rp." + data.summary.total_amount);
        },
        error: function (error) {},
    });
}

function SelectAllCart() {
    var selectAllCheckbox = document.getElementById("select-all");
    var selectItemCheckboxes = document.getElementsByName("select-item[]");

    // Periksa apakah "Select All" dicentang atau tidak
    var isChecked = selectAllCheckbox.checked;

    // Atur tindakan "Select All" pada semua elemen "select-item"
    for (var i = 0; i < selectItemCheckboxes.length; i++) {
        selectItemCheckboxes[i].checked = isChecked;
    }
}
