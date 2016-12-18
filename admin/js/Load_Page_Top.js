/*!
Javascript
 */
 
$.extend($.easing, {
easeInOutQuint: function(e, t, n, r, i) {
	return (t /= i / 2) < 1 ? r / 2 * t * t * t * t * t + n: r / 2 * ((t -= 2) * t * t * t * t + 2) + n
}//声明一些变量
});

// Loading效果开始
$(function() {
    widthTester = $(window).width();
    $("#container").prepend('<div id="loading"><span class="outer"><span class="inner"></span></span>&nbsp;正在努力为您打开网站<div class="loading-slow">看来您的网速很慢，或遇到阻碍。<br>请点击 <a href="#" id="refresh">这里</a> 尝试重新载入页面。<br> 或者点击 <a href="main.php" id="show-content">这里</a> 直接进入页面。</div></div>');
    setTimeout(function() {
        $(".loading-slow").fadeIn(500)
    },
    5e3);
    $("#refresh").click(function() {
        location.reload();
        return ! 1
    });
    $("#show-content").click(function() {
        $("#loading").fadeOut(500, 
        function() {
            $(this).remove();
            $(".pattern").removeClass("pattern-closed");
            $(window).width() > 1024 ? setTimeout(function() {
                $("#content").removeClass("loading")
            },
            550) : $("#content").removeClass("loading")
        });
        return ! 1
    });
    $(window).bind("scroll", 
    function() {
        scrollDisplayMenu()
    });
}); 

// Loading区域
$(window).load(function() {
    if ($("#content").hasClass("about")) {
        var e = function() {
            var e = $(window).width(),
            t = $(".blurb-photos").outerHeight(),
            n = $(".photos-holder").outerHeight(),
            r = (t - n - 30) * .5;
            if (e > 1024) {
                $(".blurb-photos").css("height", t);
                $(".photos-holder").css("margin-top", r).css("margin-bottom", r)
            }
        };
        e()
    } else if ($("#content").hasClass("work-home")) {
        var e = function() {
            var e = 0,
            t;
            $(".project p").each(function() {
                $this = $(this);
                if ($this.outerHeight() > e) {
                    t = this;
                    e = $this.outerHeight()
                }
            });
            $(".project p").height(e + "px")
        };
        e()
    }
    $(window).on("debouncedresize", 
    function() {
        widthTesterResized = $(window).width();
        if (widthTester != widthTesterResized) {
            $(".blurb-photos").attr("style", "");
            $(".photos-holder").attr("style", "");
            $(".project p").attr("style", "");
            setTimeout(function() {
                e()
            },
            350);
            t();
            widthTester = widthTesterResized
        }
    });
    var t = function() {
        $("#content").css("min-height", $(window).height())
    };
    t();
    $("#loading").fadeOut(500, 
    function() {
        $(this).remove();
        $("#content").removeClass("loading")
    })
});