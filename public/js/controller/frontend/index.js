(function() {

    $(document).ready(function() {

        $("#calendar-toolbar-datepicker-submit").hide();

        /* Beautify messages panel */

        var messagesPanel = $(".messages-panel");
        var calendar = $("#calendar");

        if (messagesPanel.length && calendar.length) {
            messagesPanel.css({
                "position": "absolute",
                "z-index": 2048,
                "min-width": 300
            }).position({
                "my": "center top+24",
                "at": "center top",
                "of": calendar
            }).delay(2500).fadeOut(1000, function() {
                $(this).remove();
            });

            $(document).trigger("updateLayout");
        }

    });

})();