<template>
    <div
        class="fade page-sidebar-fixed page-header-fixed show page-container"
        v-if="!pageOptions.pageEmpty"
        :class="{
            'page-sidebar-minified': pageOptions.pageSidebarMinified,
            'page-content-full-height': pageOptions.pageContentFullHeight,
            'page-without-sidebar': pageOptions.pageWithoutSidebar,
            'page-with-wide-sidebar': pageOptions.pageWithWideSidebar,
            'page-with-light-sidebar': pageOptions.pageWithLightSidebar,
            'page-sidebar-toggled': pageOptions.pageMobileSidebarToggled,
            'page-right-sidebar-collapsed':
                pageOptions.pageRightSidebarCollapsed,
            'has-scroll': pageOptions.pageBodyScrollTop,
        }"
    >
        <Header />
        <Sidebar v-if="!pageOptions.pageWithoutSidebar" />
        <div
            id="content"
            class="content"
            :class="{
                'content-full-width': pageOptions.pageContentFullWidth,
                'content-inverse-mode': pageOptions.pageContentInverseMode,
            }"
        >
            <router-view></router-view>
            <vue-ins-progress-bar></vue-ins-progress-bar>
            <a
                href="javascript:;"
                class="btn btn-sm btn-icon btn-circle btn-success btn-scroll-to-top"
                @click="scrollTop"
                v-if="scrollButton"
                ><i class="fa fa-angle-up"></i
            ></a>
        </div>
        <Footer v-if="pageOptions.pageWithFooter" />
    </div>
    <div v-else>
        <router-view></router-view>
        <vue-ins-progress-bar></vue-ins-progress-bar>
    </div>
</template>

<script>
import PageOptions from "./config/PageOptions.vue";

export default {
    name: "app",
    components: {
        Sidebar: (resolve) =>
            import(
                /* webpackChunkName: "components" */ "@/components/sidebar/Sidebar.vue"
            ).then((Sidebar) => {
                resolve(Sidebar.default);
            }),
        Header: (resolve) =>
            import(
                /* webpackChunkName: "components" */ "@/components/header/Header.vue"
            ).then((Header) => {
                resolve(Header.default);
            }),
        Footer: (resolve) =>
            import(
                /* webpackChunkName: "components" */ "@/components/footer/Footer.vue"
            ).then((Footer) => {
                resolve(Footer.default);
            }),
    },
    data() {
        return {
            pageOptions: PageOptions,
            scrollButton: false,
        };
    },
    methods: {
        handleScroll: function () {
            PageOptions.pageBodyScrollTop = window.scrollY;
            if (window.scrollY > 10) {
                this.scrollButton = true;
            } else {
                this.scrollButton = false;
            }
        },
        scrollTop() {
            window.scrollTo(0, 0);
            this.scrollButton = false;
        },
    },
    mounted() {
        this.$insProgress.finish();
    },
    created() {
        PageOptions.pageBodyScrollTop = window.scrollY;

        window.addEventListener("scroll", this.handleScroll);

        this.$insProgress.start();

        this.$router.beforeEach((to, from, next) => {
            this.$insProgress.start();
            next();
        });
        this.$router.afterEach(() => {
            this.$insProgress.finish();
        });
    },
};
</script>
