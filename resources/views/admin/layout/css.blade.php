<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
<meta name="description" content=""/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="author" content=""/>
<title> {{ env('APP_NAME') }} </title>

<link rel="icon" href="{{url('/')}}/assets/img/favicon/cropped-favicon-32x32.png" sizes="32x32"/>
<link rel="icon" href="{{url('/')}}/assets/img/favicon/cropped-favicon-192x192.png" sizes="192x192"/>
<link rel="apple-touch-icon" href="{{url('/')}}/assets/img/favicon/cropped-favicon-180x180.png"/>
<meta name="msapplication-TileImage" content="{{url('/')}}/assets/img/favicon/cropped-favicon-270x270.png"/>

{{--<link href="{{url('/')}}/backend/assets/images/favicon.png" rel="icon">--}}
<?php $cssjsVersion = version(); ?>

{{-- <link href="{{ asset('/assets/fonts/lato/stylesheet.css') }}?v=<?php echo $cssjsVersion; ?>" rel="stylesheet" type="text/css"/> --}}
{{-- <link href="{{ asset('/assets/fonts/work-sans/stylesheet.css') }}?v=<?php echo $cssjsVersion; ?>" rel="stylesheet" type="text/css"/> --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="{{ asset('backend/assets/font/fontawesome/css/all.min.css') }}?v=<?php echo $cssjsVersion; ?>" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('backend/assets/plugin/daterangepicker/daterangepicker.css') }}?v={{version()}}" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('backend/assets/font/Hatton/stylesheet.css') }}?v=<?php echo $cssjsVersion; ?>" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('backend/assets/plugin/dataTables/dataTables.bootstrap4.min.css') }}?v=<?php echo $cssjsVersion; ?>"
      rel="stylesheet" type="text/css"/>
<link href="{{ asset('backend/assets/plugin/select2/select2.min.css') }}?v=<?php echo $cssjsVersion; ?>" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('backend/assets/plugin/tablestack/tablestack.css') }}?v=<?php echo $cssjsVersion; ?>" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('backend/assets/css/jquery.fancybox.min.css') }}?v=<?php echo $cssjsVersion; ?>" rel="stylesheet"
      type="text/css"/>
<link href="{{ asset('assets/css/sweetalert.min.css') }}?v=<?php echo $cssjsVersion; ?>" rel="stylesheet" />
<link href="{{ asset('backend/assets/css/styles.css') }}?v=<?php echo $cssjsVersion; ?>" rel="stylesheet" type="text/css"/>
@yield('pagecss')
