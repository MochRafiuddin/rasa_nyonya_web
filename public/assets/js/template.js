(function ($) {
    "use strict";
    $(function () {
        var body = $("body");
        var contentWrapper = $(".content-wrapper");
        var scroller = $(".container-scroller");
        var footer = $(".footer");
        var sidebar = $(".sidebar");
        var current = "";

        //Add active class to nav-link based on url dynamically
        //Active class can be hard coded directly in html file also as required

        function addActiveClass(element) {
            // var current1 = location.pathname;
            if (curr == "dashboard") {
                current = "dashboard";
            } else if (
                curr == "master/area" ||
                curr == "area/create" ||
                curr == "area/show"
            ) {
                current = "master/area";
            } else if (
                curr == "master/wilayah" ||
                curr == "wilayah/create" ||
                curr == "wilayah/show"
            ) {
                current = "master/wilayah";
            } else if (
                curr == "master/courier" ||
                curr == "courier/create" ||
                curr == "courier/show"
            ) {
                current = "master/courier";
            } else if (
                curr == "master/admin" ||
                curr == "admin/create" ||
                curr == "admin/show"
            ) {
                current = "master/admin";
            } else if (
                curr == "master/customer" ||
                curr == "customer/create" ||
                curr == "customer/show"
            ) {
                current = "master/customer";
            } else if (
                curr == "master/user" ||
                curr == "user/create" ||
                curr == "user/show"
            ) {
                current = "master/user";
            } else if (
                curr == "order" ||
                curr == "order/create" ||
                curr == "order/show" ||
                curr == "order/detail" ||
                curr == "order/confrim"
            ) {
                current = "order";
            } else if (curr == "report/courier-performance") {
                current = "report/courier-performance";
            } else if (curr == "report/courier-fee") {
                current = "report/courier-fee";
            }

            if (current === "") {
                //for root url
                if (element.attr("href").indexOf("index.html") !== -1) {
                    element.parents(".nav-item").last().addClass("active");
                    if (element.parents(".sub-menu").length) {
                        element.closest(".collapse").addClass("show");
                        element.addClass("active");
                    }
                }
            } else {
                //for other url
                if (element.attr("href").indexOf(current) !== -1) {
                    element.parents(".nav-item").last().addClass("active");
                    if (element.parents(".sub-menu").length) {
                        element.closest(".collapse").addClass("show");
                        element.addClass("active");
                    }
                    if (element.parents(".submenu-item").length) {
                        element.addClass("active");
                    }
                }
            }
        }

        var cur1 = location.pathname
            .split("/")
            .slice(3)[0]
            .replace(/^\/|\/$/g, "");
        console.log(cur1);
        if (cur1 == "dashboard") {
            var curr = "dashboard";
        } else if (cur1 == "order") {
            var curr = "order";
        } else {
            var cur2 = location.pathname
                .split("/")
                .slice(4)[0]
                .replace(/^\/|\/$/g, "");
            var curr = cur1 + "/" + cur2;
        }
        $(".nav li a", sidebar).each(function () {
            var $this = $(this);
            addActiveClass($this);
        });

        $(".horizontal-menu .nav li a").each(function () {
            var $this = $(this);
            addActiveClass($this);
        });

        //Close other submenu in sidebar on opening any

        sidebar.on("show.bs.collapse", ".collapse", function () {
            sidebar.find(".collapse.show").collapse("hide");
        });

        //Change sidebar and content-wrapper height
        applyStyles();

        function applyStyles() {
            //Applying perfect scrollbar
            if (!body.hasClass("rtl")) {
                if (
                    $(".settings-panel .tab-content .tab-pane.scroll-wrapper")
                        .length
                ) {
                    const settingsPanelScroll = new PerfectScrollbar(
                        ".settings-panel .tab-content .tab-pane.scroll-wrapper"
                    );
                }
                if ($(".chats").length) {
                    const chatsScroll = new PerfectScrollbar(".chats");
                }
                if (body.hasClass("sidebar-fixed")) {
                    var fixedSidebarScroll = new PerfectScrollbar(
                        "#sidebar .nav"
                    );
                }
            }
        }

        $('[data-toggle="minimize"]').on("click", function () {
            if (
                body.hasClass("sidebar-toggle-display") ||
                body.hasClass("sidebar-absolute")
            ) {
                body.toggleClass("sidebar-hidden");
            } else {
                body.toggleClass("sidebar-icon-only");
            }
        });

        //checkbox and radios
        $(".form-check label,.form-radio label").append(
            '<i class="input-helper"></i>'
        );

        //Horizontal menu in mobile
        $('[data-toggle="horizontal-menu-toggle"]').on("click", function () {
            $(".horizontal-menu .bottom-navbar").toggleClass("header-toggled");
        });
        // Horizontal menu navigation in mobile menu on click
        var navItemClicked = $(".horizontal-menu .page-navigation >.nav-item");
        navItemClicked.on("click", function (event) {
            if (window.matchMedia("(max-width: 991px)").matches) {
                if (!$(this).hasClass("show-submenu")) {
                    navItemClicked.removeClass("show-submenu");
                }
                $(this).toggleClass("show-submenu");
            }
        });

        /* Fix the bottom navbar to top on scrolling */
        var bottomNavBar = $(".bottom-navbar");
        if (bottomNavBar.length) {
            var navbarStickyPoint = bottomNavBar.offset().top;
            $(window).scroll(function () {
                if (window.matchMedia("(min-width: 992px)").matches) {
                    var header = $(".horizontal-menu");
                    if ($(window).scrollTop() > navbarStickyPoint) {
                        $(header).addClass("fixed-on-scroll");
                    } else {
                        $(header).removeClass("fixed-on-scroll");
                    }
                }
            });
        }
    });
})(jQuery);
