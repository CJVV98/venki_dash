import Vue from "vue";
import VueX from "vuex";
import routes from "./config/PageRoutes";
import Axios from "axios";
import moment from "moment";

// plugins
import VueRouter from "vue-router";
import VueBootstrap from "bootstrap-vue";
import VueInsProgressBar from "vue-ins-progress-bar";
import VueEventCalendar from "vue-event-calendar";
import VueSparkline from "vue-sparklines";
import * as VueGoogleMaps from "vue2-google-maps";
import VueSweetalert2 from "vue-sweetalert2";
import VueNotification from "vue-notification";
import VuePanel from "./plugins/panel/";
import VueDateTimePicker from "vue-bootstrap-datetimepicker";
import VueSelect from "vue-select";
import VueDatepicker from "vuejs-datepicker/dist/vuejs-datepicker.esm.js";
import VueMaskedInput from "vue-maskedinput";
import VueInputTag from "vue-input-tag";
import VueSlider from "vue-slider-component";
import VueGoodTable from "vue-good-table";
import VueFullCalendar from "vue-full-calendar";
import VueCountdown from "@chenfengyuan/vue-countdown";
import VueCustomScrollbar from "vue-custom-scrollbar";
import Loading from "vue-loading-overlay";

// plugins css
import "bootstrap-vue/dist/bootstrap-vue.css";
import "vue-event-calendar/dist/style.css";
import "vue-hljs/dist/vue-hljs.min.css";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";
import "simple-line-icons/css/simple-line-icons.css";
import "flag-icon-css/css/flag-icon.min.css";
import "ionicons/dist/css/ionicons.min.css";
import "vue-good-table/dist/vue-good-table.css";
import "fullcalendar/dist/fullcalendar.css";
import "vue-select/dist/vue-select.css";
import "vue-slider-component/theme/antd.css";
import "vue-loading-overlay/dist/vue-loading.css";

// color admin css
import "./assets/css/material/app.min.css";
import "./scss/vue.scss";
import "bootstrap-social/bootstrap-social.css";

import App from "./App.vue";
import store from "./store/index.js";
import axios from "axios";
// import axios from "axios";

Vue.config.productionTip = false;
Vue.config.devtools = true;

Vue.use(VueX);
Vue.use(VueRouter);
Vue.use(VueBootstrap);
Vue.use(VueEventCalendar, { locale: "en" });
Vue.use(VueSparkline);
Vue.use(VueSweetalert2);
Vue.use(VueNotification);
Vue.use(VuePanel);
Vue.use(VueDateTimePicker);
Vue.use(VueGoodTable);
Vue.use(VueFullCalendar);
Vue.use(VueGoogleMaps, {
    load: {
        key: "",
        libraries: "places",
    },
});
Vue.use(VueInsProgressBar, {
    position: "fixed",
    show: true,
    height: "3px",
});
Vue.use(Loading);
Vue.component("v-select", VueSelect);
Vue.component("datepicker", VueDatepicker);
Vue.component("masked-input", VueMaskedInput);
Vue.component("input-tag", VueInputTag);
Vue.component("vue-slider", VueSlider);
Vue.component("vue-custom-scrollbar", VueCustomScrollbar);
Vue.component(VueCountdown.name, VueCountdown);

Vue.prototype.$http = Axios;
const token = localStorage.getItem('token')
if (token) {
    store.dispatch('getUser');
    // this.store.dispatch('getUser');
    Vue.prototype.$http.defaults.headers.common['Authorization'] = token
}

// store.dispatch('getUser');

window.moment = moment;
moment.locale("es-us");

Axios.defaults.headers.common["Content-Type"] = "application/json";
Axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
Axios.defaults.withCredentials = true
axios.defaults.baseURL = 'http://127.0.0.1:8000';

String.prototype.capitalize = function (lower) {
    return (lower ? this.toLowerCase() : this).replace(/(?:^|\s)\S/g, function (
        a
    ) {
        return a.toUpperCase();
    });
};

const router = new VueRouter({
    routes,
    mode: "history",
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next()
            return
        }
        next('/')
    } else {
        next()
    }
})

// if expire token
if(token) {
    axios.interceptors.response.use(undefined, function (error) {
        if (error) {
            const originalRequest = error.config;
            if (error.response.status === 401 && !originalRequest.retry) {
                originalRequest.retry = true;
                store.dispatch('logout')
                return router.push('/')
            }
        }
    })
}

new Vue({
    render: (h) => h(App),
    store,
    router,
}).$mount("#app");
