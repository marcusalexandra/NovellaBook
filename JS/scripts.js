// Toggle the sidebar when the sidebar toggle button is clicked
$(document).ready(function() {
    $("#sidebarToggle").on("click", function() {
        $("#sidebar").toggleClass("active");
    });
});