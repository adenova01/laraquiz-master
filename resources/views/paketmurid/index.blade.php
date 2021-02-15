@extends('voyager::master')

@section('content')
    <div class="page-content">
        @include('voyager::alerts')
        @include('voyager::dimmers')
        <div class="container-fluid">
            <div class="row">
                @foreach ($groups as $group)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title h3">{{ $group->group_name }}</h5>
                            <p class="card-text">{!! $group->description !!}</p>
                            <p class="card-text" style="font-weight: bold">Rp. {{ number_format($group->price,'0',',','.') }}</p>
                            @if (count($getbuypaket)>0)
                                @foreach ($getbuypaket as $item)
                                    @if ($item->id_groups==$group->id)
                                        <a href="{{url('/tryout/paket-murid/detail-paket',$group->id)}}" class="btn btn-primary">Lihat Paket</a>
                                    @else
                                        <a href="{{url('/tryout/beli-paket',$group->id)}}" target="_blank" class="btn btn-success">Beli Paket</a>
                                    @endif
                                @endforeach
                            @else
                                <a href="{{url('/tryout/beli-paket',$group->id)}}" target="_blank" class="btn btn-success">Beli Paket</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{ $groups->links() }}
                </div>
            </div>
        </div>
    </div>


@stop
<!-- Modal -->
<!--<a class="btn btn-primary detail" id-group="{{$group->id}}"  data-toggle="modal" data-target="#detailPaketModal">Detail Paket</a>
<div class="modal fade" id="detailPaketModal" tabindex="9" role="dialog" aria-labelledby="detailPaketModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Detail Paket</h4>
        </div>
        <div class="modal-body">
          ...
        </div>
      </div>
    </div>
</div>
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
</script>-->

@section('javascript')

@stop
