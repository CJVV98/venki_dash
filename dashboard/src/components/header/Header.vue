<template>
    <div>
        <!-- begin #header -->
        <div id="header" class="header navbar-default">
            <!-- begin navbar-header -->
            <div class="navbar-header">
                <router-link to="/home" class="navbar-brand">
                    <b>Venki</b> Dashboard
                </router-link>
                <button
                    type="button"
                    class="navbar-toggle"
                    v-on:click="toggleMobileSidebar"
                    v-if="!pageOptions.pageWithoutSidebar"
                >
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- end navbar-header -->

            <!-- begin header-nav -->
            <ul class="navbar-nav navbar-right">
                <b-nav-item-dropdown
                    menu-class="dropdown-menu-right"
                    class="dropdown navbar-user"
                    no-caret
                >
                    <!--<template slot="button-content" v-if="$store.state.auth">-->
                    <template slot="button-content" v-if="isLoggedIn">
                        <span class="profile-usertitle-name"> {{ $store.state.user.email }} </span>
                        <div class="image image-icon bg-black text-grey-darker">
                            <i class="fa fa-user"></i>
                        </div>
                        <b class="caret"></b>
                    </template>
                    <b-dropdown-item href="javascript:;"
                        >Edit Profile</b-dropdown-item
                    >
                    <b-dropdown-item href="javascript:;">
                        <span class="badge badge-danger pull-right">0</span>
                        Inbox
                    </b-dropdown-item>
                    <b-dropdown-item href="javascript:;"
                        >Calendar</b-dropdown-item
                    >
                    <b-dropdown-item href="javascript:;"
                        >Setting</b-dropdown-item
                    >
                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-item
                                     @click="logout"
                        >Log Out</b-dropdown-item
                    >
                </b-nav-item-dropdown>
            </ul>
            <!-- end header navigation right -->
        </div>
        <!-- end #header -->
    </div>
</template>

<script>
import PageOptions from "@/config/PageOptions.vue";

export default {
    name: "Header",
    data() {
        return {
            pageOptions: PageOptions,
        };
    },
    computed: {
      isLoggedIn: function (){
          return this.$store.getters.isLoggedIn
      }
    },
    methods: {
        toggleMobileSidebar() {
            this.pageOptions.pageMobileSidebarToggled = !this.pageOptions
                .pageMobileSidebarToggled;
        },
        toggleMobileRightSidebar() {
            this.pageOptions.pageMobileRightSidebarToggled = !this.pageOptions
                .pageMobileRightSidebarToggled;
        },
        toggleMobileTopMenu() {
            this.pageOptions.pageMobileTopMenu = !this.pageOptions
                .pageMobileTopMenu;
        },
        toggleMobileMegaMenu() {
            this.pageOptions.pageMobileMegaMenu = !this.pageOptions
                .pageMobileMegaMenu;
        },
        toggleRightSidebar() {
            this.pageOptions.pageRightSidebarToggled = !this.pageOptions
                .pageRightSidebarToggled;
        },
        toggleRightSidebarCollapsed() {
            this.pageOptions.pageRightSidebarCollapsed = !this.pageOptions
                .pageRightSidebarCollapsed;
        },
        checkForm: function (e) {
            e.preventDefault();
            this.$router.push({ path: "/extra/search" });
        },
        logout: function () {
            // this.$index.dispatch('logout');
            this.$store.dispatch('logout').then(() => {
                this.$router.push('/');
            })
        },
    },
};
</script>
