<template>
    <div class="forumShow">


        <div class="mt-5 text-end d-flex ms-5" v-if='voltar'>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" @click ='mudar'><button class="breadcrumb-button">Fórum</button></li>
                    <li class="breadcrumb-item active" aria-current="page">Mensagem</li>
                </ol>
            </nav>
        </div>

        <forum tipo_prop="tipoUtilizador" :is='componentInicial' />


<!--        <div class="mt-5 text-end d-flex" v-if='voltar'>-->

<!--            <button class="ms-auto btn btn-primary" @click ='mudar'><i class="bi bi-arrow-left"></i></button>-->
<!--            <button v-if="!this.$children.mandarMensagem" type="button" class="btn btn-primary" @click="this.$children.buttonAdicionar">-->
<!--                Adicionar Mensagem-->
<!--            </button>-->
<!--        </div>-->
    </div>

</template>

<script>
    import forum from "./forum";
    import mensagem from "./mensagem";
    export default {
        name: "forumShow",
        props: ['tipo_props'],
        components:{
            forum,
            mensagem,
            voltar: false
        },
        data (){
            return {
                componentInicial: forum,
                tipoUtilizador: JSON.parse(this.tipo_props),
                idForum: ''
            }
        },
        methods:{
            mudar(id){

                if ( this.componentInicial === mensagem){
                    this.componentInicial = forum
                    this.voltar = false;
                }else {
                    this.voltar = true;
                    this.idForum = id;
                    this.componentInicial = mensagem
                }

            }
        },
        mounted() {
            this.$root.$on('mudar', this.mudar);
        }
    }
</script>

<style scoped>

</style>
