<template>
    <div>
<!--        <nav aria-label="breadcrumb">-->
<!--            <ol class="breadcrumb">-->
<!--                <li class="breadcrumb-item"><a href="#">Fórum</a></li>-->
<!--                <li class="breadcrumb-item active" aria-current="page">Mensagens</li>-->
<!--            </ol>-->
<!--        </nav>-->
        <forum tipo_prop="tipoUtilizador" :is='componentInicial' />
<!--        <mensagem id_props="id_forum" :is='!componentInicial' />-->


        <div class="text-end mt-5" v-if='voltar'>
            <button class="btn btn-primary" @click ='mudar'>Voltar</button>

        </div>
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
