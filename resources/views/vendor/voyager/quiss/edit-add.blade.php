@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
   
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if($edit)
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp
        
                            @foreach($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                
                                @if (isset($row->details->legend) && isset($row->details->legend->text))
                                    <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                @endif

                                <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                    @php
                                        //echo $row->field;
                                        $question='id_questions';
                                    @endphp
                                    {{ $row->slugify }}
                                    @if ($row->getTranslatedAttribute('display_name')!="users")
                                        <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                    @endif
                                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                                    @if (isset($row->details->view))    
                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                    @elseif ($row->type == 'relationship')
                                        @if ($row->getTranslatedAttribute('display_name')!="users")
                                            @include('voyager::formfields.relationship', ['options' => $row->details])
                                        @else
                                            <input type="hidden" name="inserted_by" value="{{Auth::user()->id}}">
                                        @endif
                                        
                                    @else
                                        @if($row->field==$question)
                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!} <button type="button"class="btn btn-primary btn-small" data-toggle="modal" data-target="#modalAddQuestions">List Question</button>
                                        @else
                                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                        @endif
                                    @endif

                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                    @endforeach
                                    @if ($errors->has($row->field))
                                        @foreach ($errors->get($row->field) as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            @section('submit-buttons')
                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddQuestions">
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Questions</h4>
                </div>
                @php
                    $options=explode(',',$dataTypeContent->id_questions);
                @endphp
                {{ !empty($edit)}}
                <div class="modal-body">
                   <div class="table-responsive">
                       <table class="table" id="qbanks">
                           <thead>
                               <tr>
                                   <th>No.</th>
                                   <th>Question</th>
                                   <th>Paragraph</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>
                            @php
                                $i=1;
                            @endphp
                            @if($edit)
                                @foreach ($qbanks as $data)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{!! $data->question!!}</td>
                                    <!--str_replace(array('>','<','/','p'),'',$data->paragraph)-->
                                    <td>{{ strip_tags($data->paragraph) }}</td>
                                    <td>
                                        @if (in_array($data->id,$options))
                                            <button class="btn btn-success btn-add-question btn-sm" id_question="{{$data->id}}">Remove Question</button>
                                        @else
                                            <button class="btn btn-success btn-add-question btn-sm" id_question="{{$data->id}}">Add Question</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                @foreach ($qbanks as $data)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{!! $data->question!!}</td>
                                    <!--str_replace(array('>','<','/','p'),'',$data->paragraph)-->
                                    <td>{{ strip_tags($data->paragraph) }}</td>
                                    <td><button class="btn btn-success btn-add-question btn-sm" id_question="{{$data->id}}">Add Question</button></td>
                                </tr>
                                @endforeach
                            @endif  
                           </tbody>
                       </table>
                   </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
    

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }
        
        $('document').ready(function () {
            if({!! !empty($edit) ? "1" : "0" !!} == "1"){
                var dump="{{$dataTypeContent->id_questions}}";
                if(dump==""){
                    var data_question=new Array();
                }else{
                    var data_question=dump.split(',');   
                }
                //console.log(data_question);
            }else{
                var data_question=new Array();
            }
            $('#qbanks').DataTable();
            $('[name="id_questions"]').attr('readonly','readonly');

            if({!! !empty($edit) ? "1" : "0" !!} == "1"){
            $('#modalAddQuestions').on('click','.btn-add-question',function(){
                if($(this).html()=="Add Question"){
                    $(this).html('Remove Question');
                    data_question.push($(this).attr('id_question'));
                    $('[name="id_questions"]').val(data_question.join());
                    console.log($('[name="id_questions"]').val());
                }else{
                    $(this).html('Add Question');
                    var index=data_question.indexOf($(this).attr('id_question'));
                    data_question.splice(index,1);
                    $('[name="id_questions"]').val(data_question.join());
                    console.log($('[name="id_questions"]').val());
                }
            });
            }else{
            $('#modalAddQuestions').on('click','.btn-add-question',function(){
                if($(this).html()=="Add Question"){
                    $(this).html('Remove Question');
                    data_question.push($(this).attr('id_question'));
                    $('[name="id_questions"]').val(data_question.join());
                    console.log($('[name="id_questions"]').val());
                }else{
                    $(this).html('Add Question');
                    var index=data_question.indexOf($(this).attr('id_question'));
                    data_question.splice(index,1);
                    $('[name="id_questions"]').val(data_question.join());
                    console.log($('[name="id_questions"]').val());
                }
            });
            }


            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
