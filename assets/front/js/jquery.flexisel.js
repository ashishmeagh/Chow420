! function(e) {
    e.fn.flexisel = function(i) {
        var n, t = e.extend({
            
                visibleItems: 4,
                animationSpeed: 200,
                autoPlay: !1,
                infinite: true,
                autoPlaySpeed: 3e3,
                pauseOnHover: !0,
                setMaxWidthAndHeight: !1,
                enableResponsiveBreakpoints: !0,
                clone: !0,
                responsiveBreakpoints: {
                    portrait: {
                        changePoint: 480,
                        visibleItems: 1
                    },
                    landscape: {
                        changePoint: 640,
                        visibleItems: 2
                    },
                    tablet: {
                        changePoint: 768,
                        visibleItems: 3
                    },
                       ipadpro: {
                      changePoint:991,
                      visibleItems: 3,
                      itemsToScroll: 1
                      },
                    ipad: {
                      changePoint:1024,
                      visibleItems: 3,
                      itemsToScroll: 1
                      }
                   
                }
            }, i),
            s = e(this),
            l = e.extend(t, i),
            a = !0,
            o = l.visibleItems,
            r = s.children().length,
            c = [],
            f = {
                init: function() {
                    return this.each(function() {
                        f.appendHTML(), f.setEventHandlers(), f.initializeItems()
                    })
                },
                initializeItems: function() {
                    var i = s.parent(),
                        t = (i.height(), s.children());
                    f.sortResponsiveObject(l.responsiveBreakpoints);
                    var a = i.width();
                    n = a / o, t.width(n), l.clone && (t.last().insertBefore(t.first()), t.last().insertBefore(t.first()), s.css({
                        left: -n
                    })), s.fadeIn(), e(window).trigger("resize")
                },
                appendHTML: function() {
                    if (s.addClass("nbs-flexisel-ul"), s.wrap("<div class='nbs-flexisel-container'><div class='nbs-flexisel-inner'></div></div>"), s.find("li").addClass("nbs-flexisel-item"), l.setMaxWidthAndHeight) {
                        var i = e(".nbs-flexisel-item img").width(),
                            n = e(".nbs-flexisel-item img").height();
                        e(".nbs-flexisel-item img").css("max-width", i), e(".nbs-flexisel-item img").css("max-height", n)
                    }
                    if (e("<div class='nbs-flexisel-nav-left' title='Previous'></div><div class='nbs-flexisel-nav-right' title='Next'></div>").insertAfter(s), l.clone) {
                        var t = s.children().clone();
                        s.append(t)
                    }
                },
                setEventHandlers: function() {
                    var i = s.parent(),
                        t = s.children(),
                        r = i.find(e(".nbs-flexisel-nav-left")),
                        c = i.find(e(".nbs-flexisel-nav-right"));
                    e(window).on("resize", function(a) {
                        f.setResponsiveEvents();
                        var d = e(i).width(),
                            p = e(i).height();
                        n = d / o, t.width(n), l.clone ? s.css({
                            left: -n
                        }) : s.css({
                            left: 0
                        });
                        var v = p / 2 - r.height() / 2;
                        r.css("top", v + "px"), c.css("top", v + "px")
                    }), e(r).on("click", function(e) {
                        f.scrollLeft()
                    }), e(c).on("click", function(e) {
                        f.scrollRight()
                    }), 1 == l.pauseOnHover && e(".nbs-flexisel-item").on({
                        mouseenter: function() {
                            a = !1
                        },
                        mouseleave: function() {
                            a = !0
                        }
                    }), 1 == l.autoPlay && setInterval(function() {
                        1 == a && f.scrollRight()
                    }, l.autoPlaySpeed)
                },
                setResponsiveEvents: function() {
                    var i = e("html").width();
                    if (l.enableResponsiveBreakpoints) {
                        var n = c[c.length - 1].changePoint;
                        for (var t in c) {
                            if (i >= n) {
                                o = l.visibleItems;
                                break
                            }
                            if (i < c[t].changePoint) {
                                o = c[t].visibleItems;
                                break
                            }
                        }
                    }
                },
                sortResponsiveObject: function(e) {
                    var i = [];
                    for (var n in e) i.push(e[n]);
                    i.sort(function(e, i) {
                        return e.changePoint - i.changePoint
                    }), c = i
                },
                scrollLeft: function() {
                    if (s.position().left < 0 && 1 == a) {
                        a = !1;
                        var e = s.parent().width();
                        n = e / o;
                        var i = s.children();
                        s.animate({
                            left: "+=" + n
                        }, {
                            queue: !1,
                            duration: l.animationSpeed,
                            easing: "linear",
                            complete: function() {
                                l.clone && i.last().insertBefore(i.first()), f.adjustScroll(), a = !0
                            }
                        })
                    }
                },
                scrollRight: function() {
                    var e = s.parent().width(),
                        i = (n = e / o) - e,
                        t = s.position().left + (r - o) * n - e;
                    if (i < Math.ceil(t) && !l.clone) 1 == a && (a = !1, s.animate({
                        left: "-=" + n
                    }, {
                        queue: !1,
                        duration: l.animationSpeed,
                        easing: "linear",
                        complete: function() {
                            f.adjustScroll(), a = !0
                        }
                    }));
                    else if (l.clone && 1 == a) {
                        a = !1;
                        var c = s.children();
                        s.animate({
                            left: "-=" + n
                        }, {
                            queue: !1,
                            duration: l.animationSpeed,
                            easing: "linear",
                            complete: function() {
                                c.first().insertAfter(c.last()), f.adjustScroll(), a = !0
                            }
                        })
                    }
                },
                adjustScroll: function() {
                    var e = s.parent(),
                        i = s.children(),
                        t = e.width();
                    n = t / o, i.width(n), l.clone && s.css({
                        left: -n
                    })
                }
            };
        return f[i] ? f[i].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof i && i ? void e.error('Method "' + method + '" does not exist in flexisel plugin!') : f.init.apply(this)
    }
}(jQuery), $(window).load(function() {
    $("#flexiselDemo1").flexisel({
        visibleItems: 5,
        animationSpeed: 200,
        autoPlay: !1, 
        autoPlaySpeed: 3e3,
        infinite: true,
        pauseOnHover: !0,
        enableResponsiveBreakpoints: !0,
        responsiveBreakpoints: {
            portrait: {
                changePoint: 582,
                visibleItems: 1
            },
            landscape: {
                changePoint: 640,
                visibleItems: 3
            },
            tablet: {
                changePoint: 991,
                visibleItems: 4
            },
            laptop: {
                changePoint: 1200,
                visibleItems: 5
            }
        }
    })
});