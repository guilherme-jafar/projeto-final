<template>

<div id="container">

    {{ countDown }}


    <p >{{ enunciado }}</p>

<div v-if="fileCheck()===1">

<img :src="'/images/Pergunta/Multimedia/'+pergunta[index]['link']" alt="imagem da pergunta" height="40%" width="40%">
</div>
    <div v-else-if="fileCheck()===2">

        <video width="320" height="240" controls>
        <source id="questionMulti" :src="'/images/Pergunta/Multimedia/'+pergunta[this.index]['link']" type="">
        </video>
    </div>
    <div v-else-if="fileCheck()===3">

        <audio controls>
            <source id="questionMultiAudio" :src="'/images/Pergunta/Multimedia/'+pergunta[this.index]['link']" type="">
        </audio>
    </div>
    <div v-else-if="fileCheck()===0">

    </div>

    <div v-if="pergunta[index]['tipo']==='multiple'">
        <button id="m1" @click="response('m1')"></button>
        <button id="m2" @click="response('m2')"></button><br>
        <button id="m3" @click="response('m3')"></button>
        <button id="m4" @click="response('m4')"></button>
    </div>
    <div v-else-if="pergunta[index]['tipo']==='true/false'">
        <button id="tf1" value="true" @click="response('tf1')">True</button>
        <button id="tf2" value="true" @click="response('tf2')">False</button>

    </div>







</div>
</template>

<script>
import $ from "jquery";
import VueCookies from 'vue-cookies'

export default {
    name: "perguntaQuizz",
    props: ['pergunta_prop','quizz_session'],
    data(){
        return{
            timer:'',
            questionType:'',
            enunciado:'',
            valor:'',
            resposta:'',
            resultado:'',
            res:0,
            index:0,
            countDown:0,
            session:JSON.parse(this.quizz_session),
            pergunta: JSON.parse(this.pergunta_prop)
        }
    },
    methods:{
        countDownTimer() {


            if(this.countDown > 0) {

               this.timer= setTimeout(() => {
                   console.log("pddoise")
                        this.countDown -= 1


                    this.countDownTimer()


                }, 1000)
            }
            else if(this.countDown ===0){
                this.response('erro')

            }




        },

         sleep(milliseconds) {

    const date = Date.now();
    let currentDate = null;
             while (currentDate - date < milliseconds)  {
        currentDate = Date.now();

    }



},

        change(){

            this.index++;
            $cookies.config('1d')
            $cookies.set('quizz',this.index+'@'+this.resultado);
            this.getRespostas();
            this.countDown=this.pergunta[this.index]['tempo']
            this.enunciado=this.pergunta[this.index]['enunciado']
            this.valor=this.pergunta[this.index]['valor']
            this.res=0
            $('.wrapper').hide();
            this.countDownTimer()

        },


        response(id){
            var tempo = this.countDown;
            var tempoTotal=this.pergunta[this.index]['tempo']
            var valorTotal=this.pergunta[this.index]['valor']
            var resposta=$('#'+id).html()
            if (id!=='erro') {
                if (resposta.toLowerCase() === this.resposta.toLowerCase())
                    this.res = (valorTotal * tempo) / tempoTotal;
                else
                    this.res = 0;
            }else{
                this.res = 0;
            }
            $('.wrapper').show();

            if (this.res>0) {

                $('#couter').html(this.res)
            }
            else{
                $('#couter').html(0)

            }
            this.resultado += this.res;
            clearTimeout(this.timer)
            this.countDown=0;








            let form = new FormData();
            form.append('id',this.pergunta[this.index]['id'])
            form.append('pergunta',this.pergunta[this.index]['enunciado'])
            form.append('resposta', resposta)
            form.append('resultado',this.res)
            form.append('tipo',this.pergunta[this.index]['tipo'])
            form.append('sessioId',this.session)


            axios.post('/setResposta', form).then(function (response) {

                this.sleep(1500)

                console.log("pois")

                this.change()


            }.bind(this));






        },


        getRespostas() {
            var respostas;
            let form = new FormData();
            form.append('id', this.pergunta[this.index]['id'])
            axios.post('/getRespostas', form).then(function (response) {

                if (response.data.message === 'erro') {
                    this.index++;
                    $cookies.set('index', this.index);
                    this.enunciado = this.pergunta[this.index]['enunciado']
                    this.getRespostas();
                } else {
                    respostas = response.data.message
                    console.log(respostas)
                    if (this.pergunta[this.index]['tipo'] === 'true/false') {

                        this.resposta = respostas[0]['resposta']

                    } else if (this.pergunta[this.index]['tipo'] === 'multiple') {

                        let i;
                        for (i = 0; i < respostas.length; i++) {

                            let k = i + 1

                            if (respostas[i]['resposta'] === " ") {
                                $('#m' + k).hide()
                            } else {
                                if (respostas[i]['resultado'] === 1)
                                    this.resposta = respostas[i]['resposta']


                                $('#m' + k).show()
                                $('#m' + k).html(respostas[i]['resposta']);
                                $('#m' + k).val(respostas[i]['resposta']);
                            }
                        }


                    }


                }

            }.bind(this));

        },

        fileCheck(){

            if (!this.pergunta[this.index]['link']) {
                return 0;
            } else {

                let ext = this.getExtension(this.pergunta[this.index]['link'])
                //console.log(this.pergunta[this.index]['link'])
                switch (ext.toLowerCase()) {
                    case 'jpeg':
                    case 'gif':
                    case 'bmp':
                    case 'png':
                        //etc

                        return 1;
                }


                switch (ext.toLowerCase()) {
                    case 'm4v':
                    case 'avi':
                    case 'mpg':
                    case 'mp4':

                        // etc
                        $('#questionMulti').attr("type", 'video/' + ext);
                        return 2;
                }


                switch (ext.toLowerCase()) {
                    case 'ogg':
                    case 'mpeg':
                    case 'mp3':

                        // etc
                        $('#questionMultiAudio').attr("src", 'audio/' + ext);
                        console.log(ext)
                        return 3;
                }
            }
            return 0;


        },
        getExtension(filename) {
            var parts = filename.split('.');
            return parts[parts.length - 1];
            },
        startQuestion() {

            this.countDown = this.pergunta[this.index]['tempo']
            this.questionType = this.pergunta[this.index]['tipo']
            this.enunciado = this.pergunta[this.index]['enunciado']
            this.valor = this.pergunta[this.index]['valor']
            // if ($cookies.get('index'))
            //     this.index = $cookies.get('index')
            // else
                this.index=0;



        }


    },
    mounted() {
        this.getRespostas();
        this.startQuestion();
        $('.wrapper').hide();
        this.countDownTimer();
    }



}
</script>

<style scoped>


</style>
