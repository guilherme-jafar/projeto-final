
require('./bootstrap');

Window.Vue=require('vue');
//Vue.config.devtools = true //TODO: quando for para meter no ar tem que se comentar essa linha
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

//Forum
Vue.component('forum',require('./components/forum/forum').default)
Vue.component('mensagem',require('./components/forum/mensagem').default)
Vue.component('forumShow',require('./components/forum/forumShow').default)
Vue.component('respostas',require('./components/forum/respostas').default)




const app=new Vue({
    el:'#app',

});
