
require('./bootstrap');

Window.Vue=require('vue');

Pusher.log = function (message) { window.console.log(message); }
Vue.component('pagination-2', require('laravel-vue-pagination'));

Vue.component('registos',require('./components/registos.vue').default);
Vue.component('login',require('./components/login.vue').default);
Vue.component('editarPerfil',require('./components/editarPerfil').default);

//prof
Vue.component('dashboard',require('./components/Professor/dashboard.vue').default);
Vue.component('disciplinaProf',require('./components/Professor/disciplinaProf').default);
Vue.component('disciplinaAlunos',require('./components/Professor/listaAlunos').default);
Vue.component('perguntaTopico',require('./components/Professor/pergunta').default);
Vue.component('quizzProf',require('./components/Professor/quizz').default);
Vue.component('editarDisciplina',require('./components/Professor/editarDisciplina').default);
Vue.component('perguntaEditar',require('./components/Professor/perguntaEditar').default);

//aluno
Vue.component('alunodashboard',require('./components/aluno/dashboadAluno.vue').default);
Vue.component('alunosQuizz',require('./components/aluno/quizzAluno').default);
Vue.component('perguntaQuizz', require('./components/quizz/perguntaQuizz').default)

//quizz
Vue.component('waitRoom',require('./components/quizz/waitRoom').default)
Vue.component('waitRoomAluno',require('./components/quizz/WaitRoomStudent').default)






const app=new Vue({
    el:'#app',

});
