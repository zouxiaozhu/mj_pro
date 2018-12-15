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

    .page-bar li:first-child>a {
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
<link href="{{url('assets/css/bootstrap-fileupload.min.css')}}" rel="stylesheet" />
<script src="{{url('assets/js/bootstrap-fileupload.js')}}"></script>
<script src="{{url('assets/js/jquery.metisMenu.js')}}"></script>

@section('titlebar')
    @parent
@endsection

@section('sidebar')
    @parent
@endsection
<div id="wrapper">
    <span id="package-list">
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <span>套餐信息</span>
                        </div>
                        <div class="panel-heading ">

                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>编号</th>
                                        <th>类型</th>
                                        <th>原价</th>
                                        <th>折扣</th>
                                        <th>次数</th>
                                        {{--<th>管理员</th>--}}
                                        <th>状态</th>
                                        <th>创建时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $style = ['info', 'warning', ];shuffle($style);?>
                                        <tr class="{{($style)[0]}}" v-for="package in package_list">
                                            <td >@{{ package.id }}</td>
                                            <td>@{{ package.business_content }}</td>
                                            <td>@{{ package.origin_price }}</td>
                                            <td>@{{ package.price }}</td>
                                            <td>@{{ package.discount }}</td>
                                            <td>@{{ package.counts }}</td>
                                            <td>@{{ package.created_at }}</td>
                                            {{--<td>@{{ operate_users_info[member.operate_user_id]['name'] }}</td>--}}
                                            {{--<td>@{{ member.enabled == 1 ?'活跃' :'锁定'}}</td>--}}
                                            <td>
                                                <i class="fa fa-bars" @click="edit(package.id)" title="编辑"></i>
                                                <i class="fa fa-recycle " @click="deletePackage(package.id)" title="删除" style="margin-left: 20px"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="page-bar" >
            {{--<ul>--}}
                {{--<li style="width:3%" v-if="showFirst">--}}
                    {{--<a v-on:click="pageDec(cur)">--}}
                        {{--<<</a>--}}
                {{--</li>--}}
                {{--<li v-for="index in indexs" v-bind:class="{ 'active': cur == index}">--}}
                    {{--<a v-on:click="btnClick(index)">@{{index}}</a>--}}
                {{--</li>--}}
                {{--<li style="width:4%" v-if="showLast"><a v-on:click="pageInc(cur)"> >></a></li>--}}
                {{--<li style="width:5%;margin-left:3%"><a>共<i>@{{all}}</i>页</a></li>--}}
            {{--</ul>--}}
        </div>
        </div>
    </div>
    </span>
</div>


<script>
    var PkgVue = new Vue({
        el :'#package-list',
        data :{
            package_list_url : '/api/package/package',
            package_delete_url : '/api/package/delete',
            package_detail_url:'/api/service/add-package/',
            package_list : [],
            operate_users_info :{},
            list:[],
            all: 1, //总页数
            cur: 1, //当前页码,
            member_name:'',
            enabled:'',
            type:'',
            tel:''
        },
        methods : {
            edit:function(pkg_id) {
                window.location.href= this.package_detail_url + pkg_id
                return true;
            },
            deletePackage:function(pkg_id){
                this.$http.get(this.package_delete_url +'?id='+pkg_id).then(function (data) {
                    if (! data.body.status) {
                        layer.alert(data.body.msg)
                    } else {
                        for(var i = 0; i < this.package_list.length; i++){
                            if(this.package_list[i]['id'] == pkg_id) {
                                this.package_list. splice(i,1)
                            }
                        }
                        layer.alert(data.body.msg)
                    }
                }, function () {

                })
            },
            pageDec:function(cur) {
                var page = --cur;
                this.memberList({page : page})
                return page;
            },
            pageInc:function(cur) {
                var page = ++cur;
                this.memberList({page : page})
                return page
            },
            btnClick: function(items) { //页码点击事件
                this.memberList({page : items})
            },
            packageList : function(params){
                var  query_str = '?1=1'
                if (params && params.hasOwnProperty('page')) {
                    query_str = query_str + '&page=' +params.page;
                }

                if (this.enabled !== '') {
                    query_str = query_str + '&enabled=' +params.enabled;
                }
                if (this.type) {
                    query_str = query_str + '&type=' +this.type;
                }

                this.$http.get(this.package_list_url + query_str).then(function (data) {
                    if (! data.body.status) {
                        this.all = this.cur = 0;
                        this.package_list = [];
                        layer.alert(data.body.msg)
                    } else {
                        var return_data = data.body.data;
                        this.package_list = return_data.package_list
                        this.operate_users_info = return_data.operate_users_info
                        this.all = return_data.all_pages;
                        this.cur = return_data.cur_page;
                        console.log(return_data)
                    }
                }, function () {

                })
            }
        },

        computed: {
            indexs: function(index) {
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
            showLast: function() {
                if (this.cur == this.all) {
                    return false
                }
                return true
            },
            showFirst: function() {
                if (this.cur == 1) {
                    return false
                }
                return true
            }
        },
        watch: {
            cur: function(oldValue, newValue) {
                console.log(arguments)
            }
        },
        created:function () {
            this.packageList()
        }
    })
</script>