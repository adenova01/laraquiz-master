@extends('voyager::master')

@section('content')
    <div class="page-content">
        @include('voyager::alerts')
        @include('voyager::dimmers')
        <div class="container-fluid">
            
            <div class="panel">
                <div class="panel-header">
                    <h2 class="h1">My-Tryout</h2>
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
                               @foreach ($mytryout as $data)
                                   <tr>
                                       <td>{{ $loop->index+1 }}</td>
                                       <td>{{ $data->quiz_name }}</td>
                                       <td>{{ $data->description }}</td>
                                       <td>{{ $data->quiz_price }}</td>
                                       <td>
                                            <a href="{{url('tryout/mulai-ujian',$data->id_quiz)}}"><button class="btn btn-success">Ikuti Ujian</button></a>
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
