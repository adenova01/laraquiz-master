<textarea class="form-control richTextBox" name="{{ $row->field }}" id="paragraph_quest">
    {{ old($row->field, $dataTypeContent->{$row->field} ?? '') }}
</textarea>

@push('javascript')
    <script>
        
        $(document).ready(function() {
            //create_tinymce('richtextbox_1');
            var additionalConfig = {
                selector: 'textarea#paragraph_quest',
                min_height:150
            }

            $.extend(additionalConfig, {!! json_encode($options->tinymceOptions ?? '{}') !!})

            tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
           
        });
    </script>
@endpush
