@extends('voyager::master')

@section('content')
<script src="https://use.fontawesome.com/99eacc81c5.js"></script>
    <div class="page-content">
        @include('voyager::alerts')
        @include('voyager::dimmers')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="h2">Daftar TryOut</h6>
                </div>
            </div>
            <div class="row">
                @foreach ($getDetailBuyPaket as $item)
                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <div class="card">
                            <div class="row align-content-center">
                                <div class="col-md-12">
                                    <img src="{{url('/storage',$item->gambar)}}" alt="" class="img-thumbnail" style="height:200px; min-width:100%">
                                </div>
                            </div>
                            <div class="card-body" style="padding:10px !important;">
                                <h5 class="card-title h3">{{ $item->quiz_name }}</h5>
                                <p class="card-text">Deskripsi Tryout : {!! $item->description !!}</p>
                                <p class="card-text"><span class="glyphicon glyphicon-time"></span> Durasi Pengerjaan : {{ $item->duration }} Menit</p>
                                <a href="{{url('/tryout/mulai-ujian',$item->id_quiss)}}" target="_blank" class="btn btn-success">Mulai Tryout</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@stop

@section('javascript')
<script>
    /*$(document).ready(function(){
        $('.detail').on('click',function(){
            var id=$(this).attr('id-group');
            $.ajax({
                type:"GET",
                url:"{{url('api/paket')}}/"+id,
                dataType:"json",
                success : function(response){
                    console.log(response);
                }
            })
        });
    });*/
</script>
@stop
