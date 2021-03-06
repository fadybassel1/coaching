/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require("bootstrap-css-only/css/bootstrap.min.css");
require("mdbvue/lib/css/mdb.min.css");
require("@fortawesome/fontawesome-free/css/all.min.css");
require("./bootstrap");

window.Vue = require("vue");
import axios from "axios";
import VueAxios from "vue-axios";

Vue.use(VueAxios, axios);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "post-component",
    require("./components/PostComponent.vue").default
);
Vue.component(
    "home-group",
    require("./components/HomeGroupComponent.vue").default
);
Vue.component("home-nav", require("./components/HomeNavComponent.vue").default);
Vue.component(
    "groups-view-home",
    require("./components/GroupsViewHome.vue").default
);
Vue.component("comments", require("./components/CommentComponent.vue").default);
Vue.component("likes", require("./components/LikeComponent.vue").default);
Vue.component( "create-post",require("./components/CreatePostComponent.vue").default);


Vue.component("InfiniteLoading", require("vue-infinite-loading"));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});
