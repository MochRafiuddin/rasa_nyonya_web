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
            if (
                curr == "referensi/agama" ||
                curr == "agama/create" ||
                curr == "agama/show"
            ) {
                current = "referensi/agama";
            } else if (
                curr == "referensi/bank" ||
                curr == "bank/create" ||
                curr == "bank/show"
            ) {
                current = "referensi/bank";
            } else if (
                curr == "referensi/departement" ||
                curr == "departement/create" ||
                curr == "departement/show"
            ) {
                current = "referensi/departement";
            } else if (
                curr == "referensi/jabatan" ||
                curr == "jabatan/create" ||
                curr == "jabatan/show"
            ) {
                current = "referensi/jabatan";
            } else if (
                curr == "referensi/status-pegawai" ||
                curr == "status_karyawan/create" ||
                curr == "status_karyawan/show"
            ) {
                current = "referensi/status-pegawai";
            } else if (
                curr == "referensi/pendidikan" ||
                curr == "pendidikan/create" ||
                curr == "pendidikan/show"
            ) {
                current = "referensi/pendidikan";
            } else if (
                curr == "master/officer-grup" ||
                curr == "grup_karyawan/create" ||
                curr == "grup_karyawan/show"
            ) {
                current = "master/officer-grup";
            } else if (
                curr == "master/karyawan" ||
                curr == "karyawan/create" ||
                curr == "karyawan/show"
            ) {
                current = "master/karyawan";
            } else if (
                curr == "master/kawin-status" ||
                curr == "status_kawin/create" ||
                curr == "status_kawin/show"
            ) {
                current = "master/kawin-status";
            } else if (
                curr == "konfigurasi/tarif-pph" ||
                curr == "tarif_pph/create" ||
                curr == "tarif_pph/show"
            ) {
                current = "konfigurasi/tarif-pph";
            } else if (
                curr == "konfigurasi/tarif-lembur" ||
                curr == "tarif_lembur/create" ||
                curr == "tarif_lembur/show"
            ) {
                current = "konfigurasi/tarif-lembur";
            } else if (
                curr == "master/shift" ||
                curr == "shift/create" ||
                curr == "shift/show"
            ) {
                current = "master/shift";
            } else if (curr == "absensi/atur-shift-grup-karyawan") {
                current = "absensi/atur-shift-grup-karyawan";
            } else if (curr == "absensi/atur-shift-karyawan") {
                current = "absensi/atur-shift-karyawan";
            } else if (
                curr == "absensi/ref-tipe-absensi" ||
                curr == "ref-tipe-absensi/create" ||
                curr == "ref-tipe-absensi/show"
            ) {
                current = "absensi/ref-tipe-absensi";
            } else if (
                curr == "penggajian/periode" ||
                curr == "periode/create"
            ) {
                current = "penggajian/periode";
            } else if (
                curr == "penggajian/salary" ||
                curr == "gaji/create" ||
                curr == "gaji/show"
            ) {
                current = "penggajian/salary";
            } else if (
                curr == "penggajian/gj-pegawai" ||
                curr == "gaji_karyawan/set-gaji"
            ) {
                current = "penggajian/gj-pegawai";
            } else if (
                curr == "penggajian/g-period" ||
                curr == "gaji_karyawan/set-gaji-periode"
            ) {
                current = "penggajian/g-period";
            } else if (
                curr == "absensi/fingerprint" ||
                curr == "absen/fingerprint" ||
                curr == "absen/import"
            ) {
                current = "absensi/fingerprint";
            } else if (
                curr == "riwayat/riwayat-absensi" ||
                curr == "absensi-karyawan/view-filter" ||
                curr == "marked"
            ) {
                current = "riwayat/riwayat-absensi";
            } else if (curr == "riwayat/total-absensi") {
                current = "riwayat/total-absensi";
            } else if (
                curr == "absensi/izin-cuti" ||
                curr == "izin-cuti/create" ||
                curr == "izin-cuti/show"
            ) {
                current = "absensi/izin-cuti";
            } else if (
                curr == "absensi/over-time" ||
                curr == "lembur/edit" ||
                curr == "lembur/detail"
            ) {
                current = "absensi/over-time";
            } else if (curr == "riwayat/riwayat-penggajian") {
                current = "riwayat/riwayat-penggajian";
            } else if (curr == "perbaikan-gaji") {
                current = "perbaikan-gaji";
            } else if (curr == "penggajian/approval-gaji") {
                current = "penggajian/approval-gaji";
            } else if (
                curr == "penggajian/asuransi" ||
                curr == "gaji_karyawan/create-asuransi" ||
                curr == "gaji_karyawan/edit-asuransi"
            ) {
                current = "penggajian/asuransi";
            } else if (curr == "selfi/pengguna-aktif") {
                current = "selfi/pengguna-aktif";
            } else if (curr == "selfi/data-selfi") {
                current = "selfi/data-selfi";
            } else if (curr == "selfi/submit") {
                current = "selfi/submit";
            } else if (curr == "sistem") {
                current = "sistem";
            } else if (
                curr == "setting/user" ||
                curr == "user/create" ||
                curr == "user/show"
            ) {
                current = "setting/user";
            } else if (
                curr == "setting/role" ||
                curr == "role/create" ||
                curr == "role/set-menu"
            ) {
                current = "setting/role";
            } else if (curr == "dashboard") {
                current = "dashboard";
            } else if (curr == "dashboard/karyawan") {
                current = "dashboard/karyawan";
            } else if (
                curr == "pph_karyawan" ||
                curr == "pph_karyawan/create" ||
                curr == "pph_karyawan/show"
            ) {
                current = "pph_karyawan";
            } else if (
                curr == "master/lokasi" ||
                curr == "lokasi/create" ||
                curr == "lokasi/show"
            ) {
                current = "master/lokasi";
            } else if (
                curr == "lokasi-checklog" ||
                curr == "lokasi-checklog/create" ||
                curr == "lokasi-checklog/show"
            ) {
                current = "lokasi-checklog";
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
            .slice(1)[0]
            .replace(/^\/|\/$/g, "");
        console.log(location.pathname.split("/"));
        if (cur1 == "marked") {
            var curr = "marked";
        } else if (cur1 == "perbaikan-gaji") {
            var curr = "perbaikan-gaji";
        } else if (cur1 == "lokasi-checklog") {
            var curr = "lokasi-checklog";
        } else if (cur1 == "sistem") {
            var curr = "sistem";
        } else if (
            cur1 == "dashboard" &&
            location.pathname.split("/").length == 2
        ) {
            var curr = "dashboard";
        } else if (cur1 == "" && location.pathname.split("/").length == 2) {
            var curr = "";
        } else {
            var cur2 = location.pathname
                .split("/")
                .slice(2)[0]
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
