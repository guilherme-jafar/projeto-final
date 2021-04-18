
require('./bootstrap');
Window.Vue=require('vue');

Vue.component('registos',require('./components/registos.vue').default);
Vue.component('login',require('./components/login.vue').default);
Vue.component('editarPerfil',require('./components/editarPerfil').default);

//prof
Vue.component('dashboard',require('./components/Professor/dashboard.vue').default);
Vue.component('disciplinaProf',require('./components/Professor/disciplinaProf').default);
Vue.component('disciplinaAlunos',require('./components/Professor/listaAlunos').default);
Vue.component('perguntaTopico',require('./components/Professor/pergunta').default);
Vue.component('quizzProf',require('./components/Professor/quizz').default);

//aluno
Vue.component('alunodashboard',require('./components/aluno/dashboadAluno.vue').default);



const app=new Vue({
    el:'#app',

});
