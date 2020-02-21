function JPlaceHolder(o) {
    this.container = o || $("body"),
    this.init()
} !
function(o, t, a, i) {
    var e = o(t);
    o.fn.flap = function(n) {
        function p() {
            r.each(function() {
                var t = o(this);
                o.abovethetop(this, c) || o.belowthefold(this, c) || t.trigger("appear")
            })
        }
        var s, r = this,
        c = {
            threshold: 0,
            container: t,
            event: "scroll"
        };
        return n && o.extend(c, n),
        s = c.container === i || c.container === t ? e: o(c.container),
        0 === c.event.indexOf("scroll") && s.bind(c.event,
        function() {
            return p()
        }),
        r.each(function() {
            var t = this,
            a = o(t);
            t.loaded = !1,
            a.on("appear",
            function() {
                if (!t.loaded) {
                    var o = a.attr("data-delay"),
                    i = a.attr("data-ani");
                    t.loaded = !0,
                    a.css({
                        visibility: "visible",
                        "animation-delay": o,
                        "-moz-animation-delay": o,
                        "-webkit-animation-delay": o,
                        "animation-name": i,
                        "-moz-animation-name": i,
                        "-webkit-animation-name": i
                    })
                }
            })
        }),
        e.bind("resize",
        function() {
            p()
        }),
        o(a).ready(function() {
            p()
        }),
        this
    },
    o.abovethetop = function(a, n) {
        var p;
        return p = n.container === i || n.container === t ? e.scrollTop() : o(n.container).offset().top,
        p >= o(a).offset().top + n.threshold + o(a).height()
    },
    o.belowthefold = function(a, n) {
        var p;
        return p = n.container === i || n.container === t ? (t.innerHeight ? t.innerHeight: e.height()) + e.scrollTop() : o(n.container).offset().top + o(n.container).height(),
        p <= o(a).offset().top - n.threshold
    }
} (jQuery, window, document),
JPlaceHolder.prototype = {
    _check: function() {
        return "placeholder" in document.createElement("input")
    },
    init: function() {
        this._check() || this.fix()
    },
    fix: function() {
        this.container.find("input[placeholder],textarea[placeholder]").each(function() {
            var o = $(this),
            t = o.attr("placeholder");
            o.val(t),
            o.focusin(function() {
                var o = $(this);
                o.val() == t && o.val("")
            }).focusout(function() {
                var o = $(this);
                "" == o.val() && o.val(t)
            })
        })
    }
};
var Reg = {
    email: /^(\w-*\.*)+@(\w-?)+(\.\w{1,})+$/,
    password: /^.{6,20}/,
    code: /^.{4}$/,
    checkCode: /^.{4}$/,
    tel: /(^1[0-9]{10}$)|(^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,8}$)/,
    companyName: /^.{1,50}$/,
    name: /^.{1,50}$/,
    message: /^.{1,500}$/,
    position: /.{0,50}$/
},
GetAttr = function(obj, attrStr) {
    if (void 0 == obj || void 0 == attrStr) return "";
    try {
        var result = eval("obj." + attrStr);
        return void 0 == result ? "": result
    } catch(ex) {
        return ""
    }
},
valiContent = function(o, t) {
    var t = t.find(".popbox-con"),
    a = t.find("input[name=" + o + "]");
    0 == a.length && (a = t.find("textarea[name=" + o + "]"));
    var i = a.closest(".popbox-inputbox").find(".popbox-input-tip"),
    e = a.attr("data-reg"),
    n = a.attr("data-tip");
    if (i.hide(), "checkbox" == a.attr("type")) var p = a.prop("checked") ? 1 : 0;
    else var p = $.trim(a.val());
    if ("cfmPassword" == e) {
        if (p !== t.find('input[name="password"]').val()) return i.html(n).show(),
        !1
    } else if ("checkbox" == a.attr("type")) {
        if (!p) return i.html(n).show(),
        !1
    } else {
        var s = Reg[e];
        if (!s.test(p)) return i.html(n).show(),
        !1
    }
    return p
},
valiDation = function(o, t) {
    if ($.isArray(o)) {
        for (var a = {},
        i = !0,
        e = o.length - 1; e >= 0; e--) {
            var n = o[e];
            a[n] = valiContent(n, t),
            a[n] === !1 && (i = !1)
        }
        return i ? a: !1
    }
    valiContent(o, t)
},
countDown = function(o) {
    o.addClass("cur"),
    o.html("60秒后获取");
    var t = 60,
    a = setInterval(function() {
        return t -= 1,
        0 == t ? (clearInterval(a), a = null, void o.html("点击获取验证码").removeClass("cur")) : void o.html(t + "秒后获取")
    },
    1e3)
},
setTipPop = function(o, t, a) {
    var t = t || 2600,
    i = "tip-pop err-pop";
    a && (i = "tip-pop");
    var e = $('<div class="' + i + '">' + o + "</div>");
    e.appendTo("body");
    var n = e.innerWidth(),
    p = e.innerHeight();
    e.css({
        marginTop: -p / 2,
        marginLeft: -n / 2
    }),
    e.animate({
        opacity: 1
    },
    600),
    setTimeout(function() {
        e.animate({
            opacity: 0
        },
        600,
        function() {
            e.remove()
        })
    },
    t)
},
setMinHeight = function() {
    var o = $(window).outerHeight(),
    t = $(".header").outerHeight(),
    a = $(".footer").outerHeight(),
    i = o - t - a;
    $(".main").css("min-height", i + "px")
},
formBounced = function(o) {
    $(".popbox").length > 0 && ($(".popbox").remove(), $(".popbox-wrap").remove()),
    window.scrollTo(0, 0),
    $("body").append(o)
},
throttle = function(o, t) {
    var a, i = o,
    e = !0;
    return function() {
        var o = arguments,
        n = this;
        return e ? (i.apply(n, o), e = !1) : a ? !1 : void(a = setTimeout(function() {
            clearTimeout(a),
            a = null,
            i.apply(n, o)
        },
        t || 30))
    }
},
browser = {
    versions: function() {
        {
            var o = navigator.userAgent;
            navigator.appVersion
        }
        return {
            trident: o.indexOf("Trident") > -1,
            presto: o.indexOf("Presto") > -1,
            webKit: o.indexOf("AppleWebKit") > -1,
            gecko: o.indexOf("Gecko") > -1 && -1 == o.indexOf("KHTML"),
            mobile: !!o.match(/AppleWebKit.*Mobile.*/),
            ios: !!o.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
            android: o.indexOf("Android") > -1 || o.indexOf("Linux") > -1,
            iPhone: o.indexOf("iPhone") > -1,
            iPad: o.indexOf("iPad") > -1,
            webApp: -1 == o.indexOf("Safari")
        }
    } (),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
},
scrollFn = function() {
    var o = $(window).scrollTop(),
    t = $(".back-top");
    o > 300 ? t.show() : t.hide()
};
/*$(".banner-owl").owlCarousel({
    items: 1,
    loop: !0,
    dots: !0,
    lazyLoad: !1,
    autoplay: !0,
    autoplayTimeout: 5e3,
    autoplayHoverPause: !0
}),
function(o) {
    var t = [".news-dynamic-owl", ".news-industry-owl", ".news-media-owl"],
    a = o(".news-box-tit"),
    i = (o(".news-container").find(".owl-carousel"), o(".case-item"));
    i.height(1.4375 * i.width()),
    o(".news-dynamic-owl").addClass("pass").owlCarousel({
        margin: 10,
        lazyLoad: !1,
        dots: !0,
        mouseDrag: !1,
        navText: ["", ""],
        loop: !0,
        nav: !0,
        autoplay: !0,
        autoplayTimeout: 4e3,
        autoplayHoverPause: !0,
        responsive: {
            0 : {
                items: 1
            },
            800 : {
                items: 2
            },
            1024 : {
                items: 3
            }
        }
    }),
    a.on("click",
    function() {
        var i = o(this);
        if (!i.hasClass("cur")) {
            var e = o(".news-box-nav").find(".cur"),
            n = e.index(),
            p = o(t[n]),
            s = i.index(),
            r = o(t[s]);
            a.removeClass("cur"),
            i.addClass("cur"),
            p.hide(),
            r.fadeIn(),
            r.hasClass("pass") || r.addClass("pass").owlCarousel({
                margin: 10,
                lazyLoad: !1,
                mouseDrag: !1,
                dots: !0,
                navText: ["", ""],
                loop: !0,
                nav: !0,
                autoplay: !0,
                autoplayTimeout: 4e3,
                autoplayHoverPause: !0,
                responsive: {
                    0 : {
                        items: 1
                    },
                    800 : {
                        items: 2
                    },
                    1024 : {
                        items: 3
                    }
                }
            })
        }
    })
} ($),
$(".leader-owl").owlCarousel({
    items: 1,
    loop: !0,
    dots: !0,
    smartSpeed: 1e3,
    margin: 10,
    lazyLoad: !1,
    mouseDrag: !1,
    autoplay: !0,
    autoplayTimeout: 5500,
    autoplayHoverPause: !0
}),
$(".cooperation-owl").owlCarousel({
    loop: !0,
    dots: !1,
    nav: !0,
    lazyLoad: !1,
    navText: ["", ""],
    autoWidth: !0,
    autoplay: !0,
    autoplayTimeout: 3e3,
    autoplayHoverPause: !0
}),*/
$(".header-more").on("click",
function() {
    $(".nav").stop().fadeToggle("slow")
}),
$(".back-top").on("click",
function() {
    $("html,body").animate({
        scrollTop: 0
    },
    300)
}),
$(".submit-btn").on("click",
function() {
    var o = {
        user: $.trim($(".input-name").val()),
        telphone: $.trim($(".input-tel").val()),
        email: $.trim($(".input-email").val()),
        message: $.trim($(".input-message").val())
    },
    o = valiDation(["user", "telphone", "email", "message"], $(".contactus-box"));
    o !== !1 && $.ajax({
        url: "/user/message",
        type: "POST",
        dataType: "json",
        data: o
    }).done(function(o) {
        200 == GetAttr(o, "meta.code") || 201 == GetAttr(o, "meta.code") ? (setTipPop("留言成功", 1600, !0), $(".contactus-input").val(""), new JPlaceHolder) : setTipPop(GetAttr(o, "meta.msg") || "系统处理异常！")
    }).fail(function() {
        setTipPop("系统处理异常！")
    })
}),
$(window).on("resize",
function() {
    setMinHeight()
}),
$(".aside ul li.consulting").on("click",function() {
    $(".aside ul li.consulting").addClass("active");
    $(".consulting_box").css("right", "40px");
}),
$(".consulting_box .close").on("click",function() {
    $(".aside ul li.consulting").removeClass("active");
    $(".consulting_box").css("right", "-250px");
}),
$("#close").on("click",function () {
    $("#show").animate({
        width: '40px'
    }, 100);
    $('.aside,#close').animate({
        width: 0
    }, 100);
}),
$("#show").on("click", function () {
    $("#show").animate({
        width: '0px'
    }, 100);
    $('.aside,#close').animate({
        width: "40px"
    }, 100);
}),
window.onscroll = throttle(scrollFn, 30),
$(document).ready(function() {
    setMinHeight(),
    new JPlaceHolder,
    $("img[data-src]").lazyload({
        data_attribute: "src",
        threshold: 350,
        skip_invisible: !1,
        effect: "fadeIn",
        placeholder: "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
    }),
    browser.versions.mobile ? ($(".nav-item-tail > .nav-item-a").attr("href", "javascript:void(0);"), $(".flap").addClass("flaped"), $(".icon-wx").on("click",
    function() {
        $(".footer-code").stop().fadeToggle()
    }), window.screen.availWidth >= 993 || $(document).width() >= 993 ? $("body").on("click.navClick", ".nav-item-tail",
    function() {
        var o = $(this).closest(".nav-item-tail").siblings(".nav-item-tail"),
        t = $(this).find(".nav-item-child");
        o.find(".nav-item-child").fadeOut(),
        t.stop().fadeToggle()
    }) : $("body").on("click.navClick", ".nav-item-tail",
    function() {
        var o = $(this).find(".nav-item-child");
        o.stop().fadeToggle()
    }), $(window).on("resize",
    function() {
        window.screen.availWidth >= 993 || $(document).width() >= 993 ? $("body").off("click.navClick").on("click.navClick", ".nav-item-tail",
        function() {
            var o = $(this).closest(".nav-item-tail").siblings(".nav-item-tail"),
            t = $(this).find(".nav-item-child");
            o.find(".nav-item-child").fadeOut(),
            t.stop().fadeToggle()
        }) : $("body").off("click.navClick").on("click.navClick", ".nav-item-tail",
        function() {
            var o = $(this).find(".nav-item-child");
            o.stop().fadeToggle()
        })
    }), $.getScript("",
    function() {
        FastClick.attach(document.body)
    })) : ($(".nav-item-tail").on("mouseenter",
    function() {
        var o = $(this).find(".nav-item-child");
        o.stop().fadeIn()
    }).on("mouseleave",
    function() {
        var o = $(this).find(".nav-item-child");
        o.stop().fadeOut()
    }), $(".icon-wx").on("mouseenter",
    function() {
        $(".footer-code").stop().fadeIn()
    }).on("mouseleave",
    function() {
        $(".footer-code").stop().fadeOut()
    }), $(".flap").flap())
});