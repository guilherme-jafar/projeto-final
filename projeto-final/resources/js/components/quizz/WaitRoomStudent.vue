<template>
<div>


    <div v-if="pergunta.length===0">
    <p>{{students}}</p>


    <button @click="sair()">cancel</button>
    </div>



        <div v-else-if="pergunta.length!==0">
        <div id="container" class="fazerTeste mx-auto">

            <div class="counter d-flex">
                <span>{{ countDown }}</span>

            </div>


            <div class="pergunta text-start">
                <p>{{ enunciado }}</p>

            </div>


            <div v-if="fileCheck()===1" style="min-height: 30rem" class="text-center">

                <img :src="'/images/Pergunta/Multimedia/'+pergunta['link']" alt="imagem da pergunta" height="40%"
                     width="40%" class="mx-auto">
            </div>
            <div v-else-if="fileCheck()===2" style="min-height: 30rem" class="text-center">

                <video width="320" height="240" controls class="mx-auto">
                    <source id="questionMulti" :src="'/images/Pergunta/Multimedia/'+pergunta['link']" type="">
                </video>
            </div>
            <div v-else-if="fileCheck()===3" style="min-height: 30rem" class="text-center">

                <audio controls>
                    <source id="questionMultiAudio" :src="'/images/Pergunta/Multimedia/'+pergunta['link']"
                            type="">
                </audio>
            </div>
            <div v-else-if="fileCheck()===0" style="min-height: 30rem">

            </div>

            <div class="respostas mt-5" v-if="pergunta['tipo']==='multiple'">
                <div class="row">
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-1" :id="'Qm'+multipleQuestion[0]"  v-show="multipleQuestion[0] !== null" @click="response('multiple','0')">&nbsp;{{multipleQuestion[0]}}</button>
                    </div>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-2" :id="'Qm'+multipleQuestion[1]" v-show="multipleQuestion[1] !== null" @click="response('multiple','1')">&nbsp;{{multipleQuestion[1]}}</button>
                    </div>

                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-3 mt-4" :id="'Qm'+multipleQuestion[2]" v-show="multipleQuestion[2] !== null" @click="response('multiple','2')">&nbsp;{{multipleQuestion[2]}}</button>
                    </div>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-4 mt-4" :id="'Qm'+multipleQuestion[3]" v-show="multipleQuestion[3] !== null" @click="response('multiple','3')">&nbsp;{{multipleQuestion[3]}}</button>
                    </div>
                </div>


            </div>

            <div class="respostas mt-5" v-else-if="pergunta['tipo']==='true/false'">
                <div class="row">
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-1" id="tf1" value="true" @click="response('true_false','true')">True
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-2" id="tf2" value="false" @click="response('true_false','false')">False
                        </button>
                    </div>
                </div>


            </div>

            <div class="respostas mt-5" v-else-if="pergunta['tipo']==='multiple-select'">

                <div class="row">
                    <p class="text-center">
                      <span class="selecao-mul mx-auto" v-if="pergunta['tipo']==='multiple-select'">
                         Respostas<span> {{botaoEscolhido.length}}</span>  / {{respostasMultiplas.length}}
            </span>
                    </p>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-1" id="ms1" @click="responseMultiplas('ms1')">&nbsp;
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-2" id="ms2" @click="responseMultiplas('ms2')">&nbsp;
                        </button>
                    </div>

                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-3 mt-4" id="ms3" @click="responseMultiplas('ms3')">
                            &nbsp;
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="respostas-btn respostas-btn-4 mt-4" id="ms4" @click="responseMultiplas('ms4')">
                            &nbsp;
                        </button>
                    </div>
                </div>


            </div>


        </div>
        </div>


</div>
</template>

<script>
import Echo from "laravel-echo";
import $ from "jquery";

export default {
    name: "WaitRoomStudent",
    props: ['sessao_prop', 'id_prop','user_prop'],

    data() {
        return {
            timer: '',
            questionType: '',
            enunciado: '',
            valor: '',
            resposta: [],
            resultado: 0,
            res: 0,
            index: 0,
            countDown: 0,
            usersId:[],
            users: [],
            pergunta:[],
            students: JSON.parse(this.user_prop)+1,
            sessao: JSON.parse(this.sessao_prop),
            MasterSessao: JSON.parse(this.id_prop),
            first: 0,
            respostasMultiplas: [],
            respostasCertas: 0,
            respostasEscolhidas: [],
            botaoEscolhido: [],
            multipleQuestion:[]

        }
    },
    watch: {
        currentRoom() {

            this.connect();
        }
    },

    methods: {
        sair() {
            localStorage.clear();

                window.location.replace('/leaveRoom');


        },
        responseMultiplas(id) {
            if (!this.botaoEscolhido.includes(id)){
                this.botaoEscolhido.push(id);

                let resposta = $('#' + id).html()
                if (id !== 'erro') {
                    for (let i = 0; i < this.respostasMultiplas.length; i++) {
                        if (resposta.toLowerCase() === this.respostasMultiplas[i].toLowerCase()) {
                            this.respostasCertas++;
                        }
                    }
                    this.first++;
                    this.respostasEscolhidas.push(resposta);
                    if (this.first === this.respostasMultiplas.length) {
                        if (this.respostasCertas === this.respostasMultiplas.length) {
                            let tempo = this.countDown;
                            let tempoTotal = this.pergunta[this.index]['tempo']
                            let valorTotal = this.pergunta[this.index]['valor']
                            this.res = Math.round((valorTotal * tempo) / tempoTotal);
                        } else {
                            this.res = 0;
                        }
                        $('.wrapper').show();
                        if (this.res > 0) {
                            $('.wrapper').css('background-color', '#66c036')
                            $('#couter-wright').text(this.res)
                            $('.wrapper-wright').show();

                        } else {
                            $('.wrapper').css('background-color', '#f9403e')
                            $('#couter').text(0)
                            $('.wrapper-wrong').show();

                        }
                        this.resultado += this.res;
                        clearTimeout(this.timer)
                        this.countDown = 0;
                        let form = new FormData();
                        form.append('id', this.pergunta[this.index]['id'])
                        form.append('pergunta', this.pergunta[this.index]['enunciado'])
                        form.append('resposta', JSON.stringify(this.respostasEscolhidas))
                        form.append('resultado', this.res)
                        form.append('tipo', this.pergunta[this.index]['tipo'])
                        form.append('sessioId', this.session)
                        axios.post('/setResposta', form).then(function (response) {
                            this.change()
                            this.sleep(2500)
                        }.bind(this));
                    }
                }

            }

        },
        getExtension(filename) {
            var parts = filename.split('.');
            return parts[parts.length - 1];
        },
        fileCheck() {
            if (this.pergunta['link'] === null) {
                return 0;
            } else {
                let ext = this.getExtension(this.pergunta['link'])
                switch (ext.toLowerCase()) {
                    case 'jpeg':
                    case 'gif':
                    case 'bmp':
                    case 'png':
                    case 'jpg':
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
                        return 3;
                }
            }
            return 0;
        },

        connect() {
            window.Echo.private('room.'+this.MasterSessao)
                .listen('.NewStudent', e => {

                    if (e.Mainsession===this.MasterSessao) {
                        //console.log(!this.usersId.includes(e.userId) && e.type==='student')
                        if ( e.type==='student') {
                            this.students++

                            localStorage.setItem('students',this.students);
                        }
                        else if (e.type==='leaveMaster') {

                           this.sair()

                        }
                        else if (e.type==='leavestudent'){
                            this.students--
                            localStorage.setItem('students',this.students);

                        }else if (e.type==='startQuizz'){

                           $('#waitRoom').hide()
                           this.getResposta(e.quizzArray,e.Ans)

                        }else if (e.type==='NewQuestion'){
                            $('.wrapper').hide();
                            $('.wrapper-wrong').hide();
                            $('.wrapper-wright').hide();
                            this.getResposta(e.quizzArray,e.Ans)

                        }



                    }

                });


        },
        sleep(milliseconds) {
            const date = Date.now();
            let currentDate = null;
            while (currentDate - date < milliseconds) {
                currentDate = Date.now();
            }
        },
        response(type,id) {
            let resposta;
             let tempo = this.countDown;
            let tempoTotal = this.pergunta['tempo']
            let valorTotal = this.pergunta['valor']
            if (type==='multiple'){
            resposta = this.multipleQuestion[id];}
            else{
            resposta=id;}


            if (id !== 'erro') {

                if (resposta.toLowerCase() === this.resposta.toLowerCase()){
                    this.res = Math.round((valorTotal * tempo) / tempoTotal);
                }else{
                    this.res = 0;
                }
            } else {
                this.res = 0;
            }
            console.log(resposta+" "+this.res);
            $('.wrapper').show();

            if (this.res > 0) {
                $('.wrapper').css('background-color', '#66c036')
                $('#couter-wright').text(this.res)
                $('.wrapper-wright').show();

            } else {
                $('.wrapper').css('background-color', '#f9403e')
                $('#couter').text(0)
                $('.wrapper-wrong').show();

            }
            this.resultado += this.res;
            // clearTimeout(this.timer)
            this.countDown = 0;
            let form = new FormData();
            form.append('id', this.pergunta['pId'])
            form.append('pergunta', this.pergunta['enunciado'])
            form.append('resposta', resposta)
            form.append('resultado', this.res)
            form.append('tipo', this.pergunta['tipo'])
            form.append('sessioId', this.sessao)
            axios.post('/setRespostaQuizz', form).then(function (response) {
                // this.change()
                // this.sleep(2500)
            }.bind(this));
        },
        getResposta(array,Ans){


            this.pergunta=array;
            var respostas=Ans;

            console.log(this.pergunta)
            console.log(respostas)
            if (this.pergunta['tipo'] === 'true/false') {
                this.resposta = respostas[0]['resposta']
                console.log(this.resposta)
            } else if (this.pergunta['tipo'] === 'multiple') {
                console.log('pois')
                let i;
                for (i = 0; i < respostas.length; i++) {

                    if (respostas[i]['resposta'] === " ") {
                        this.multipleQuestion[i]=null;

                    } else {
                        if (respostas[i]['resultado'] === 1) {
                            this.resposta = respostas[i]['resposta']
                        }

                        this.multipleQuestion[i]=respostas[i]['resposta'];

                    }
                }
            } else if (this.pergunta['tipo'] === 'multiple-select') {
                this.first = 0;
                this.respostasMultiplas = [];
                for (let i = 0; i < respostas.length; i++) {
                    let k = i + 1
                    if (respostas[i]['resposta'] === " ") {
                        $('#ms' + k).hide()
                    } else {
                        if (respostas[i]['resultado'] === 1) {
                            this.respostasMultiplas.push(respostas[i]['resposta'])
                        }
                    }
                    this.respostasCertas = 0;
                    $('#ms' + k).show()
                    $('#ms' + k).html(respostas[i]['resposta']);
                    $('#ms' + k).val(respostas[i]['resposta']);
                }
            }
            this.startQuestion();
            $('#quizz').show();
        },
        startQuestion() {
            this.questionType = this.pergunta['tipo']
            this.enunciado = this.pergunta['enunciado']
            this.valor = this.pergunta['valor']
            this.countDown=this.pergunta['tempo']
        }



        },
        mounted() {
            $('.wrapper').hide();
            $('#quizz').hide();

            if (localStorage.getItem('sessao')!=null){
                this.students=localStorage.getItem('students');

            }
            else{
                localStorage.setItem('sessao',this.MasterSessao);
                localStorage.setItem('students',this.students);
            }

            this.connect();

        },

}
</script>

<style scoped>

</style>
