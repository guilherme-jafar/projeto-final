
require('./bootstrap');
Window.Vue=require('vue');

Vue.component('registos',require('./components/registos.vue').default);
Vue.component('login',require('./components/login.vue').default);
Vue.component('dashboard',require('./components/Professor/dashboard.vue').default);
Vue.component('alunodashboard',require('./components/aluno/dashboadAluno.vue').default);


const app=new Vue({
    el:'#app',

});
