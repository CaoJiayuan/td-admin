<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/element.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('inspinia/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('inspinia/css/data-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/metisMenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('webuploader/webuploader.css') }}">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>
</body>
<script src="{{ asset('js/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('js/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/echarts.common.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('inspinia/js/inspinia.js') }}"></script>
<script src="{{ mix('/js/manifest.js') }}"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/pace.min.js') }}"></script>

<script>
    $(function () {
        setTimeout(function () {
            $('#side-menu').metisMenu();
        },1000)
    });
</script>
</html>