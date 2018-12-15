<style>
    .page-bar {
        margin-top: 21px;
        margin-left: 11%;
    }

    .page-bar ul,
    .page-bar li {
        margin: 0px;
        padding: 0px;
    }

    .page-bar ul li {
        list-style: none;
        border: 1px solid #ddd;
        text-decoration: none;
        font-weight: bolder;
        position: relative;
        float: left;
        text-align: center;
        padding: 1px 0;
        margin-left: 4px;
        line-height: 1.7;
        color: #337ab7;
        cursor: pointer;
        width: 2%;
    }

    .page-bar li:first-child > a {
        margin-left: 0px
    }

    .page-bar .active a {
        color: #fff;
        cursor: default;
        background-color: cornflowerblue;
        border-color: #337ab7;
    }

    .page-bar i {
        font-style: normal;
        color: #d44950;
        margin: 0px 4px;
        font-size: 12px;
    }
</style>
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
<div id="wrapper">
    <span id="order-list">
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="display: flex;">
                            <div style="flex: 1;">
                              <span>
                                <span>订单信息</span>
                                </span>

                            </div>
                            <div style="flex: 1;">
                                <lable>
                                    手机号
                                </lable>
                                <input type="text" name="tel" v-model="tel" @change="flushList">

                            </div>

                              <div style="flex: 1;">
                                <lable>
                                    用户名
                                </lable>
                                <input type="text" name="member_name" v-model="member_name" @change="flushList">

                            </div>

                            <div style="flex: 1;text-align: center">
                                  <lable>
                                    充值/消费
                                </lable>
                                <select name="type" v-model="type" @change="flushList">
                                        <option value="0">--无--</option>
                                        <option value="1">--充值--</option>
                                        <option value="2">--消费--</option>
                                </select>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>编号</th>
                                        <th>会员姓名</th>
                                        <th>消费类型</th>
                                        <th>套餐名称</th>
                                        <th>套餐类型</th>
                                        <th>折合单价</th>
                                        <th>备注</th>
                                        {{--<th>管理员</th>--}}
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $style = ['info', 'warning',];shuffle($style);?>
                                    <tr class="{{($style)[0]}}" v-for="order in order_list">
                                            <td>@{{ order.id }}</td>
                                            <td>@{{ order.member.member_name }}</td>
                                            <td>@{{ order.cost_type  == 1 ? '充值' : '消费' }}</td>
                                            <td>@{{ order.package.name}}</td>
                                            <td>@{{ order.package.business_type }}</td>
                                            <td>@{{ order.package.price }}</td>
                                            <td>@{{ order.comment}}</td>
                                        {{--<td>@{{ order.comment}}</td>--}}
                                        <td>
                                                <i class="fa fa fa-recycle" title="删除" @click="deleteOrder(order.id)"
                                                   style="margin-left: 20px"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="page-bar">
            <ul>
                <li style="width:3%" v-if="showFirst">
                    <a v-on:click="pageDec(cur)">
                        <<</a>
                </li>
                <li v-for="index in indexs" v-bind:class="{ 'active': cur == index}">
                    <a v-on:click="btnClick(index)">@{{index}}</a>
                </li>
                <li style="width:4%" v-if="showLast"><a v-on:click="pageInc(cur)"> >></a></li>
                <li style="width:8%;margin-left:3%"><a>共<i>@{{all}}</i>页</a></li>
            </ul>
        </div>
        </div>
    </div>
    </span>
</div>


<script>
    var OrderVue = new Vue({
        el: '#order-list',
        data: {
            order_list_url: '/api/order/list',
            order_delete_url: '/api/order/delete',
            order_list: [],
            list: [],
            all: 1, //总页数
            cur: 1, //当前页码,
            member_name: '',
            enabled: '',
            type: 0,
            tel: ''
        },
        methods: {
            deleteOrder: function (member_id) {
                this.$http.get(this.order_delete_url + '?member_id=' + order_id).then(function (data) {
                    if (!data.body.status) {
                        layer.alert(data.body.msg)
                    } else {
                        for (var i = 0; i < this.member_list.length; i++) {
                            if (this.member_list[i]['id'] == member_id) {
                                this.member_list.splice(i, 1)
                            }
                        }
                        layer.alert(data.body.msg)
                    }
                }, function () {

                })
            },
            flushList: function () {
                this.orderList({
                    page: this.cur,
                    tel: this.tel,
                    member_name: this.member_name,
                    enabled: this.enabled,
                    type: this.type
                });
            },
            pageDec: function (cur) {
                var page = --cur;
                this.orderList({page: page})
                return page;
            },
            pageInc: function (cur) {
                var page = ++cur;
                this.orderList({page: page})
                return page
            },
            btnClick: function (items) { //页码点击事件
                this.orderList({page: items})
            },
            orderList: function (params) {
                query_str = '?a=1';
                if (params && params.hasOwnProperty('page')) {
                    query_str = query_str + '&page=' + params.page;
                }

                if (this.enabled !== '') {
                    query_str = query_str + '&enabled=' + params.enabled;
                }

                if (this.tel) {
                    query_str = query_str + '&tel=' + this.tel;
                }

                if (this.member_name) {
                    query_str = query_str + '&member_name=' + this.member_name;
                }

                if (this.type) {
                    query_str = query_str + '&type=' + this.type;
                }

                this.$http.get(this.order_list_url + query_str).then(function (data) {
                    if (!data.body.status) {
                        this.all = this.cur = 0;
                        this.order_list = [];
                        layer.alert(data.body.msg)
                    } else {
                        var return_data = data.body.data;
                        this.order_list = return_data.order_list
                        this.all = return_data.all_pages;
                        this.cur = return_data.cur_page;
                        console.log(return_data)
                    }
                }, function () {

                })
            }
        },

        computed: {
            indexs: function (index) {
                var left = 1;
                var right = this.all;
                var ar = [];
                if (this.all >= 11) {
                    if (this.cur > 5 && this.cur < this.all - 4) {
                        left = this.cur - 5;
                        right = this.cur + 4;
                    } else {
                        if (this.cur <= 5) {
                            left = 1;
                            right = 10;
                        } else {
                            right = this.all;
                            left = this.all - 9;
                        }
                    }
                }
                while (left <= right) {
                    ar.push(left);
                    left++;
                }
                return ar;
            },
            showLast: function () {
                if (this.cur == this.all) {
                    return false
                }
                return true
            },
            showFirst: function () {
                if (this.cur == 1) {
                    return false
                }
                return true
            }
        },
        watch: {
            cur: function (oldValue, newValue) {
                console.log(arguments)
            }
        },

        created: function () {
            this.orderList()
        }
    })
</script>