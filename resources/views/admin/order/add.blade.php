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
                        <form role="form" >
                             <input type="hidden" v-model="member_id">
                             <div class="form-group">
                                 <label class="col-sm-12 ">手机号码/用户名</label>
                                 <div class="col-sm-5">
                                     <input type="text"
                                            class="form-control" placeholder="手机号码/用户名"/>
                                 </div>
                                 <button type="button" id="query-coins" class="btn btn-primary">查询用户信息</button>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12">联系方式</label>
                                <div class="col-sm-6">
                                    <input type="text" id="minus-coin-tel" class="form-control" placeholder="只能输入一个手机号"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12"></label>
                                <div class="col-sm-6">
                                    <button style="margin-left:50% ;" type="button" @click="submitOrder" class="btn btn-bg btn-info">提交 </button>
                                </div>
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
        el : "#order-add",
        data:{
            member_id : 0
        },
        methods:{
            submitOrder: function () {
                
            }
        },
        created:function(){}
    })


</script>