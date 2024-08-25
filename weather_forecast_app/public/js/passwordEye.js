// passwordの表示切替
$("#eyeIcon").on("click", () => {
    // eyeIconのclass切り替え
    $("#eyeIcon").toggleClass("bi-eye-slash bi-eye");

    // inputのtype切り替え
    if ($("#password").attr("type") == "password") {
    $("#password").attr("type", "text");
    } else {
    $("#password").attr("type", "password");
    }
});