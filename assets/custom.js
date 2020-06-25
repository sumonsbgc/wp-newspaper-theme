; (function ($) {
    $('#news-ticker-wrap').webTicker();

    $(document).ready(function () {
        $(".link").on("click", function (e) {
            e.preventDefault();
            var _target = $(this).data("target");
            var _filter = $(this).data("filter");
            var _nonce = $(this).data("nonce");

            $("#" + _target).addClass("active").siblings().removeClass("active");

            $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: "tabnews",
                    category: _filter,
                    nonce: _nonce
                },
                beforeSend: function () {
                    $("#" + _target).empty().html("Loading.....");
                },
                success: function (res) {
                    $("#" + _target).empty().html(res.data);
                },
                error: function (err) {
                    console.log(err);
                }
            });

        });


        //$(window).on("scroll", function (params) {
        //    var mainnews = $("#main_news").offset().top;
        //    var category_news = $("#category_news").offset().top;
        //    var pos = $("#main_news").position().top;
        //    console.log(pos);
        //});

    });


})(jQuery);