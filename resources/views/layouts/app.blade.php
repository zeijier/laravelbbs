{{--获取语言--}}
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--csrf token --}}
    <meta name="csrf-token" content="{{csrf_token()}}">
    {{--@yield('title', 'LaraBBS') 继承此模板的页面，如果没有定制 title 区域的话，就会自动使用第二个参数 LaraBBS 作为标题前缀。--}}
    <title>@yield('title','laravelBBS')--!!</title>
    <meta name="description" content="@yield('description','laravelBBS 爱好者社区')">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    @yield('styles')
</head>
<body>
{{--route_class 是自定义的辅助方法--}}
<div id="app" class="{{route_class()}}-page">
    @include('layouts._header')
    <div class="container">
        @include('layouts._message')
        @yield('content')
    </div>
    @include('layouts._footer')
</div>
<script src="{{asset('js/app.js')}}"></script>
@yield('scripts')
</body>
</html>