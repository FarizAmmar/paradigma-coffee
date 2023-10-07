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
