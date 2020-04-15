import catalog from "./components/catalog";
import small_basket from "./components/small.basket";
import checkout from "./components/checkout";
import history from "./components/history";

import VueRouter from "vue-router";
import {BootstrapVue, IconsPlugin} from "bootstrap-vue";
import Notifications from "vue-notification";
import Vuelidate from "vuelidate";


require("./bootstrap");
window.Vue = require("vue");
window.Vue.use(VueRouter);

// Install BootstrapVue
Vue.use(BootstrapVue);
Vue.use(Notifications);
Vue.use(IconsPlugin);
Vue.use(require('vue-moment'));
// Form Validation
Vue.use(Vuelidate);

const routes = [
    {
        path: "/",
        components: {
            catalog: catalog,
        },
    },
    {
        path: "/checkout",
        components: {
            checkout: checkout,
        },
    },
    {
        path: "/history",
        components: {
            history: history,
        },
    },
    {
        path: "*",
    },
];
routes.forEach(function (v) {
    if (typeof v.components === "object") {
        Object.assign(v.components, {small_basket: small_basket});
    } else {
        v.components = {small_basket: small_basket};
    }
});

const router = new VueRouter({
    mode: "history",
    routes,
});

Vue.directive("out", {
    bind: function (el, binding, vNode) {
        const handler = (e) => {
            if (!el.contains(e.target) && el !== e.target) {
                vNode.context[binding.expression] = false;
            }
        };
        el.out = handler;
        document.addEventListener("click", handler);
    },
    // eslint-disable-next-line no-unused-vars
    unbind: function (el, binding) {
        document.removeEventListener("click", el.out);
        el.out = null;
    },
});

const app = new Vue({router}).$mount("#app");
