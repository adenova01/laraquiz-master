<textarea class="form-control richTextBox" name="{{ $row->field }}[]" id="richtextbox0">
    {{ old($row->field, $dataTypeContent->{$row->field} ?? '') }}
</textarea>

@push('javascript')
    <script>
        
        $(document).ready(function() {
            //create_tinymce('richtextbox_1');
            var additionalConfig = {
                selector: '.richTextBox',
                min_height:150
                }

                $.extend(additionalConfig, {!! json_encode($options->tinymceOptions ?? '{}') !!})

                tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
            
            /*if(){
                var additionalConfig = {
                selector: '.richTextBox',
                min_height:150
                }

                $.extend(additionalConfig, {!! json_encode($options->tinymceOptions ?? '{}') !!})

                tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
            }else{
                var additionalConfig = {
                selector: 'textarea#richtextbox0',
                min_height:150
                }

                $.extend(additionalConfig, {!! json_encode($options->tinymceOptions ?? '{}') !!})

                tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
            }

           */
        });
    </script>
@endpush
