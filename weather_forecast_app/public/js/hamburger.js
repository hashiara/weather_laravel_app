$(function(){
    $('#hamburger').click(function(){
        if ($('#hamburger').hasClass('open')) {
            $('#hamburgerIcon').removeAttr("hidden");
            $('#hamburgerIcon2').attr("hidden", true);
            $('#hamburger').removeClass('open');
        } else {
            $('#hamburgerIcon2').removeAttr("hidden");
            $('#hamburgerIcon').attr("hidden", true);
            $('#hamburger').addClass('open');
        }
    });
});