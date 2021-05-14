<template>
    <div>
        <div class="modal-footer">
           vdfvfbgf
        </div>
    </div>
</template>


<script>

    import $ from 'jquery';
    import axios from "axios";


    export default {
        name: "editarPergunta",
        props: ['pergunta_prop'],
        data() {
            return {
                pergunta: JSON.parse(this.pergunta_prop),

            }
        },
        methods: {},
        mounted() {

            console.log('efjsdnvkfd')
        }
    }
</script>
