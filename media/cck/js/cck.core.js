/* Copyright (C) 2009 - 2018 SEBLOD. All Rights Reserved. */
if("undefined"===typeof JCck)var JCck={};
!(function ($) {
    function myCheck(e, t) {
        return 0 <= $.inArray(e, t) ? 1 : 0;
    }
    function myModal(e) {
        var s = {
            modal: null,
            defaults: {
                backclose: !0,
                backdrop: !0,
                body: !0,
                callbacks: {},
                class: "",
                close: !0,
                group: "ajax",
                header: !0,
                html: {
                    close: '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>',
                    loading: '<div class="loading"></div>',
                    navigation: '<a class="prev" href="javascript:void(0);"><span><</span></a><a class="next" href="javascript:void(0);"><span>></span></a>',
                },
                id: "modal-cck",
                keyboard: !0,
                loading: !0,
                loop: !1,
                message: { selector: "" },
                mode: "ajax",
                navigation: !1,
                title: !0,
                url: { tmpl: "" }
            }
        };
        return (
            (s.settings = $.extend(s.defaults, e || {})),
            (s.groups = { ajax: [] }),
            (s.currentIndex = 0),
            (s.referrer = null),
            (s.build = function () {
                return (
                    s.remove(),
                    $("body").append(
                        '<div id="' + s.settings.id + '" class="modal fade modal-' +
                            s.settings.mode +
                            ("" != s.settings.class ? " " + s.settings.class : "") +
                            '" aria-hidden="true"><div class="modal-dialog">' +
                            (s.settings.navigation ? '<div class="modal-navigation">' + s.settings.html.navigation + "</div>" : "") +
                            '<div class="modal-content">' +
                            (s.settings.header ? '<div class="modal-header">' + (s.settings.title ? "<h3>" + (!0 !== s.settings.title ? s.settings.title : "") + "</h3>" : "") + "</div>" : "") +
                            
                            ("" != s.settings.message.selector ? '<div class="modal-message"></div>' : "") +
                            (s.settings.body ? '<div class="modal-body"></div>' : "") +
                            "</div></div></div></div>"
                    ),
                    "" != s.settings.message.selector && $("body " + s.settings.message.selector).length && $("body " + s.settings.message.selector).appendTo(".modal-message"),
                    (s.modal = $("#" + s.settings.id)),
                    (s.container = s.modal.find(s.settings.body ? ".modal-body" : ".modal-content")),
                    s.settings.close && $(s.settings.html.close).prependTo(s.settings.header ? s.modal.find(".modal-header") : s.modal.find(".modal-content")),
                    (s.bs_modal = new bootstrap.Modal( s.modal, { backdrop: 0 != s.settings.backdrop && (0 != s.settings.backclose || "static"), keyboard: s.settings.keyboard })),
                    (bs_modal_ev = document.getElementById(s.settings.id)),
                    bs_modal_ev.addEventListener('show.bs.modal', function (e) {
                        e.stopPropagation(), $("html").css("overflow", "hidden"), s.callbacks.show(e);
                    }),
                    bs_modal_ev.addEventListener("shown.bs.modal", function (e) {
                        e.stopPropagation(), s.callbacks.shown(e);
                    }),
                    bs_modal_ev.addEventListener("hide.bs.modal", function (e) {
                        e.stopPropagation(), s.callbacks.hide(e);
                    }),
                    bs_modal_ev.addEventListener("hidden.bs.modal", function (e) {
                        e.stopPropagation(), $("html").css("overflow", "auto"), s.callbacks.hidden(e);
                    }),
                    s
                );
            }),
            (s.callbacks = {
                show: function (e) {
                    void 0 !== s.settings.callbacks.show && s.settings.callbacks.show(e);
                },
                load: function () {
                    s.container.empty(),
                        s.settings.loading && s.container.append(s.settings.html.loading),
                        s.settings.navigation && s.modal.find(".modal-navigation > a").addClass("hidden"),
                        void 0 !== s.settings.callbacks.load && s.settings.callbacks.load();
                },
                loaded: function () {
                    if ((s.settings.loading && s.container.find(".loading").remove(), s.settings.title)) {
                        var e = s.modal.find("[data-cck-modal-title]");
                        e.length && s.modal.find(".modal-header h3").html(e.html());
                    }
                    var t = s.modal.find("[data-cck-modal-hash]");
                    t.length && (window.location.hash = t.html()),
                        s.settings.navigation &&
                            1 < s.groups[s.settings.group].length &&
                            (s.settings.loop
                                ? s.modal.find(".modal-navigation > a").removeClass("hidden")
                                : (0 != s.currentIndex && s.modal.find(".modal-navigation > a.prev").removeClass("hidden"),
                                  s.currentIndex != s.groups[s.settings.group].length - 1 && s.modal.find(".modal-navigation > a.next.hidden").removeClass("hidden"))),
                        void 0 !== s.settings.callbacks.loaded && s.settings.callbacks.loaded();
                },
                shown: function (e) {
                    var t = $(window).scrollTop();
                    $(window).on("scroll", function () {
                        $(document).scrollTop(t);
                    }),
                        s.settings.navigation &&
                            (s.modal.find(".modal-navigation > a.prev").on("click", function (e) {
                                e.preventDefault(), s.loadPrev();
                            }),
                            s.modal.find(".modal-navigation > a.next").on("click", function (e) {
                                e.preventDefault(), s.loadNext();
                            })),
                        s.settings.keyboard && $(document.documentElement).on("keyup", s.keyboardHandler),
                        void 0 !== s.settings.callbacks.shown && s.settings.callbacks.shown(e);
                },
                hide: function (e) {
                    void 0 !== s.settings.callbacks.hide && s.settings.callbacks.hide(e);
                },
                hidden: function (e) {
                    $(window).off("scroll"), history.replaceState("", document.title, window.location.pathname + window.location.search), s.bs_modal.dispose(), s.remove(), void 0 !== s.settings.callbacks.hidden && s.settings.callbacks.hidden(e);
                },
                destroy: function () {
                    void 0 !== s.settings.callbacks.destroy && s.settings.callbacks.destroy(), s.remove(), void 0 !== (s = {}).settings.callbacks.destroyed && s.settings.callbacks.destroyed();
                },
                destroyed: function () {
                    void 0 !== s.settings.callbacks.destroyed && s.settings.callbacks.destroyed();
                },
            }),
            (s.destroy = function () {
                return s.callbacks.destroy(), this;
            }),
            (s.hide = function () {
                return s.bs_modal.hide(), this;
            }),
            (s.init = function () {
                return (
                    $.each(s.groups, function (n, e) {
                        $.each(e, function (i) {
                            $(this).off("click"),
                                $(this).on("click", function (e) {
                                    e.preventDefault();
                                    var t = $(this),
                                        a = t.attr("href");
                                    (s.referrer = this), (s.settings = $.extend(s.settings, t.data("cck-modal") || {})), (s.settings.group = n), (s.currentIndex = i), s.loadUrl(a);
                                });
                        });
                    }),
                    this
                );
            }),
            (s.keyboardHandler = function (e) {
                switch ((e.preventDefault(), e.keyCode)) {
                    case 27:
                        s.hide();
                }
                if (s.settings.navigation)
                    switch (e.keyCode) {
                        case 37:
                            s.loadPrev();
                            break;
                        case 39:
                            s.loadNext();
                    }
            }),
            (s.load = function (e, a) {
                switch ((s.callbacks.load(), s.settings.mode)) {
                    case "iframe":
                        var t = '<iframe src="' + e + '" width="100%" height="100%" frameborder="0"></iframe>';
                        s.container.html(t), s.callbacks.loaded(), a && s.show();
                        break;
                    case "image":
                        var i = '<img src="' + e + '" />';
                        s.container.html(i), s.callbacks.loaded(), a && s.show();
                        break;
                    default:
                        $.ajax({ url: e, cache: !1 })
                            .done(function (e) {
                                s.container.html(e), s.callbacks.loaded(), a && s.show();
                            })
                            .fail(function (e, t) {
                                window.location.hash && history.replaceState("", document.title, window.location.pathname + window.location.search),
                                    s.container.html('<span data-cck-modal-title style="display:none;">' + e.status + " " + e.statusText + "</span>The requested page can't be found or you are not authorised to view this resource."),
                                    s.callbacks.loaded(),
                                    a && s.show();
                            });
                }
                return this;
            }),
            (s.loadPrev = function () {
				if (s.currentIndex == 0) {
					if (s.settings.loop) {
						s.currentIndex = (s.groups[s.settings.group].length - 1);
					} else {
						return this;
					}
				} else {
					s.currentIndex--;
				}
				var url = $(s.groups[s.settings.group][s.currentIndex]).attr('href');
				if (s.settings.url.tmpl) {
					if (url.indexOf('?') > -1) {
						url += '&';
					} else {
						url += '?';
					}
					url += 'tmpl='+s.settings.url.tmpl;
				}
				s.load(url,false);
				return this;
            }),
            (s.loadNext = function () {
				if (s.currentIndex == s.groups[s.settings.group].length - 1) {
					if (s.settings.loop) {
						s.currentIndex = 0;
					} else {
						return this;
					}
				} else {
					s.currentIndex++;
				}
				var url = $(s.groups[s.settings.group][s.currentIndex]).attr('href');
				if (s.settings.url.tmpl) {
					if (url.indexOf('?') > -1) {
						url += '&';
					} else {
						url += '?';
					}
					url += 'tmpl='+s.settings.url.tmpl;
				}
				s.load(url,false);
				return this;
            }),
            (s.loadHtml = function (e) {
                s.build(), s.callbacks.load(), s.container.html(e), s.callbacks.loaded(), s.show();
            }),
            (s.loadUrl = function (a) {
                $.each(s.groups.ajax, function (e, t) {
                    if (JCck.Core.sourceURI + t.attr("href") == a) return (s.settings.group = "ajax"), (s.currentIndex = e), !1;
                }),
                    s.settings.url.tmpl && (-1 < a.indexOf("?") ? (a += "&") : (a += "?"), (a += "tmpl=" + s.settings.url.tmpl)),
                    s.build().load(a, !0);
            }),
            (s.remove = function () {
                return $("#" + s.settings.id).remove(), s.settings.keyboard && $(document.documentElement).off("keyup", s.keyboardHandler), this;
            }),
            (s.show = function () {
                return s.bs_modal.show(), this;
            }),
            s
        );
    }
    function myOpposite(e) {
        return 1 == e ? 0 : 1;
    }
    void 0 === JCck.Core && (JCck.Core = {}),
        (JCck.Core.doTask = function (e, t, a) {
            void 0 === a && (a = document.getElementById("adminForm"));
            var i = a[e],
                n = t.split(".");
            if (i) {
                for (var s = 0; ; s++) {
                    var o = a["cb" + s];
                    if (!o) break;
                    o.checked = !1;
                }
                (i.checked = !0), (a.boxchecked.value = 1), "update" == n[0] && "" != n[1] && ((t = n[0]), jQuery("#seblod_form").append('<input type="hidden" id="task2" name="task2" value="' + n[1] + '">')), Joomla.submitbutton(t);
            }
            return !1;
        }),
        (JCck.Core.executeFunctionByName = function (e, t) {
            for (var a = [].slice.call(arguments).splice(2), i = e.split("."), n = i.pop(), s = 0; s < i.length; s++) t = t[i[s]];
            return t[n].apply(this, a);
        }),
        (JCck.Core.getModal = function (e) {
            return myModal(e);
        }),
        (JCck.Core.submitForm = function (e, t) {
            void 0 === t && (t = document.getElementById("adminForm")),
                void 0 !== e && "" !== e && (t.task.value = e),
                "function" == typeof t.onsubmit && t.onsubmit(),
                "function" == typeof t.fireEvent && t.fireEvent("onsubmit"),
                "function" != typeof jQuery || "form.cancel" == e || "cancel" == e ? t.submit() : ("search" == e && jQuery("[data-cck-remove-before-search]", "#" + t.id).removeAttr("name"), jQuery(t).submit());
        }),
        (JCck.Core.submitTask = function (e, t, a, i) {
            jQuery("#" + i + ' input:checkbox[name="cid[]"]:checked').prop("checked", !1),
                jQuery("#" + i + " #" + a).prop("checked", !0),
                jQuery("#" + i + " #boxchecked").myVal(1),
                jQuery("#" + i).append('<input type="hidden" name="tid" value="' + t + '">'),
                JCck.Core.submitForm(e, document.getElementById(i)),
                jQuery("#" + i + " #" + a).prop("checked", !1);
        }),
        (JCck.Modals = []),
        ($.fn.clearForm = function () {
            return this.each(function () {
                $(":input", this).each(function () {
                    var e = this.type,
                        t = this.tagName.toLowerCase();
                    if ("text" == e || "password" == e || "textarea" == t) this.value = "";
                    else if ("hidden" == e) $(this)[0].hasAttribute("data-cck-keep-for-search") || (this.value = "");
                    else if ("checkbox" == e || "radio" == e) this.checked = !1;
                    else if ("select-multi" == e || "select-multiple" == e) this.selectedIndex = -1;
                    else if ("select" == t) {
                        for (var a = 0, i = 0; i < this.options.length; i++)
                            if ("" == this.options[i].value) {
                                a = 1;
                                break;
                            }
                        a ? (this.value = "") : (this.selectedIndex = 0);
                    }
                });
            });
        }),
        ($.fn.conditionalState = function (o) {
            var l = $(this),
                e = o.rule || "";
            if (1 < o.conditions.length) {
                var d = "or" == e ? 1 : o.conditions.length,
                    c = {};
                jQuery.each(o.conditions, function (e, i) {
                    var n = $("#" + i.trigger);
                    if (i.trigger && null != n) {
                        var s = i.type;
                        if ("isChanged" == s) s = "change";
                        else if ("isPressed" == s) s = "click";
                        else if ("isSubmitted" == s) s = "keypress";
                        else {
                            c[n.attr("id")] = parseInt(n.myConditional(i.type, i));
                            var a = 0;
                            jQuery.each(c, function (e, t) {
                                1 == t && a++;
                            }),
                                (r = d <= a ? 1 : 0),
                                jQuery.each(o.states, function (e, t) {
                                    l.myState(0, r, t.type, t);
                                }),
                                (s = "change");
                        }
                        n.on(s, function (e) {
                            if ("keypress" != s || 13 == e.which) {
                                var t = parseInt(n.myConditional(i.type, i));
                                if ("click" == s || "keypress" == s) var a = t;
                                else {
                                    a = 0;
                                    c[n.attr("id")] = t;
                                }
                                jQuery.each(c, function (e, t) {
                                    1 == t && a++;
                                }),
                                    (r = d <= a ? 1 : 0),
                                    jQuery.each(o.states, function (e, t) {
                                        l.myState(1, r, t.type, t);
                                    });
                            }
                        });
                    }
                });
            } else {
                var t = $("#" + o.conditions[0].trigger);
                if (o.conditions[0].trigger && null != t) {
                    var i = o.conditions[0].type;
                    if ("isChanged" == i) i = "change";
                    else if ("isPressed" == i) i = "click";
                    else if ("isSubmitted" == i) i = "keypress";
                    else {
                        var r = t.myConditional(o.conditions[0].type, o.conditions[0]);
                        jQuery.each(o.states, function (e, t) {
                            l.myState(0, r, t.type, t);
                        }),
                            (i = "change");
                    }
                    t.on(i, function (e) {
                        if ("keypress" != i || 13 == e.which) {
                            var a = t.myConditional(o.conditions[0].type, o.conditions[0]);
                            jQuery.each(o.states, function (e, t) {
                                l.myState(1, a, t.type, t);
                            });
                        }
                    });
                }
            }
        }),
        ($.fn.conditionalStateLegacy = function (e) {
            var t = $("#" + e.conditions._0isEqual.trigger),
                i = $(this);
            if (e.conditions._0isEqual.trigger && null != t) {
                var a = t.myConditional("isEqual", e.conditions._0isEqual);
                jQuery.each(e.states, function (e, t) {
                    i.myState(0, a, e.substr(2), t);
                }),
                    t.on("change", function () {
                        var a = t.myConditional("isEqual", e.conditions._0isEqual);
                        jQuery.each(e.states, function (e, t) {
                            i.myState(1, a, e.substr(2), t);
                        });
                    });
            }
        }),
        ($.fn.conditionalStates = function (e) {
            var t = $(this),
                a = e.length;
            if (void 0 === a) e.rule ? t.conditionalState(e) : t.conditionalStateLegacy(e);
            else for (var i = 0; i < a; i++) e[i].rule ? t.conditionalState(e[i]) : t.conditionalStateLegacy(e[i]);
        }),
        ($.fn.deepestHeight = function () {
            var e = 0;
            $(this)
                .each(function () {
                    e = Math.max(e, $(this).height());
                })
                .height(e);
        }),
        ($.fn.isStillReady = function () {
            return !$(this).hasClass("busy") && ($(this).addClass("busy"), !0);
        }),
        ($.fn.myAttr = function (e) {
            var t = $(this);
            if (t.is("select")) var a = $.trim(t.find("option:selected").attr(e));
            else if (t.is("fieldset")) a = $.trim(t.find("input:checked").attr(e));
            else a = $.trim(t.attr(e));
            return a;
        }),
        ($.fn.myConditional = function (e, t) {
            var a = this.attr("id"),
                i = 0;
            if (!$(this).length) return 0;
            switch (e) {
                case "callFunction":
                    var n = t.value;
                    window[n] && (i = window[n]());
                    break;
                case "isChanged":
                case "isPressed":
                    return 1;
                case "isFilled":
                case "isEmpty":
                    void 0 !== $(this).myVal() && null !== $(this).myVal() && "" != $(this).myVal() && (i = 1), "isEmpty" == e && (i = myOpposite(i));
                    break;
                case "isEqual":
                case "isDifferent":
                default:
                    var s = t.value.split(",");
                    if ("FIELDSET" == this[0].tagName) {
                        var o = "";
                        1 < $("#" + a + " input:checked").length
                            ? $("#" + a + " input:checked").each(function () {
                                  (o = parseInt(myCheck($(this).val(), s))), (i += o);
                              })
                            : (1 == $("#" + a + " input:checked").length && (o = $("#" + a + " input:checked").val()), (i = myCheck(o, s)));
                    } else i = myCheck(this.val(), s);
                    (i = 0 < i ? 1 : 0), "isDifferent" == e && (i = myOpposite(i));
            }
            return i;
        }),
        ($.fn.myState = function (e, t, a, i) {
            var n = 0,
                s = this.attr("id") + i.selector,
                o = i.value,
                l = "0" == i.revert ? 0 : 1;
            switch (a) {
                case "hasClass":
                case "hasNotClass":
                    "hasNotClass" == a && (l ? (t = myOpposite(t)) : 1 == t && ((t = myOpposite(t)), (l = 1))), 1 == t ? $("#" + s).addClass(o) : l && $("#" + s).removeClass(o);
                    break;
                case "isEnabled":
                case "isDisabled":
                    "isDisabled" == a && (l ? (t = myOpposite(t)) : 1 == t && ((t = myOpposite(t)), (l = 1))), 1 == t ? $("#" + s).prop("disabled", !1) : l && $("#" + s).prop("disabled", !0);
                    break;
                case "isFilled":
                case "isFilledBy":
                case "isEmpty":
                    "isEmpty" == a && (l ? ((t = myOpposite(t)), (n = 1)) : 1 == t && ((t = myOpposite(t)), (l = 1)));
                    var d = $("#" + s).attr("id"),
                        c = "";
                    if (1 == t) {
                        if ("isFilledBy" == a) {
                            var r = o.split("@");
                            o = r[1] ? $("#" + r[0]).myAttr(r[1]) : $("#" + o).myVal();
                        }
                        (c = $("#" + s).is(":input") || $("#" + s).is("fieldset") ? "myVal" : "text"), (n && "" == o) || ($("#" + s)[c](o), $("#_" + d).length && ((c = $("#_" + d).is(":input") ? "myVal" : "text"), $("#_" + d)[c](o)));
                    } else l && ((c = $("#" + s).is(":input") || $("#" + s).is("fieldset") ? "myClear" : "text"), $("#" + s)[c](), $("#_" + d).length && ((c = $("#_" + d).is(":input") ? "val" : "text"), $("#_" + d)[c]("")));
                    break;
                case "isComputed":
                    break;
                case "triggers":
                    d = $("#" + s).attr("id");
                    $("#" + d).trigger(o);
                    break;
                case "isVisible":
                case "isHidden":
                default:
                    "isHidden" == a && (l ? (t = myOpposite(t)) : 1 == t && ((t = myOpposite(t)), (l = 1))),
                        0 == e && (o = ""),
                        1 == t ? ("fade" == o ? $("#" + s).fadeIn() : "slide" == o ? $("#" + s).slideDown() : $("#" + s).show()) : l && ("fade" == o ? $("#" + s).fadeOut() : "slide" == o ? $("#" + s).slideUp() : $("#" + s).hide());
            }
        }),
        ($.fn.myClear = function (e) {
            if (this[0]) {
                var t = this[0];
                if ("FIELDSET" == t.tagName)
                    1 == arguments.length
                        ? $("#" + this.attr("id") + " input:checked").each(function () {
                              e == $(this).val() && $("#" + $(this).attr("id")).prop("checked", !1);
                          })
                        : $("#" + this.attr("id") + " input").prop("checked", !1);
                else if ("SELECT" == t.tagName && this.prop("multiple")) this.find('option[value="' + e + '"]').prop("selected", !1);
                else if ("SELECT" != t.tagName || this.prop("multiple")) this.val("");
                else {
                    for (var a = 0, i = 0; i < t.options.length; i++)
                        if ("" == t.options[i].value) {
                            a = 1;
                            break;
                        }
                    a ? this.val("") : (t.selectedIndex = 0);
                }
            }
        }),
        ($.fn.myVal = function (e) {
            if (1 == arguments.length) var t = 1;
            else (t = 0), (e = "");
            if (!this[0]) return "";
            var a = this[0];
            if ("FIELDSET" != a.tagName && "DIV" != a.tagName) {
                if ("SELECT" == a.tagName && this.prop("multiple")) {
                    if (t) return e ? this.val(e.split(",")) : this.val(e);
                    var i = this.val();
                    return null === i ? [] : i;
                }
                return t ? this.val(e) : this.val();
            }
            var n = "#" + this.attr("id"),
                s = "";
            if (!e)
                return 1 < $(n + " input:checked").length
                    ? ($(n + " input:checked").each(function () {
                          s += "," + $(this).val();
                      }),
                      s.substr(1))
                    : 1 == $(n + " input:checked").length
                    ? $(n + " input:checked").val()
                    : s;
            $(n + " input").val(e.split(","));
        }),
        ($.fn.CckModal = function () {
            var modals = {},
                parents = [];
            $(this).each(function (i, e) {
                var element = $(e),
                    parent = !1;
                if (void 0 !== element.data("cck-modal").parent) var parent = element.data("cck-modal").parent;
                var group = void 0 !== element.data("cck-modal").mode ? element.data("cck-modal").mode : "ajax";
                if ((void 0 !== element.data("cck-modal").group && (group = element.data("cck-modal").group), void 0 !== element.data("cck-modal").parent)) {
                    var parent = element.data("cck-modal").parent;
                    -1 < parents.indexOf(parent) || parents.push(parent), void 0 === eval(parent).groups[group] && (eval(parent).groups[group] = []), eval(parent).groups[group].push(element);
                } else void 0 === modals[group] && (modals[group] = []), modals[group].push(element);
            }),
                $.each(parents, function (i, e) {
                    eval(e).init();
                }),
                $.each(modals, function (e, t) {
                    var a = myModal();
                    (a.groups[e] = t), a.init();
                });
        }),
        $(document).ready(function () {
            $("a[data-cck-modal]").CckModal();
        });
})(jQuery);