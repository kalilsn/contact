$(function() {
    var $form = $("form");
    var url = $form.attr("action");
    var $responseDiv = $("#response");

    $form.submit(function(e) {
        //Client-side validation handled by html, server-side by php
        //For users without JS, form will still submit
        e.preventDefault();
        $.post(url, $form.serialize(), formSuccess
        ).fail(function(xhr) {
            $responseDiv.html(xhr.responseText);
        });
    });

    function formSuccess(data) {
        $responseDiv.html(data);
        $form.hide();
    }
});