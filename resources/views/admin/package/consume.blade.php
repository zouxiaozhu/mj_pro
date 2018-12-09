@include('common.header')
<link href="{{url('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet"/>
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
                <h1 class="page-head-line"> 订单信息管理 >> 订单创建&nbsp;&nbsp;</h1>
                <h1 class="page-subhead-line">This is order moudle , please attension. </h1>
            </div>
        </div>
        <!-- /. ROW  -->
        <div class="row" id="order-add">
            <div class="col-md-12 col-sm-12 col-xs-12   ">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        订单
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <input type="hidden" v-model="member_id">
                            <div class="form-group">
                                <label class="col-sm-12 ">手机号码/用户名</label>
                                <div class="col-sm-5">
                                    <input type="text"
                                           v-model="user_prop" class="form-control" placeholder="手机号码/用户名"/>
                                </div>
                                <button type="button" id="query-coins" v-on:click="searchUser" class="btn btn-primary">
                                    查询用户信息
                                </button>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12">联系方式</label>
                                <div class="col-sm-6">
                                    <input type="text" id="minus-coin-tel" v-model="tel" class="form-control"
                                           placeholder="只能输入一个手机号"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label>
                            </div>

                            <div class="form-group">
                                <label>套餐类型</label>
                                <div class="radio" style="display: inline-block;margin-left: 1rem">
                                        <span v-for="item in business_info">
                                            <label style="margin-left: 2rem">
                                                <input type="radio" name="business_type" :value="item.business_type" v-model="current_type"
                                                       v-on:click="changeCurrent(item.business_type)">
                                                @{{item.msg}}
                                            </label>
                                        </span>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>选择</th>
                                                <th>编号</th>
                                                <th>原价</th>
                                                <th>现价</th>
                                                <th>折扣</th>
                                                <th>次数</th>
                                                <th>管理员</th>
                                                <th>状态</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="package in current_packages">
                                                <td><input type="radio" value="package.id" name="packages"></td>
                                                <td>@{{package.id}}</td>
                                                <td>@{{package.origin_price}}</td>
                                                <td>@{{package.price}}</td>
                                                <td>@{{package.discount}}</td>
                                                <td>@{{package.counts}}</td>
                                                <td>@{{package.operate_user_id}}</td>
                                                <td>@{{package.enabled}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" @click="" class="btn btn-bg btn-info col-xs-offset-5">提交 </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var orderVue = new Vue({
        el: "#order-add",
        data: {
            member_id: 0,
            user_prop: '',
            search_user_url: '/api/member/search',
            business_url: '/api/package/business',
            package_url: '/api/package/list',
            submit_order_url: '/api/order/add',
            tel: '',
            business_info: [],
            current_type: 0,
            current_packages: [],
            package_id: 0,
            package_list: [],
            counts: 0,
            discount: 0
        },
        methods: {
            submitOrder: function () {
                if (!this.member_id) {
                    layer.alert("先选择用户");
                    return false;
                }

                layer.confirm("确定提交吗？", function () {

                });
            },
            changeCurrent:function(current_type){
                this.current_packages = this.business_info[current_type].packages;
                console.log(current_type)
            },
            businessInfo: function () {
                let me = this
                this.$http.get(this.business_url)
                    .then(function (data) {
                        me.business_info = data.body.data
                        if (me.current_type == 0) {
                            me.current_type = me.business_info[0].business_type;
                            me.current_packages = me.business_info[me.current_type].packages;
                        } else {
                            me.current_packages = me.business_info[me.current_type].packages;
                        }
                    }, function (response) {
                    })
            },
            packageList: function () {
                let me = this
                this.$http.get(this.package_url)
                    .then(function (data) {
                        me.package_list = data.body.data
                    }, function (response) {
                    })
            }
            ,
            searchUser: function () {
                this.$http.post(this.search_user_url, {user_prop: this.user_prop,}, {emulateJSON: true})
                    .then(function (data) {
                        if (!data.body.status) {
                            layer.alert(data.body.msg)
                            this.user_prop = '';
                            return false;
                        } else {
                            layer.alert(
                                '用户姓名 : ' + data.body.data.member_name + "<br/>" +
                                "手机号码 : " + data.body.data.tel + "<br/>" +
                                "注册时间 : " + data.body.data.created_at + "<br/>" +
                                "套餐次数 : " + data.body.data.package.counts + "<br/>" +
                                "账户余额 : " + data.body.data.package.amount + "<br/>"
                            )
                            this.member_id = data.body.data.id
                            this.tel = data.body.data.tel
                            this.package_list = data.body.data.packages

                        }
                    }, function (response) {
                    }).then(function () {

                }).then(this.packageList)
            }
        },
        created: function () {
            this.businessInfo()
            this.packageList()

        }
    })


</script>