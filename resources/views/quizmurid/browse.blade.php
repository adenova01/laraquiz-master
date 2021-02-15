@extends('voyager::master')


<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

<style>
    .soal{
        padding: 5%;
        background: #a2d0c1;
    }
    .jawaban{
        margin-top:3%;
    }
    .btn-group{
        width: 100%;
    }
    .btn-group button{
        margin: 3%;
    }
</style>
@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div id="app">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-8">
                        <p class="h3 text-center" id="waktu">@{{convertTime(quis[0].duration)}}</p>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success btn-block">Selesai</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <p class="h4">Question xx of @{{questions.length}}</p>
                    <div class="card">
                        <div class="card-body">
                            <div class="soal">
                                <p>Ini Soalnya ?</p>
                            </div>
                            <div class="jawaban">
                                    <ul class="list-group">
                                        <li class="list-group-item">A.</li>
                                        <li class="list-group-item">b.</li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <p class="h3">Nomor Soal</p>
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group btn-group-lg" role="group" aria-label="First group">
                                <button type="button" v-for="(question,index) in questions" class="btn btn-primary" :quest-id="question">@{{index+1}}</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script>
        new Vue({
            el:"#app",
            data:{
                quis : {!! json_encode($quis->toArray()) !!},
                questions :{!! json_encode($questions) !!},
            },
            methods: {
                convertTime:function(val){
                    var hours = Math.floor(val / 60);
                    var minutes = val % 60;
                    hours
                    return `${hours>=10?hours:'0'+hours}:${minutes>9?minutes:'0'+minutes}`;
                }
            },
        })
        
    </script>
@stop





