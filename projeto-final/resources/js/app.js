
require('./bootstrap');
Window.Vue=require('vue');
Vue.component('registos',require('./components/registos.vue').default);

const app=new Vue({
    el:'#app',

});
