/*global $ */

function fetch_modal(url) {
    "use strict";

    $(".errorMsg").css("opacity", "0");
    $.ajax({
        url : url,
        dataType : 'html',
        success : function (data) {
            var remodal = $('[data-remodal-id=modal]').remodal();
            $(".remodal").html($(data));
            remodal.open();
        },
        error : function (data) {
            $(".errorMsg").html("Errore - Impossibile effettuare l'operazione").css("opacity", "1");
        }
    });
}
function fetch_section(body, url, data, cb) {
    "use strict";
    body.addClass("load");
    $(".errorMsg").css("opacity", "0");
    $.ajax({
        url : url,
        data : data,
        type : 'POST',
        dataType: 'html',
        success : function (data) {
            body.append(data);
            body.removeClass("load");
            if (cb) {
                cb();
            }
        },
        error : function () {
            body.removeClass("load");
            $(".errorMsg").html("Errore - Impossibile effettuare l'operazione").css("opacity", "1");
        }
    });
}
function fetch_post(body, url, data, cb) {
    "use strict";
    body.addClass("load");
    $(".errorMsg").css("opacity", "0");
    $.ajax({
        url : url,
        data : data,
        type : 'POST',
        success : function (data) {
            body.removeClass("load");
            if (cb) {
                cb();
            }
        },
        error : function () {
            body.removeClass("load");
            $(".errorMsg").html("Errore - Impossibile effettuare l'operazione").css("opacity", "1");
        }
    });
}

function do_login() {
    "use strict";
    var body = $("body"),
        form = $("#login-form"),
        url = form.attr("action"),
        name = $("input[name='name']", form).val(),
        pass = $("input[name='pass']", form).val();

    fetch_section(body, url,
        {
            'name' : name,
            'pass' : pass
        }, function () {
            $("section#login").remove();
            setTimeout(function () {
                body.removeClass("hero");
            }, 300);
        });
}
function load_login() {
    "use strict";
    var body = $("body"),
        url = body.attr("data-login"),
        logged = body.attr("data-islogged"),
        next = body.attr("data-next");

    if (logged === "1") {
        fetch_section(body, next, {}, function () {
            setTimeout(function () {
                body.removeClass("hero");
            }, 500);
        });
    } else {
        fetch_section(body, url, {}, function () {
            $("#login-form").submit(function (e) {
                e.preventDefault();
                e.stopPropagation();
                body.addClass("load");
                setTimeout(do_login, 500);
            });
        });
    }


}

//This is the main code.
var target_url = "index.php";
function init() {
    "use strict";
    load_login();

    $("body").on('click', '.open-mod', function (e) {
        var target = $(this).attr("href");
        e.preventDefault();
        e.stopPropagation();

        fetch_modal(target);
    });
    $("body").on('click', '.open-refresh', function (e) {
        var target = $(this).attr("href"),
            body = $("body");
        e.preventDefault();
        e.stopPropagation();

        body.addClass("load");
        if (typeof (target) !== typeof (void(0)) && target.length > 0) {
            $.ajax({
                url : target,
                success : function () {
                    setTimeout(function () {
                        $("section").remove();
                        fetch_section(body, target_url, {});
                    }, 500);
                },
                error : function () {
                    body.removeClass("load");
                    $(".errorMsg").html("Errore - Impossibile effettuare l'operazione").css("opacity", "1");
                }
            });
        } else {
            setTimeout(function () {
                $("section").remove();
                fetch_section(body, target_url, {});
            }, 500);
        }
    });
    $("body").on('click', '#doContact', function (e) {
        var url = $(this).attr('data-action'),
            data = $("#contact_txt").val(),
            body = $("body");
        
        fetch_post(body, url, {
            'msg' : data
        }, function () {
            $(".errorMsg").html("Operazione completata").css("opacity", "1");
        });
    });
    $("body").on('click', '.toggle:not(.active)', function (e) {
        var elem = $(this),
            filter = elem.attr("data-filter");
        
        $("a.toggle.active").removeClass("active");
        elem.addClass("active");
        
        //Remove previous hides
        $('tr[data-type].hidden').removeClass('hidden').fadeIn(500);
        if (filter.length > 0) {
            $('tbody tr:not([data-type="' + filter + '"])').addClass('hidden').fadeOut(500);
        }
    });
}

$(init);
