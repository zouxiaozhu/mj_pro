<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="{{url('css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{url('css/simple-line-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{url('css/app.css')}}" type="text/css" />
    <link href="{{url('js/layer/theme/default/layer.css')}}" rel="stylesheet" type="text/css" />
</head>
<body background="{{url('images/bodybg.jpg')}}">
<canvas id="canvas" style="position: absolute;left: 0px;top: 0px;z-index: 0;" width="1815" height="658"></canvas>
<div id="wrapper" style="position: absolute;left: 50%;top: 50%;z-index: 1;transform: translate(-50%, -50%)">
    <section id="content" class="m-t-lg wrapper-md animated fadeInUp ">
        <div class="container aside-xl" style="margin-top: 48px;">
            <a class="navbar-brand block"><span class="h1 font-bold" style="color: #ffffff">管理员登录</span></a>
            <section class="m-b-lg">
                <header class="wrapper text-center">
                    <strong class="text-success">管理员登录</strong>
                </header>
                <form action="javascript:;" method="post" >
                    <div class="form-group">
                        <input type="text" v-model="name" placeholder="用户名" class="form-control  input-lg text-center no-border">
                    </div>
                    <div class="form-group">
                        <input :type="password_type" v-model="password" placeholder="密码" class="form-control  input-lg text-center no-border">
                    </div>

                    <button type="button" @click="login" class="btn btn-lg btn-success lt b-b b-2x btn-block" >
                        {{--icon-arrow-right--}}
                        <i class=" pull-right"></i><span >登录</span></button>
                </form>
            </section>
        </div>
    </section>
</div>
</body>
</html>
<script src="{{url('js/vue.min.js')}}"></script>
<script src="{{url('js/jquery-1.10.1.min.js')}}"></script>
<script src="{{url('js/bootstrap.js')}}"></script>
<script src="{{url('js/vue-resource.js')}}"></script>
<script src="{{url('js/layer/layer.js')}}"></script>
<script src="http://cp.ceshi.che300.com/js/canvas.js"></script>
<script>
    var Vue = new Vue({
        el:"#wrapper",
        data :{
            password_type:'password',
            password :'',
            name:'',
            remember:false,
            error_msg :{
                password : "密码不合法",
                name : "姓名不合法"
            },
            login_url:'/api/auth/login'
        },
        methods:{
            login:function () {
                var user_info = {
                    name : this.name,
                    password : this.password,
                    remember : this.remember
                };

                if ( this.checkUserInfo(user_info) === false) {
                    return;
                }
                console.log(user_info)
                this.$http.post(this.login_url, user_info, {emulateJSON: true})
                    .then(function (data) {
                        if (data.body.status) {
                            window.location.href = '/api/service/home';
                            return true
                        } else {
                            layer.alert(data.body.msg)
                            return false
                        }
                    }, function (response) {
                        layer.alert(data.body.msg)
                        return false
                    })
            },
            checkUserInfo(user_info) {
                if (!user_info.name) {
                    layer.alert(this.error_msg['name'])
                    return false
                }

                if (!user_info.password || user_info.password.length < 6) {
                    layer.alert(this.error_msg['password'])
                    return false
                }
            }
        },
        created:function () {
            console.log('vue init')
        }
    })
</script>
