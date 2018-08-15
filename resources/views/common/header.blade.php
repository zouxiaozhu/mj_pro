<?php
    $user_info = auth()->user();
    $session_info = session()->all();
?>
<?php //echo json_encode($session_info['nav_infos']);die;?>

<html>
<head>
    <link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="{{url('assets/css/font-awesome.css')}}" rel="stylesheet" />
    <link href="{{url('assets/css/basic.css')}}" rel="stylesheet" />
    <link href="{{url('assets/css/custom.css')}}" rel="stylesheet" />
    <script src="{{url('js/canvas.js')}}" type="text/javascript"> </script>
    <link href="{{url('js/layer/theme/default/layer.css')}}" rel="stylesheet" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="{{url('assets/js/jquery-1.10.2.js')}}"></script>
    <script src="{{url('assets/js/bootstrap.js')}}"></script>
    <script src="{{url('assets/js/jquery.metisMenu.js')}}"></script>
    <script src="{{url('assets/js/custom.js')}}"></script>
    <script src="{{url('js/vue.min.js')}}"></script>
    <script src="{{url('js/jquery-1.10.1.min.js')}}"></script>
    <script src="{{url('js/bootstrap.js')}}"></script>
    <script src="{{url('js/vue-resource.js')}}"></script>
    <link href="{{url('js/layer/theme/default/layer.css')}}" rel="stylesheet" type="text/css" />

    <script src="{{url('js/layer/layer.js')}}"></script>
</head>
<body>

<div id="wrapper" >
    @section('titlebar')
        <div class="title" id="el-title">
            <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="">{{env("COMPANY_NAME")}}</a>
                </div>

                <div class="header-right">
                    <a class="btn btn-info" title="New Message"><b>订单总数（30） </b><i class="fa fa-envelope-o fa-2x"></i></a>
                    <a class="btn btn-primary" title="New Task"><b>新订单数（30）</b><i class="fa fa-bars fa-2x"></i></a>
                    <a class="btn btn-danger" title="Logout" @click="logOut">退出
                        <i class="fa fa-flash "></i>
                        {{--<i class="fa fa-exclamation-circle fa-2x"></i>--}}
                    </a>
                </div>
            </nav>
        </div>
    @show

    @section('sidebar')
        <div class="siderbar">
            <nav class="navbar-default navbar-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">
                        <li>
                            <div class="user-img-div">
                                <img src="http://img1.mukewang.com/55eb957f0001bb6701000100-100-100.jpg" class="img-thumbnail"  />
                                <div class="inner-text">
                                   {{$user_info['name']}}
                                    <br />
                                    <small>{{ date('Y年m月d日 H:i:s', $user_info['last_login_time']) }} </small>
                                </div>
                            </div>
                        </li>
                        @foreach((array)$session_info['nav_infos'] as $nav)
                        <li>
                            <a href="{{ $nav['url']?url($nav['url']):'#' }}" >
                                <i class="fa fa-sitemap "></i>
                                {{$nav['name']}}
                                <span class="fa arrow"></span>
                            </a>
                            @if(isset($nav['childs']))
                            @foreach((array)$nav['childs'] as $c_nav)
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ $c_nav['url']? url($c_nav['url']):'#' }}">
                                        <i class="fa fa-bicycle "></i>
                                        {{$c_nav['name']}} </a>
                                </li>
                            </ul>
                            @endforeach
                            @endif
                        </li>
                        @endforeach
                        <li>
                            <a href="blank.html"><i class="fa fa-square-o "></i>Blank Page</a>
                        </li>
                    </ul>

                </div>

            </nav>
        </div>

    @show
        @yield('content')

</div>
</body>
</html>
<script>
    var HVue = new Vue({
        el :'#el-title',
        data :{
            log_out_url : '/api/auth/logout',
            all_order_counts :0,
            unread_order_counts:0
        },
        methods:{
            logOut : function(){
                this.$http.get(this.log_out_url)
                    .then(function (data) {
                        if (data.body.status) {
                            window.location.href = '/api/service/in';
                            return true
                        } else {
                            layer.alert(data.body.msg)
                            window.location.href = '/api/service/in';
                            return true
                        }
                    }, function (response) {
                        window.location.href = '/api/service/in';
                        return false
                    })
            },
        },
        created:function(){

        }
    })

</script>

