// Navigation New Employee
// Klik New
$("#btn-new").click(function () {
    $("#btn-new").addClass("active");
    $("#btn-listing").addClass("text-secondary");
    $("#view-form").addClass("d-none");
    $("#new-breadcrumb").addClass("active");

    $("#btn-new").removeClass("text-secondary");
    $("#btn-listing").removeClass("active");
    $("#new-form").removeClass("d-none");
    $("#new-breadcrumb").removeClass("d-none");
    $("#view-breadcrumb").removeClass("active");
});

// Klik Listing
$("#btn-listing").click(function () {
    $("#btn-listing").addClass("active");
    $("#btn-new").addClass("text-secondary");
    $("#new-form").addClass("d-none");
    $("#new-breadcrumb").addClass("d-none");
    $("#view-breadcrumb").addClass("active");

    $("#btn-listing").removeClass("text-secondary");
    $("#btn-new").removeClass("active");
    $("#view-form").removeClass("d-none");
    $("#new-breadcrumb").removeClass("active");
});

function SelectAll() {
    var selectAllCheckbox = document.getElementById("select-all");
    var selectItemCheckboxes = document.getElementsByName("select-item[]");

    // Periksa apakah "Select All" dicentang atau tidak
    var isChecked = selectAllCheckbox.checked;

    // Atur tindakan "Select All" pada semua elemen "select-item"
    for (var i = 0; i < selectItemCheckboxes.length; i++) {
        selectItemCheckboxes[i].checked = isChecked;
    }
}

function OnButtonAccept() {
    var selectedItems = [];
    var checkboxes = $('input[name="select-item[]"]:checked');

    checkboxes.each(function (index, checkbox) {
        var uuid = $(checkbox).data("uuid");
        var status = $(checkbox).data("status");
        var menuId = $(checkbox).data("menu-id");
        selectedItems.push({ uuid, status, menuId });

        var url =
            "/order/waiting-list/status/" + uuid + "/" + status + "/" + menuId;

        $.ajax({
            type: "GET",
            url: url,
            data: {
                uuid: uuid,
                status: status,
                menuId: menuId,
            },
            success: function (data) {
                switch (data.status) {
                    case "P":
                        window.location.href = "/order/waiting-list";
                        break;
                    case "D":
                        window.location.href = "/order";
                        break;
                    default:
                        break;
                }
            },
            error: function (error) {
                alert("Error!!");
            },
        });
    });
}

new DataTable("#myTables", {
    responsive: true,
});
