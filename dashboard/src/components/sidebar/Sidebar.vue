<template>
    <div>
        <!-- begin #sidebar -->
        <div
            id="sidebar"
            class="sidebar"
            :class="{
                'sidebar-transparent': pageOptions.pageSidebarTransparent,
            }"
            @mouseover="inSidebarMinify"
            @mouseleave="outSidebarMinify"
        >
            <!-- begin sidebar scrollbar -->
            <vue-custom-scrollbar class="height-full">
                <!-- begin sidebar nav -->
                <sidebar-nav
                    ref="sidebarNav"
                    :scrollTop="scrollTop"
                    @showFloatSubmenu="handleShowFloatSubmenu"
                    @hideFloatSubmenu="handleHideFloatSubmenu"
                ></sidebar-nav>
                <!-- end sidebar nav -->
            </vue-custom-scrollbar>
            <!-- end sidebar scrollbar -->
        </div>
        <div class="sidebar-bg"></div>
        <!-- end #sidebar -->
        <div class="mobile-click" @click="dismissSidebar"></div>

        <div
            class="float-sub-menu-container"
            @mouseover="clearHideFloatSubmenu"
            @mouseleave="handleHideFloatSubmenu"
            v-if="this.pageOptions.pageSidebarMinified"
            :class="{
                'd-none': !this.floatSubmenu,
            }"
            :style="{
                top: this.floatSubmenuTop,
                left: this.floatSubmenuLeft,
                bottom: this.floatSubmenuBottom,
                right: this.floatSubmenuRight,
            }"
        >
            <div
                class="float-sub-menu-arrow"
                :style="{
                    top: this.floatSubmenuArrowTop,
                    bottom: this.floatSubmenuArrowBottom,
                }"
            ></div>
            <div
                class="float-sub-menu-line"
                :style="{
                    top: this.floatSubmenuLineTop,
                    bottom: this.floatSubmenuLineBottom,
                }"
            ></div>
            <ul class="float-sub-menu">
                <template v-for="menu in this.floatSubmenuMenu">
                    <sidebar-nav-list
                        ref="sidebarNavList"
                        :menu="menu"
                        :key="menu.path"
                        :status="menu.status"
                        @calcFloatSubmenu="handleCalcFloatSubmenu"
                    ></sidebar-nav-list>
                </template>
            </ul>
        </div>
    </div>
</template>

<script>
import SidebarNav from "./SidebarNav.vue";
import SidebarNavList from "./SidebarNavList.vue";
import PageOptions from "@/config/PageOptions.vue";

export default {
    name: "Sidebar",
    components: {
        SidebarNav,
        SidebarNavList,
    },
    data() {
        return {
            scrollTop: "",
            pageOptions: PageOptions,
            floatSubmenu: false,
            floatSubmenuMenu: "",
            floatSubmenuTop: "",
            floatSubmenuBottom: "",
            floatSubmenuLeft: "",
            floatSubmenuRight: "",
            floatSubmenuArrowTop: "",
            floatSubmenuArrowBottom: "",
            floatSubmenuLineTop: "",
            floatSubmenuLineBottom: "",
            clearSubmenu: "",
            subMenuOffset: "",
        };
    },
    directives: {
        scroll: {
            inserted: function (el, binding) {
                let f = function (evt) {
                    if (binding.value(evt, el)) {
                        el.removeEventListener("scroll", f);
                    }
                };
                el.addEventListener("scroll", f);

                if (typeof Storage !== "undefined") {
                    if (localStorage.sidebarScroll) {
                        el.scrollTop = localStorage.sidebarScroll;
                    }
                }
            },
        },
    },
    methods: {
        handleCalcFloatSubmenu: function () {
            setTimeout(() => {
                let targetTop = this.subMenuOffset.top;
                let windowHeight = window.innerHeight;
                let targetHeight = document.querySelector(
                    ".float-sub-menu-container"
                ).offsetHeight;

                if (windowHeight - targetTop > targetHeight) {
                    this.floatSubmenuTop = this.subMenuOffset.top + "px";
                    this.floatSubmenuBottom = "auto";
                    this.floatSubmenuArrowTop = "20px";
                    this.floatSubmenuArrowBottom = "auto";
                    this.floatSubmenuLineTop = "20px";
                    this.floatSubmenuLineBottom = "auto";
                } else {
                    this.floatSubmenuTop = "auto";
                    this.floatSubmenuBottom = "0";

                    let arrowBottom = windowHeight - targetTop - 21;
                    this.floatSubmenuArrowTop = "auto";
                    this.floatSubmenuArrowBottom = arrowBottom + "px";
                    this.floatSubmenuLineTop = "20px";
                    this.floatSubmenuLineBottom = arrowBottom + "px";
                }
            }, 0);
        },
        handleShowFloatSubmenu: function (data, offset) {
            this.floatSubmenuMenu = data;
            this.floatSubmenu = true;
            this.subMenuOffset = offset;

            let targetTop = offset.top;
            let windowHeight = window.innerHeight;

            setTimeout(() => {
                let targetHeight = document.querySelector(
                    ".float-sub-menu-container"
                ).offsetHeight;

                if (windowHeight - targetTop > targetHeight) {
                    this.floatSubmenuTop = offset.top + "px";
                    this.floatSubmenuBottom = "auto";
                    this.floatSubmenuArrowTop = "20px";
                    this.floatSubmenuArrowBottom = "auto";
                    this.floatSubmenuLineTop = "20px";
                    this.floatSubmenuLineBottom = "auto";
                } else {
                    this.floatSubmenuTop = "auto";
                    this.floatSubmenuBottom = "0";

                    let arrowBottom = windowHeight - targetTop - 21;
                    this.floatSubmenuArrowTop = "auto";
                    this.floatSubmenuArrowBottom = arrowBottom + "px";
                    this.floatSubmenuLineTop = "20px";
                    this.floatSubmenuLineBottom = arrowBottom + "px";
                }
            }, 0);

            this.floatSubmenuRight = "auto";
            this.floatSubmenuLeft =
                document.getElementById("sidebar").offsetLeft +
                offset.width +
                "px";

            clearTimeout(this.clearSubmenu);
        },
        handleHideFloatSubmenu: function () {
            this.clearSubmenu = setTimeout(() => {
                this.floatSubmenu = false;
            }, 250);
        },
        clearHideFloatSubmenu: function () {
            clearTimeout(this.clearSubmenu);
        },
        handleScroll: function (evt) {
            this.scrollTop = evt.target.scrollTop;
            if (typeof Storage !== "undefined") {
                localStorage.setItem("sidebarScroll", this.scrollTop);
            }
        },
        dismissSidebar: function () {
            this.pageOptions.pageMobileSidebarToggled = false;
            this.pageOptions.pageMobileRightSidebarToggled = false;
        },
        inSidebarMinify: function () {
            this.pageOptions.pageSidebarMinified = false;
        },
        outSidebarMinify: function () {
            this.pageOptions.pageSidebarMinified = true;
        },
    },
};
</script>
