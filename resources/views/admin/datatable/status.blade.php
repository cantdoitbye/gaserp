@php
    $checked = "";
    if ($status == 1) {
        $checked = "checked";
    }
@endphp

<div class="custom-control custom-switch" title="Block User">
    <input type="checkbox" class="custom-control-input changeStatus" id="checkbox-{{$model->id}}"
           data-id="{{$model->id}}" data-name="{{ $name??'' }}" {{ $checked }}>
    <label class="custom-control-label" for="checkbox-{{$model->id}}"></label>
</div>
