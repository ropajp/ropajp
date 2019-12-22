/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import './bootstrap'

require('./bootstrap');

window.Vue = require('vue');
console.log('OK');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue'
import router from './router'
import store from './store'
import App from './components/pages/App/index.vue'
import OwnerApp from './components/pages/OwnerApp/index.vue'
Vue.component('pagination', require('laravel-vue-pagination'));
//アプリ起動前のVueインスタンス生成前にAuth.jsのcurrentUserを呼び出す。
const createApp =  (async() => {

if(document.getElementById('app')) {

  await store.dispatch('auth/currentUser')

  new Vue({
      el: '#app',
      router,
      store,
      components: { App },
      template: '<App />'
  })

} else if (document.getElementById('ownerApp')) {

    await store.dispatch('auth/currentOwner')

new Vue({
    el:  '#ownerApp',
    router,
    store,
    components: { OwnerApp },
    template: '<OwnerApp />'
})

}

})();
