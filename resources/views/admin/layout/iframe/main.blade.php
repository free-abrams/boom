<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>H+ 后台主题UI框架 - 空白页</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

    <link rel="shortcut icon" href="favicon.ico"> <link href="{{asset('admin/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('admin/css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">

    <link href="{{asset('admin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style.css?v=4.1.0')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin/js/plugins/layui/css/layui.css')}}">

</head>

<body class="gray-bg">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{$data['title']}}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('index')}}">主页</a>
                </li>
                <li>
                    <strong>{{$data['title']}}</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <table id="data" lay-filter="data" class="col-sm-12"></table>
            <div class="col-sm-12">
                <div class="middle-box text-center animated fadeInRightBig">

                </div>
            </div>
        </div>
    </div>

    <!-- 全局js -->
    <script src="{{asset('admin/js/jquery.min.js?v=2.1.4')}}}"></script>
    <script src="{{asset('admin/js/bootstrap.min.js?v=3.3.6')}}}"></script>

    <!-- 自定义js -->
    <script src="{{asset('admin/js/content.js?v=1.0.0')}}}"></script>
    <script src="{{asset('admin/js/plugins/layui/layui.js')}}"></script>

{{--    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>--}}
    <!--统计代码，可删除-->
@yield('script')
</body>

</html>
