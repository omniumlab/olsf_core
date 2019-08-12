jQuery(function($){
    var username = $('input[name="username"]')[0];
    $(username).focusin(function () { onInputFocusIn($(this).parent()); });
    $(username).focusout(function () { onInputFocusOut($(this).parent()); });

    var password = $('input[name="password"]')[0];
    $(password).focusin(function () { onInputFocusIn($(this).parent()); });
    $(password).focusout(function () { onInputFocusOut($(this).parent()); });

    function onInputFocusIn(input) {
        $(input).addClass("focused");
    }

    function onInputFocusOut(input) {
        $(input).removeClass("focused")
    }
});