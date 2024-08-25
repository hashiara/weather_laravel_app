$(function(){
    // ログアウト
    $("#logout_form").on("click", () => {
        $('#logout_form').submit();
    });

    // アカウント削除
    $("#delete_account_btn").on("click", () => {
        $('#delete_account_form').submit();
    });
});