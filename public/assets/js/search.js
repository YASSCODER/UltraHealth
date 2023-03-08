
jQuery(document).ready(function () {
    var searchRequest = null;

    $("#search").keyup(function () {
        var minlength = 1;
        var that = this;
        var value = $(this).val();
        var entitySelector = $("#entitiesNav").html('');
        if (value.length >= minlength) {
            if (searchRequest != null)
                searchRequest.abort();
            searchRequest = $.ajax({
                type: "GET",
                url: "{{ path('event_search') }}",
                data: {
                    'q': value
                },
                dataType: "text",
                success: function (msg) {
                    //we need to check if the value is the same
                    if (value === $(that).val()) {
                        var result = JSON.parse(msg);
                        $.each(result, function (key, arr) {
                            $.each(arr, function (id, value) {
                                if (key === 'events') {
                                    if (id !== 'error') {
                                        console.log(value);
                                        entitySelector.append('<li><b>' + '</b><a href="/event/' + id + '">' + value[0] + '</a></li>');
                                    } else {
                                        entitySelector.append('<li class="errorLi">' + value + '</li>');
                                    }
                                }
                            });
                        });
                    }
                }
            });
        }
    });
});
