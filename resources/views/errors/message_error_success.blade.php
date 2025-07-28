@if(\Illuminate\Support\Facades\Session::get('success'))
<div class="alert alert-success alert_message" role="alert" id="idAlertSuccessMsg">
    <button aria-label="Close" class="close closeSuccess" data-dismiss="alert"  type="button"><span aria-hidden="true">×</span></button>
    <strong>Success!</strong> {{\Illuminate\Support\Facades\Session::get('success')}}
</div>
{{ \Illuminate\Support\Facades\Session::forget('success') }}

@if(\Illuminate\Support\Facades\Session::get('error'))
{{\Illuminate\Support\Facades\Session::forget('error')}}
@endif
@endif
@if(\Illuminate\Support\Facades\Session::get('error'))
<div class="alert alert-danger alert_message" role="alert" id="idAlertErrorMsg">
    <button aria-label="Close" class="close closeError" data-dismiss="alert"  type="button"><span aria-hidden="true">×</span></button>
    <strong>Error!</strong> {{\Illuminate\Support\Facades\Session::get('error')}}
</div>
{{\Illuminate\Support\Facades\Session::forget('error')}}
@endif

@if(\Illuminate\Support\Facades\Session::get('warning'))
    <div class="alert alert-warning alert_message" role="alert" id="idAlertSuccessMsg">
{{--        <button aria-label="Close" class="close closeWarning" data-dismiss="alert"  type="button"><span aria-hidden="true">×</span></button>--}}
        <strong>Warning!</strong> {{\Illuminate\Support\Facades\Session::get('warning')}}
    </div>
    {{ \Illuminate\Support\Facades\Session::forget('warning') }}
@endif
