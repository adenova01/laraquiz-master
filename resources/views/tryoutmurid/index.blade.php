@extends('voyager::master')

@section('content')
    <div class="page-content">
        @include('voyager::alerts')
        @include('voyager::dimmers')
        <div class="container-fluid">
            
            <div class="panel">
                <div class="panel-header">
                    <h2 class="h1">Tryout</h2>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                       <table class="table" id="tryout">
                           <thead>
                               <tr>
                                   <th>No.</th>
                                   <th>Nama Tryout</th>
                                   <th>Deskripsi</th>
                                   <th>Harga</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach ($quis as $data)
                                   <tr>
                                       <td>{{ $loop->index+1 }}</td>
                                       <td>{{ $data->quiz_name }}</td>
                                       <td>{{ $data->description }}</td>
                                       <td>{{ $data->quiz_price }}</td>
                                       <td>
                                           @if (count($mytryout)>0)
                                                @foreach ($mytryout as $item)
                                                    @if ($data->id==$item->id_quiz)
                                                        <a href="{{url('tryout/mulai-ujian',$data->id)}}"><button class="btn btn-success">Ikuti Ujian</button></a>
                                                    @else
                                                        @if ($data->quiz_price==0)
                                                            <a href="{{url('tryout/mulai-ujian',$data->id)}}"><button class="btn btn-success">Ikuti Ujian</button></a>
                                                        @else
                                                            <a href="{{url('tryout/beli-quis',$data->id)}}"><button class="btn btn-primary">Beli Tryout</button></a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                           @else
                                                @if ($data->quiz_price==0)
                                                    <a href="{{url('tryout/mulai-ujian',$data->id)}}"><button class="btn btn-success">Ikuti Ujian</button></a>
                                                @else
                                                    <a href="{{url('tryout/beli-quis',$data->id)}}"><button class="btn btn-primary">Beli Tryout</button></a>
                                                @endif
                                           @endif
                                          
                                       </td>
                                   </tr>
                               @endforeach
                           </tbody>
                       </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
@livewireScripts()
    <script>
        $(document).ready(function(){
            $('#tryout').DataTable();
        });
    </script>
@stop
