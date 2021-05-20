<template>

    <div id="container" class="fazerTeste mx-auto">

        <div class="counter d-flex">
            <span>{{ countDown }}</span>

        </div>


        <div class="pergunta text-start">
            <p>{{ enunciado }}</p>

        </div>


        <div v-if="fileCheck()===1" style="min-height: 30rem" class="text-center">

            <img :src="'/images/Pergunta/Multimedia/'+pergunta[index]['link']" alt="imagem da pergunta" height="40%"
                 width="40%" class="mx-auto">
        </div>
        <div v-else-if="fileCheck()===2" style="min-height: 30rem" class="text-center">

            <video width="320" height="240" controls class="mx-auto">
                <source id="questionMulti" :src="'/images/Pergunta/Multimedia/'+pergunta[this.index]['link']" type="">
            </video>
        </div>
        <div v-else-if="fileCheck()===3" style="min-height: 30rem" class="text-center">

            <audio controls>
                <source id="questionMultiAudio" :src="'/images/Pergunta/Multimedia/'+pergunta[this.index]['link']"
                        type="">
            </audio>
        </div>
        <div v-else-if="fileCheck()===0" style="min-height: 30rem">

        </div>

        <div class="respostas mt-5" v-if="pergunta[index]['tipo']==='multiple'">
            <div class="row">
                <div class="col-md-6">
                    <button class="respostas-btn respostas-btn-1" id="m1" @click="response('m1')">&nbsp;</button>
                </div>
                <div class="col-md-6">
                    <button class="respostas-btn respostas-btn-2" id="m2" @click="response('m2')">&nbsp;</button>
                </div>

                <div class="col-md-6">
                    <button class="respostas-btn respostas-btn-3 mt-4" id="m3" @click="response('m3')">&nbsp;</button>
                </div>
                <div class="col-md-6">
                    <button class="respostas-btn respostas-btn-4 mt-4" id="m4" @click="response('m4')">&nbsp;</button>
                </div>
            </div>


        </div>

        <div class="respostas mt-5" v-else-if="pergunta[index]['tipo']==='true/false'">
            <div class="row">
                <div class="col-md-6">
                    <button class="respostas-btn respostas-btn-1" id="tf1" value="true" @click="response('tf1')">True
                    </button>
                </div>
                <div class="col-md-6">
                    <button class="respostas-btn respostas-btn-2" id="tf2" value="false" @click="response('tf2')">False
                    </button>
                </div>
            </div>


        </div>

        <div class="respostas mt-5" v-else-if="pergunta[index]['tipo']==='multiple-select'">

            <div class="row">
                <p class="text-center">
                      <span class="selecao-mul mx-auto" v-if="pergunta[index]['tipo']==='multiple-select'">
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
</template>

<script>
    import $ from "jquery";
    import VueCookies from 'vue-cookies'

    export default {
        name: "perguntaQuizz",
        props: ['pergunta_prop', 'quizz_session'],
        data() {
            return {
                timer: '',
                questionType: '',
                enunciado: '',
                valor: '',
                resposta: '',
                resultado: 0,
                res: 0,
                index: 0,
                countDown: 0,
                session: JSON.parse(this.quizz_session),
                pergunta: JSON.parse(this.pergunta_prop),
                first: 0,
                respostasMultiplas: [],
                respostasCertas: 0,
                respostasEscolhidas: [],
                botaoEscolhido: []
            }
        },
        methods: {
            countDownTimer() {
                if(this.countDown > 0) {
                    this.timer = setTimeout(() => {
                        this.countDown -= 1
                        $cookies.config('1d')
                        $cookies.set('quizz', this.session+"@"+this.index + '@' + this.resultado+'@'+this.countDown);
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
                while (currentDate - date < milliseconds) {
                    currentDate = Date.now();
                }
            },
            change() {
                this.botaoEscolhido = [];

                this.index++;
                $cookies.config('1d')
                $cookies.set('quizz', this.session + "@" + this.index + '@' + this.resultado + "@" + this.pergunta[this.index - 1]['tempo']);
                if (this.index < this.pergunta.length) {
                    this.getRespostas();

                    //this.sleep(2500)

                } else {
                    clearTimeout(this.timer)
                    window.location.replace('/EndQuizz/' + this.session);
                }
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
            response(id) {
                let tempo = this.countDown;
                let tempoTotal = this.pergunta[this.index]['tempo']
                let valorTotal = this.pergunta[this.index]['valor']
                let resposta = $('#' + id).attr('value')

                if (id !== 'erro') {
                    console.log(resposta.toLowerCase() === this.resposta.toLowerCase())
                    if (resposta.toLowerCase() === this.resposta.toLowerCase()){
                        this.res = Math.round((valorTotal * tempo) / tempoTotal);
                    }else{
                        this.res = 0;
                    }
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
                form.append('resposta', resposta)
                form.append('resultado', this.res)
                form.append('tipo', this.pergunta[this.index]['tipo'])
                form.append('sessioId', this.session)
                axios.post('/setResposta', form).then(function (response) {
                    this.change()
                    this.sleep(2500)
                }.bind(this));
            },
            getRespostas() {
                var respostas;
                let form = new FormData();
                form.append('id', this.pergunta[this.index]['id'])
                axios.post('/getRespostas', form).then(function (response) {
                    if (response.data.message === 'erro') {
                        this.index++;
                        this.enunciado = this.pergunta[this.index]['enunciado']
                        this.getRespostas();
                    } else {
                        respostas = response.data.message
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
                            for (i =respostas.length ; i < 4; i++){
                                let k = i + 1
                                $('#m' + k).hide()
                            }
                        } else if (this.pergunta[this.index]['tipo'] === 'multiple-select') {
                            this.first = 0;
                            this.respostasMultiplas = [];
                            let i;
                            for ( i = 0; i < respostas.length; i++) {
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
                            for (i =respostas.length ; i < 4; i++){
                                let k = i + 1
                                $('#m' + k).hide()
                            }
                        }

                        let cookie = $cookies.get('quizz')
                        cookie = cookie.split('@')
                        if (cookie[3]!==0 && this.index === cookie[1]){
                            this.countDown = cookie[3]
                        }
                        else{
                            this.countDown = this.pergunta[this.index]['tempo']
                        }
                        this.enunciado = this.pergunta[this.index]['enunciado']
                        this.valor = this.pergunta[this.index]['valor']
                        this.res = 0
                        this.countDownTimer()

                        $('.wrapper-wrong').hide();
                        $('.wrapper-wright').hide();
                        $('.wrapper').hide();

                    }
                }.bind(this));
            },
            fileCheck() {
                if (this.pergunta[this.index]['link'] === null) {
                    return 0;
                } else {
                    let ext = this.getExtension(this.pergunta[this.index]['link'])
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
            getExtension(filename) {
                var parts = filename.split('.');
                return parts[parts.length - 1];
            },
            startQuestion() {
                this.questionType = this.pergunta[this.index]['tipo']
                this.enunciado = this.pergunta[this.index]['enunciado']
                this.valor = this.pergunta[this.index]['valor']
            }
        },
        mounted() {
            $('.wrapper').hide();
            $('.wrapper-wrong').hide();
            $('.wrapper-wright').hide();
            if ($cookies.get('quizz')) {
                let cookie = $cookies.get('quizz')
                cookie = cookie.split('@')
                if (this.session === cookie[0]) {
                    this.index = cookie[1];
                    this.res = cookie[2];

                    this.getRespostas();
                    this.countDown = cookie[3];
                    console.log(this.countDown)

                    this.startQuestion();

                } else {
                    this.index = 0;
                    this.countDown = this.pergunta[this.index]['tempo'] + 1
                    this.getRespostas();
                    this.startQuestion();

                }
            } else {
                this.index = 0;
                this.countDown = this.pergunta[this.index]['tempo'] + 1
                this.getRespostas();
                this.startQuestion();

            }
        }
    }
</script>

<style scoped>
</style>
