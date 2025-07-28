<?php $cssjsVersion = version(); ?>
<script>
    var globalSiteUrl = '<?php echo $path = url('/'); ?>'
    const serverEnvironment = '<?php echo env('APP_ENV'); ?>'
    const currentRouteName = '<?php echo request()->route()->getName(); ?>'
     var defaultImage = '<?php echo defaultImage(); ?>'
</script>
<script src="{{ asset('backend/assets/js/jquery-3.5.1.slim.min.js') }}?v=<?php echo $cssjsVersion; ?>"
        type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}?v=<?php echo $cssjsVersion; ?>"
        type="text/javascript"></script>
<script src="{{ asset('backend/assets/plugin/dataTables/jquery.dataTables.min.js') }}?v=<?php echo $cssjsVersion; ?>"
        type="text/javascript"></script>
<script src="{{ asset('backend/assets/plugin/dataTables/dataTables.bootstrap4.min.js') }}?v=<?php echo $cssjsVersion; ?>"
        type="text/javascript"></script>
<script src="{{ asset('backend/assets/plugin/tablestack/tablestack.js') }}?v=<?php echo $cssjsVersion; ?>"
        type="text/javascript"></script>
<script src="{{ asset('backend/assets/plugin/select2/select2.min.js') }}?v=<?php echo $cssjsVersion; ?>"
        type="text/javascript"></script>
<script src="{{ asset('backend/assets/js/jquery.fancybox.min.js') }}?v=<?php echo $cssjsVersion; ?>"
        type="text/javascript"></script>
<script src="{{ asset('backend/assets/plugin/daterangepicker/moment.min.js') }}?v={{version()}}"
        type="text/javascript"></script>
<script src="{{ asset('backend/assets/plugin/daterangepicker/daterangepicker.js') }}?v={{version()}}"
        type="text/javascript"></script>        
<script src="{{ asset('backend/assets/js/readmore.min.js') }}?v=<?php echo $cssjsVersion; ?>" type="text/javascript"></script>
<script src="{{ asset('backend/assets/js/jquery.validate.min.js') }}?v=<?php echo $cssjsVersion; ?>" type="text/javascript"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}?v=<?php echo $cssjsVersion; ?>"></script>
<script src="{{ asset('backend/assets/js/scripts.js') }}?v=<?php echo $cssjsVersion; ?>" type="text/javascript"></script>
<script src="{{ asset('backend/admin/js/fetchLocation.js') }}?v=<?php echo $cssjsVersion; ?>" type="text/javascript"></script>


@yield('pagescript')
