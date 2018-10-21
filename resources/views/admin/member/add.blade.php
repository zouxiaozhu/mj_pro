
@include('common.header')
<link href="{{url('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet" />
<script src="{{url('assets/js/bootstrap-fileupload.js')}}"></script>
<script src="{{url('assets/js/jquery.metisMenu.js')}}"></script>

@section('titlebar')
    @parent
@endsection

@section('sidebar')
    @parent
@endsection

    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-head-line"> 会员信息管理 >>  会员{{$member_id ? "更新" :'添加'}}&nbsp;&nbsp;</h1>
                    <h1 class="page-subhead-line">This is dummy text , you can replace it with your original text. </h1>
                </div>
            </div>
            <!-- /. ROW  -->
            <div class="row" id="member-vue">
                <div class="col-md-12 col-sm-12 col-xs-12   ">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            会员{{$member_id ? "更新" :'添加'}}&nbsp;&nbsp;
                            <span >(<span style="color: red">*</span>)为必填</span>
                        </div>
                        <div class="panel-body">
                            <form role="form">
                                <div class="form-group">
                                    <label>姓名(<span style="color: red">*</span>)</label>
                                    <input class="form-control" type="text" v-model="member_name" :readonly="readonly">
                                    {{--<p class="help-block">(<span style="color: red">*</span>)为必填</p>--}}
                                </div>
                                <div class="form-group">
                                    <label>联系方式(<span style="color: red">*</span>)</label>
                                    <input class="form-control" type="text" v-model="tel">
                                </div>
                                <div class="form-group">
                                    <label>电子邮箱</label>
                                    <input class="form-control" type="text" v-model="email">
                                </div>
                                <div class="form-group " v-show="member_id == ''">
                                    <label>介绍人</label>
                                        <input class="form-control"  type="text" v-model="refer_user">
                                </div>

                                <div class="form-group">
                                    <label>用户状态</label>
                                    <div class="radio" style="display: inline-block;margin-left: 1rem">
                                        <label>
                                            <input type="radio" value="1" name="enabled" v-model="enabled">启用
                                        </label>
                                    </div>
                                    <div class="radio" style="display: inline-block;margin-left: 1rem">
                                        <label>
                                            <input type="radio" value="0"  v-model="enabled">禁用
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>头像上传</label>
                                    <div class="col-xs-offset-4">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-preview thumbnail"
                                                 style="width: 300px; height: 185px;line-height: 225px !important;"></div>
                                            <div>
                                                <span class="btn btn-file btn-success col-xs-offset-1">
                                                <span class="fileupload-new col-xs-offset-1">Select image</span>
                                                <span class="fileupload-exists col-xs-offset-1">Change</span><input type="file"></span>
                                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="form-group">--}}
                                    {{--<label>Text area</label>--}}
                                    {{--<textarea class="form-control" rows="3"></textarea>--}}
                                {{--</div>--}}
                                <button type="button" @click="submitMember" class="btn btn-bg btn-info">提交 </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    new Vue({
        el : "#member-vue",
        data:{
            readonly : "{{$member_id}}" !== '',
            member_id : "{{$member_id}}",
            add_member_url :'/api/member/add',
            enabled : "{{$member_info['enabled'] === null ? 1 : $member_info['enabled']}}",
            member_name : "{{$member_info['member_name']}}",
            refer_user : '',
            refer_user_id : 0,
            address:"{{$member_info['address']}}",
            tel : "{{$member_info['tel']}}",
            email :  "{{$member_info['email']}}",
            error_msg : {
                member_name : '会员名称不能为空',
                tel : '联系方式不能为空'
            }
        },
        methods:{
            submitMember:function(){
                var member_info = {
                    enabled : this.enabled,
                    member_name : this.member_name,
                    refer_user_id : this.refer_user_id,
                    address:this.address,
                    tel : this.tel,
                    email : this.email,
                    member_id : this.member_id
                }

                this.$http.post(this.add_member_url, member_info, {emulateJSON: true})
                .then(function (data) {
                    if (data.body.status) {
                        layer.alert(data.body.msg)
                        setTimeout(this.reloadPage, 1000)
                        return ;
                    } else {
                        console.log(data.body.msg)
                        layer.alert(data.body.msg)
                    }
                }, function (response) {
                }).then(function () {

                })
            },
            reloadPage: function(){
                window.location.reload();
            },
            checkMemberInfo:function (member_info) {
                if (!member_info['member_name']) {
                    layer.alert(this.error_msg['member_name'])
                    return false
                }

                if (!member_info['tel']) {
                    layer.alert(this.error_msg['tel'])
                    return false
                }
            }

        },
        created:function () {
            console.log('init vue by member-vue')
        }
    })

</script>

