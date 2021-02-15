@extends('ujianAttempt.layoutUjian')

@php
    $arrQuest=explode(',',$quis->id_questions);
@endphp
@section('content')
    <div class="page-content">
        @include('voyager::alerts')
        @include('voyager::dimmers')
        <div id="app">
            <div class="row">
                <div class="col-md-8">
                    <div class="row header-ujian">
                        <div class="col-md-3">
                            <div class="jenis-soal alert alert-primary" role="alert">
                                @{{jenis_soal}}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <center><div class="waktu alert alert-warning" role="alert"><span id="duration">@{{countdown}}</span></div></center>
                        </div>
                    </div>
                    <div class="row container-soal">
                        <div class="col-md-12">
                            <div class="paragraph-soal">
                                <h3 class="display-6">Paragraph</h3>
                                <div v-if="status" v-html="questions[0].paragraph">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="pertanyaan">
                                <h3 class="display-6">Pertanyaan</h3>
                                <div v-if="status" v-html="questions[0].question">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="container-jawaban">
                            <h3 class="h3">Jawaban</h3>
                            <ul class="list-jawaban">
                                <li  v-for="(question,index) in questions" :class="['alert' , {'alert-success' : question.id==selected} , {'alert-dark' : question.id!=selected}]" v-on:click="saveJawaban(question.idq,question.id,question.score,question.correct_answer,$event)" v-html="question.answer">@{{question.answer}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row header-soal">
                        <div class="col-md-12">
                            <center><div class="waktu alert alert-warning" role="alert">Daftar Soal</div></center>
                        </div>
                    </div>
                    <ul class="daftar-soal">
                        @foreach ($arrQuest as $item)
                            <a><li v-on:click="getQuestion({{$item}})">{{ $loop->index+1 }}</li></a>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success"  v-on:click="previousSoal(questions[0].idq)" >Soal Sebelumnya</button>
                    <button class="btn btn-success"  v-on:click="nextSoal(questions[0].idq)" >Soal Selanjutanya</button>
                    <button class="btn btn-primary" v-on:click="finishExam('selesai')">Selesai</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script>    
       new Vue({
        el: '#app',
        data :{
            questions:[],
            jenis_soal:'',
            options:[],
            selected:undefined,
            countdown:'',
            resultUjian:[]
        },
        watch : {
            
        },
        methods:{
            selectedOptions:function(idq){
                if(this.options.length>0){
                    index=this.options.findIndex((obj=>obj.id_qbanks==idq));
                    if(index!=-1){
                        this.selected=this.options[index].id_option;
                    }
                }
            },
            previousSoal:function(idq){
                this.getQuestion(idq-1);
                if(this.options.length>0){
                    index=this.options.findIndex((obj=>obj.id_qbanks==idq-1));
                    if(index!=-1){
                        this.selected=this.options[index].id_option;
                    }
                }
            },
            nextSoal:function(idq){
                this.getQuestion(idq+1);
                if(this.options.length>0){
                    index=this.options.findIndex((obj=>obj.id_qbanks==idq+1));
                    if(index!=-1){
                        this.selected=this.options[index].id_option;
                    }
                }
            },
            saveJawaban : function(idq,id_option,score,correct,e){ 
                this.selected=id_option;
                var url="{{url('/api/question')}}";
                axios
                    .post(url,
                        [{
                            id_user:{{Auth::user()->id}},
                            id_quis:{{$quis->id}},
                            id_qbanks:idq,
                            id_option:id_option,
                            countdown:this.countdown
                        }]
                    )
                    .then(response=>{
                            console.log(response.data);
                    });

                if(this.options.length>0){
                    objIndex=this.options.findIndex((obj=>obj.id_qbanks==idq));
                    if(objIndex== -1 ){
                        this.options.push({id_user:{{Auth::user()->id}},id_quis:{{$quis->id}},id_qbanks:idq,id_option:id_option,score:score,countdown:this.countdown,correct:correct});
                    }else{
                        this.options[objIndex]=({id_user:{{Auth::user()->id}},id_quis:{{$quis->id}},id_qbanks:idq,id_option:id_option,score:score,countdown:this.countdown,correct:correct});
                        
                    }
                    
                }else{
                    this.options.push({id_user:{{Auth::user()->id}},id_quis:{{$quis->id}},id_qbanks:idq,id_option:id_option,score:score,countdown:this.countdown,correct:correct});
                }
                console.log(this.options);
                
            },
            getQuestion :function(id){
                var id=id;
                var url="{{url('/api/question')}}/";
                this.selectedOptions(id);
                axios
                    .get(url+id)
                    .then(response => {
                        if(response.data.data.length>0){
                            this.questions = response.data.data;
                            this.status=true;
                            if(this.questions[0].question_type==1){
                                this.jenis_soal="Multi Option Single Choice";
                            }else{
                                this.jenis_soal="Multi Option Multiple Choice";
                            }
                        }
                        MathJax.typesetPromise().then(() => {
                            // modify the DOM here
                            MathJax.typesetPromise();
                        }).catch((err) => console.log(err.message));
                        //console.log(this.questions);
                    })
                    .catch(err => {
                        console.log(err)
                    });
                

            },
            finishExam:function(status){
                var score=0;
                var avg=0;
                var correct=0;
                var dateTime=this.getDateTimeNow();
                var persen=0;
                var resultStatus;
                
                if(this.options.length>0){
                    $.each(this.options,function(i,val){
                        score+=val.score;
                        avg++
                        if(val.correct!=0){
                            correct++;
                        }
                    });

                    persen=correct/avg*100;
                }else{
                    persen=0
                }
                
                if({{$quis->pass_percentage}}>=persen){
                    resultStatus="FAIL";
                }else{
                    resultStatus="PASS";
                }
                
                this.resultUjian={id_user:{{Auth::user()->id}},id_quis:{{$quis->id}},start_time:dateTime,score:score,percentage_obtained:persen,resultStatus:resultStatus}
                if(status=="timeout"){
                    axios
                        .post(url,this.resultUjian)
                        .then(response=>{
                            console.log(response.data);
                    });
                }else{
                    if(confirm('Apakah Ingin Mengakhiri Sesi Ujian')){
                        var url="{{url('/api/saveResult')}}";
                        axios
                            .post(url,this.resultUjian)
                            .then(response=>{
                                console.log(response.data.data);
                                if(response.data.data.code==200){
                                    alert('Terima Kasih Sudah Mengikuti Ujian');
                                    location.href='{{url("/tryout")}}';
                                }
                        });
                    }else{
                        console.log('tidak berkahri');
                    }  
                }
            },
            TimeCountdown : function(){
                var duration={!! $quis->duration !!};
                //var duration=1;
                var hours=Math.floor(duration/60);
                var minutes=duration%60;
                var seconds=(duration*60)%60;
                var v=this;
                setInterval(function(){
                    if(seconds == 0){
                        if(minutes == 0){
                            if(hours==0){
                                if(seconds==0 && minutes==0 && hours == 00){
                                    this.finishExam('timeout');
                                }else{
                                    minutes=60;
                                }
                            }else{
                                hours--;
                            }
                        }else{
                            minutes--;
                            seconds=59;
                        }
                    }else{
                        seconds--;
                    }
                    v.countdown= hours+':'+minutes+':'+seconds;
                    
                },1000);
            },
            getDateTimeNow:function(){
                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                var dateTime = date+' '+time;
                return dateTime;
            }

        },
        mounted () {
            
            this.TimeCountdown();
            this.getQuestion({{$arrQuest[0]}});
            
        }
        })
    </script>
    <script>
       /* var confirm=confirm('Siap Untuk Memulai Ujian ?');
        if(confirm==false){
            location.href="{{url('/tryout')}}"
        }
        var minute={!! $quis->duration - 1 !!};
        //var minute=0;
        var sec=59;
        setInterval(function(){
            document.getElementById("duration").innerHTML = minute + " : " + sec;
            sec--;
            if(sec == 00 && minute == 0){
                location.href='{{url("/tryout")}}';
            }else{
                if (sec == 00) {
                    minute --;
                    sec = 60;
                }
            }
        },1000);*/

       
        
    </script>
@stop
