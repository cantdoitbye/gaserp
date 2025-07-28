@php
    $currentRoute=request()->route()->getName();
@endphp
<div class="mt-3 text-center-mobile">
    @if(!isset(request()->deleted))
        <a href="{{route($currentRoute,['deleted'=>1,'type'=>request()->type])}}"
           class="btn btn-danger deletedBtn mw-205 btn-loader">{{$deleted_text}} (<span
                id="deletedRecord"></span>)</a>
    @else
        <a href="{{route($currentRoute,['type'=>request()->type])}}"  class="btn btn-danger deletedBtn mw-205 btn-loader">Back</a>
        <?php $deleted_text = "Back"; ?>
    @endif
</div>

