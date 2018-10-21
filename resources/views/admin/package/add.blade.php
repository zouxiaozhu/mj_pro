
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
                    <h1 class="page-head-line"> 套餐管理 >>  套餐{{$id ? "更新" :'添加'}}&nbsp;&nbsp;</h1>
                    <h1 class="page-subhead-line">This is dummy text , you can replace it with your original text. </h1>
                </div>
            </div>
            <!-- /. ROW  -->
            <div class="row" id="pkg-vue">
                <div class="col-md-12 col-sm-12 col-xs-12   ">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            套餐{{$id ? "更新" :'添加'}}&nbsp;&nbsp;
                            <span >(<span style="color: red">*</span>)为必填</span>
                        </div>
                        <div class="panel-body">
                            <form role="form">
                                <div class="form-group">
                                    <label>套餐名(<span style="color: red">*</span>)</label>
                                    <input class="form-control" type="text" v-model="name"  >
                                    {{--<p class="help-block">(<span style="color: red">*</span>)为必填</p>--}}
                                </div>
                                <div class="form-group">
                                    <label>原价(<span style="color: red">*</span>)</label>
                                    <input class="form-control" type="text" v-model="origin_price">
                                </div>


                                <div class="form-group">
                                    <label>套餐类型</label>
                                    <div class="radio" style="display: inline-block;margin-left: 1rem">
                                        <span v-for="item in business_info">
                                            <label style="margin-left: 2rem">
                                                <input type="radio" name="business_type" :value="item.business_type"
                                                       v-model="business_type" > @{{item.msg}}
                                            </label>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>次数</label>
                                    <input class="form-control" type="text" v-model="counts">
                                </div>

                                <div class="form-group">
                                    <label>折扣</label>
                                    <input class="form-control" type="text" v-model="discount">
                                </div>

                                <div class="form-group">
                                    <label>折合单价</label>
                                    <input class="form-control" type="text" v-model="price">
                                </div>

                                <div class="form-group">
                                    <label>套餐状态</label>
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
                                <button type="button" @click="submitPkg" class="btn btn-bg btn-info">提交 </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    new Vue({
        el : "#pkg-vue",
        data:{
            origin_price:'',
            name :'',
            discount:'',
            counts:'',
            business_type: 0,
            price:'',
            pkg_id : "{{$id ?: 0}}",
            add_pkg_url :'/api/package/add',
            detail_pkg_url :'/api/package/package/',
            business_url :'/api/package/business',
            enabled : 1,
            business_info : []
        },
        methods:{
            submitPkg:function(){
                var pkg_info = {
                    origin_price: this.origin_price,
                    name : this.name,
                    discount: this.discount,
                    counts: this.counts,
                    business_type: this.business_type,
                    price:this.price,
                    id : this.pkg_id,
                }

                this.$http.post(this.add_pkg_url, pkg_info, {emulateJSON: true})
                .then(function (data) {
                    if (data.body.status) {
                        layer.alert(data.body.msg)
                        return false;
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
            },
            pkgInfo : function(id){
                if (!id) {
                    return false
                }

                let me = this
                this.$http.get(this.detail_pkg_url + id).then(function (data) {
                    if (data.body.status) {
                        $.each(data.body.data, function(i, item){
                            me[i] = item
                        })
                        return false
                    } else {
                        layer.alert(data.body.msg)
                        return false
                    }
                }, function (response) {
                }).then(function () {

                })
            },
            buinessInfo : function () {
                let me = this
                this.$http.get(this.business_url)
                    .then(function(data){
                        me.business_info = data.body.data
                }, function(response){})
            }
        },
        created:function () {
            id = this.pkg_id
            this.pkgInfo(id)
            this.buinessInfo()
        }
    })
</script>

