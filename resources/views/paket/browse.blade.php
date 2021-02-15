@extends('voyager::master')


<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>


@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12" style="padding:4%">
                @if(!$quis->isEmpty())
                    @foreach ($quis as $data)
                    <div class="card" style="width: 20rem;">
                        <img class="card-img-top" src="@if( !filter_var($data->gambar, FILTER_VALIDATE_URL)){{ Voyager::image( $data->gambar ) }}@else{{ $data->gambar }}@endif" alt="Card image cap" width="100%">
                        <div class="card-body">
                            <h5 class="card-title">Quiz Name : {{ $data->quiz_name }}</h5>
                            <p class="card-text">Description : {{ $data->description }}</p>
                            <p class="card-text h5">Price : {{ number_format($data->quiz_price,0,",",".") }}</p>
                            <a href="{{url('/quiz',$data->id)}}" class="btn btn-primary">Pilih Quiz</a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <h3>Belum Ada Quiz</h3>
                @endif
            </div>
        </div>
    </div>

@stop



