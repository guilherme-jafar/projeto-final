<template>
    <div class="section-editar-pergunta">
        sdfsdfdsfdsfdsf
        dsfdsfsd
jbbjbkjkbkbjbj
    </div>
</template>


<script>

    import $ from 'jquery';
    import axios from "axios";


    export default {
        name: "perguntaEditar",
        props: ['pergunta_prop'],

        data() {
            return {
                pergunta: JSON.parse(this.pergunta_prop),

            }
        },
        methods: {

        },
        mounted() {

        }
    }
</script>


<style scoped>

</style>
