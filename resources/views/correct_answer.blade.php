<br>
{{--<?php $checked = false; ?>
@if(isset($dataTypeContent->{$row->field}) || old($row->field))
    <?php $checked = old($row->field, $dataTypeContent->{$row->field}); ?>
@else
    <?php $checked = isset($options->checked) &&
        filter_var($options->checked, FILTER_VALIDATE_BOOLEAN) ? true: false; ?>
@endif

<?php $class = $options->class ?? "toggleswitch"; ?>

@if(isset($options->on) && isset($options->off))
    <input type="checkbox" name="{{ $row->field }}[]" class="{{ $class }}"
        data-on="{{ $options->on }}" id="correct_answer1" value="{{$options->on}}" {!! $checked ? 'checked="checked"' : '' !!}
        data-off="{{ $options->off }}">
@else
    <input type="checkbox" name="{{ $row->field }}[]" class="{{ $class }}" value="{{$options->on}}"
        @if($checked) checked @endif>
@endif--}}

<?php $checked = false; ?>
<?php $checked = old($row->field, $dataTypeContent->{$row->field}); ?>

<?php $checked = $dataTypeContent->correct_answer!=0 ? true : false?>
@if (isset($edit))
    @if ($checked)
        <input type="checkbox" class="checkbox_answer" name="{{ $row->field }}[]" value="1" @if($checked) checked @endif><label for="name">This Options Correct Answer</label>    
    @else
        <input type="hidden" class="hidden_check" name="{{ $row->field }}[]" value="0">
        <input type="checkbox" class="checkbox_answer" name="{{ $row->field }}[]" value="1" @if($checked) checked @endif><label for="name">This Options Correct Answer</label>        
    @endif
@else
    <input type="hidden" class="hidden_check" name="{{ $row->field }}[0]" value="0">
    <input type="checkbox" class="checkbox_answer" name="{{ $row->field }}[0]" value="1" @if($checked) checked @endif><label for="name">This Options Correct Answer</label>
@endif



