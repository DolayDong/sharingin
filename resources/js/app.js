/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

Vue.use(VueRouter);
import router from './jalannya.js';

Vue.use(VueToast);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/LoginPage/LoginComponent.vue').default);
Vue.component('home-component', require('./components/HomePage/HomeComponent.vue').default);
Vue.component('header-component', require('./components/HomePage/HeaderComponent.vue').default);
Vue.component('profile-card', require('./components/HomePage/ProfileCard.vue').default);
Vue.component('postingan-component', require('./components/HomePage/PostinganComponent.vue').default);
Vue.component('main-home-component', require('./components/HomePage/MainHomeComponent.vue').default);
Vue.component('users-sugestion', require('./components/HomePage/UsersSugestion.vue').default);
Vue.component('modal-component', require('./components/HelperComponent/ModalComponent.vue').default);
Vue.component('button-add-photo', require('./components/HelperComponent/ButtonAddPhoto.vue').default);
Vue.component('form-add-status', require('./components/HelperComponent/FormAddStatus.vue').default);
Vue.component('form-add-video', require('./components/HelperComponent/FormAddVideo.vue').default);
Vue.component('form-add-foto', require('./components/HelperComponent/FormAddFoto.vue').default);
Vue.component('emoji-component', require('./components/HelperComponent/EmojiComponent.vue').default);
Vue.component('error-component', require('./components/errors/MainComponentError.vue').default);
Vue.component('send-message-postingan-component', require('./components/HelperComponent/SendMessagePostinganComponent.vue').default);
Vue.component('button-option-postingan-component', require('./components/HelperComponent/ButtonOptionPostinganComponent.vue').default);
Vue.component('button-like-component', require('./components/HelperComponent/ButtonLikeComponent.vue').default);
Vue.component('button-comment-component', require('./components/HelperComponent/ButtonCommentComponent.vue').default);
Vue.component('button-share-component', require('./components/HelperComponent/ButtonShareComponent.vue').default);
Vue.component('button-add-teman-kecil', require('./components/HelperComponent/ButtonAddTemanKecil.vue').default);
Vue.component('button-tema-component', require('./components/HelperComponent/ButtonTemaComponent.vue').default);
Vue.component('button-add-teman-sedang', require('./components/HelperComponent/ButtonAddTemanSedang.vue').default);
Vue.component('form-komentar', require('./components/HelperComponent/FormComentar.vue').default);
Vue.component('contact-component', require('./components/PesanPage/ContactComponent.vue').default);
Vue.component('pesan-component', require('./components/PesanPage/PesanComponent.vue').default);
Vue.component('video-call-component', require('./components/HelperComponent/VideoCallComponent.vue').default);




/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: new VueRouter(router)
});
