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
        <div class="row" id="order-consume">
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
                                                <input type="radio" name="business_type" :value="item.business_type"
                                                       v-model="current_type"
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
                                                <th>会员卡号</th>
                                                <th>剩余次数</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="package in current_packages">
                                                <td><input type="radio" :value="package.card_no" v-model="card_no"
                                                           name="packages"></td>
                                                <td>@{{package.card_no}}</td>
                                                <td>@{{package.m_counts}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12">备注</label>
                                <div class="col-sm-12">
                                    <input type="text" id="comment" v-model="comment" class="form-control"
                                           placeholder="订单备注"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>&nbsp;</label>
                            </div>

                            <div class="form-group">
                                <button type="button" @click="submitOrder" class="btn btn-bg btn-info col-xs-offset-5">
                                    提交
                                </button>

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
        el: "#order-consume",
        data: {
            member_id: 0,
            user_prop: '',
            search_user_url: '/api/member/has-order',
            business_url: '/api/package/business',
            package_url: '/api/package/list',
            consume_order_url: '/api/order/consumer',
            tel: '',
            business_info: [],
            current_type: 0,
            current_packages: [],
            package_id: 0,
            package_list: [],
            counts: 0,
            discount: 0,
            comment: '',
            card_no:0
        },
        methods: {
            submitOrder: function () {
                if (!this.member_id) {
                    layer.alert("先选择用户");
                    return false;
                }
                if (!this.card_no) {
                    layer.alert("请选择扣除的会员套餐");
                    return false;
                }
                let me = this
                layer.confirm("确定提交吗？", function () {
                    var adddata = {
                        'member_id': me.member_id,
                        'card_no': me.card_no,
                        'comment': me.comment
                    }
                    me.$http.post(me.consume_order_url, adddata, {emulateJSON: true})
                        .then(function (data) {
                            if (data.body.status) {
                                layer.alert(data.body.msg)
                                return false;
                            } else {
                                layer.alert("添加失败，请重试")
                                return false;
                            }

                        }, function (response) {
                        })
                });
            },
            changeCurrent: function (current_type) {
                this.current_packages = this.package_list[current_type];
                this.card_no = 0;
            },
            businessInfo: function () {
                let me = this
                this.$http.get(this.business_url)
                    .then(function (data) {
                        me.business_info = data.body.data
                        if (me.current_type == 0) {
                            me.current_type = me.business_info[1].business_type;
                            me.current_packages = me.package_list[me.current_type];
                        } else {
                            me.current_packages = me.package_list[me.current_type];
                        }
                    }, function (response) {
                    })
            },
            searchUser: function () {
                this.$http.post(this.search_user_url, {user_prop: this.user_prop,}, {emulateJSON: true})
                    .then(function (data) {
                        if (!data.body.status) {
                            layer.alert(data.body.msg)
                            this.user_prop = '';
                            return false;
                        } else {
                            // count = data.body.data.package ? data.body.data.package.counts : 0
                            // amount = data.body.data.package ? data.body.data.package.amount : 0
                            layer.alert(
                                '用户姓名 : ' + data.body.data.user_info.member_name + "<br/>" +
                                "手机号码 : " + data.body.data.user_info.tel + "<br/>" +
                                "注册时间 : " + data.body.data.user_info.created_at + "<br/>"
                                // "套餐次数 : " + count + "<br/>" +
                                // "账户余额 : " + amount + "<br/>"
                            )
                            this.member_id = data.body.data.user_info.id
                            this.tel =  data.body.data.user_info.tel
                            this.package_list = data.body.data.member_pkg
                            this.businessInfo()
                            return false;
                        }
                    }, function (response) {
                    }).then(function () {

                }).then(this.packageList)
            }
        },
        created: function () {
        }
    })


</script>