<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>历史交易查询</h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12 well" style="background-color: rgb(255, 255, 255);">
                    <div class="ibox float-e-margins">
                        <div class="row">
                            <div class="col-md-12" style="padding-bottom:8px">
                                <div class="row" style="margin-left: 1px;">
                                    <div class="col-md-12">
                                        <div style="padding: 0px"  class="col-md-1">
                                            <input type="text" style="background-color:#ffffff;" readonly="readonly" class="form-control titlelable" value="选择日期" />
                                        </div>
                                        <div  class="col-md-3">
                                            <el-date-picker
                                                    v-model="value6"
                                                    type="daterange"
                                                    format="yyyy/MM/dd"
                                                    placeholder="选择日期范围"
                                                 >
                                            </el-date-picker>
                                        </div>
                                        <div style="padding: 0px"  class="col-md-1">
                                            <input type="text" style="background-color:#ffffff;" readonly="readonly" class="form-control titlelable" value="选择单位" />
                                        </div>
                                        <div  class="col-md-3">
                                            <select @change="selectbranchs()" id="selectbranch" class="form-control">
                                                <option value="0" branchid="0">--请选择单位--</option>
                                                <option :value="s.id" :branchid="s.branch_id" v-for="s in parentselect">
                                                    {{s.branch_name}}
                                                </option>
                                            </select>
                                        </div>
                                        <div style="padding: 0px"  class="col-md-1">
                                            <input  type="text" style="background-color:#ffffff;" readonly="readonly" class="form-control titlelable" value="下级单位" />
                                            <input type="text" style="display:none;background-color:#ffffff;" readonly="readonly" class="form-control titlelable" value="交易类型" />
                                        </div>
                                        <div  class="col-md-3">

                                            <!--<select class="form-control" style="display:none;" id="selecttradetype">
                                                <option value="0">--请选择交易类型--</option>
                                                <option value="1">开多仓</option>
                                                <option value="2">开空仓</option>
                                                <option value="3">平多仓</option>
                                                <option value="4">平空仓</option>
                                            </select>-->

                                            <select class="form-control"  id="selectchildbranch">
                                                <option value="0" branchid="0">--请选择下级单位--</option>
                                                <option :value="s.id" :branchid="s.branch_id" v-for="s in childselect">
                                                    {{s.branch_name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="padding-bottom:8px">
                                <div class="row" style="margin-left: 1px;">
                                    <div class="col-md-12">
                                        <div style="padding: 0px"  class="col-md-1">
                                            <input type="text" style="background-color:#ffffff;" readonly="readonly" class="form-control titlelable" value="客户手机" />
                                        </div>
                                        <div  class="col-md-3">
                                            <input type="text" class="form-control" id="txtPhone" value=""placeholder="请输入客户手机"/>
                                        </div>
                                        <div style="padding: 0px"  class="col-md-1">
                                            <input type="text" style="background-color:#ffffff;" readonly="readonly" class="form-control titlelable" value="客户经理" />
                                        </div>
                                        <div  class="col-md-3">
                                            <input type="text" class="form-control" id="txtBrokerCode" value="" placeholder="请输入客户经理编号"/>
                                        </div>
                                        <div style="padding: 0px"  class="col-md-1">
                                            <input type="text" style="background-color:#ffffff;" readonly="readonly" class="form-control titlelable" value="合约代码" />
                                        </div>
                                        <div  class="col-md-3">
                                            <select class="form-control" id="selectinstid">
                                                <option value="0">--请选择合约代码--</option>
                                                <option value="1">Au(T+D)</option>
                                                <option value="2">Ag(T+D)</option>
                                                <option value="3">mAu(T+D)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="padding-bottom:8px">
                                <div class="row" style="margin-left: 1px;">
                                    <div class="col-md-12">
                                        <div style="padding: 0px"  class="col-md-1">
                                            <input type="text" style="background-color:#ffffff;" readonly="readonly" class="form-control titlelable" value="交易类型" />
                                        </div>
                                        <div  class="col-md-3">
                                            <select class="form-control" id="selecttradetype">
                                                <option value="0">--请选择交易类型--</option>
                                                <option value="1">开多仓</option>
                                                <option value="2">开空仓</option>
                                                <option value="3">平多仓</option>
                                                <option value="4">平空仓</option>
                                            </select>
                                        </div>
                                        <div  class="col-md-3" style="text-align: center">
                                            <button @click="query()" class="btn btn-info" type="button">
                                                <i class="fa fa-search"></i>&nbsp;&nbsp;查&nbsp;&nbsp;询
                                            </button>
                                        </div>
                                        <div  class="col-md-3" style="text-align: center">
                                            <button  @click="exports()" class="btn btn-info" type="button" style="margin-left: 10px">
                                                <i class="glyphicon glyphicon-download-alt"></i>&nbsp;&nbsp;导&nbsp;&nbsp;出
                                            </button>
                                        </div>
                                        <div  class="col-md-2" style="text-align:center;">
                                            <button @click="reset()" class="btn btn-info" type="button">
                                                <i class="fa fa-undo"></i>&nbsp;&nbsp;重&nbsp;&nbsp;置
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th style="font-weight: bold;text-align: center">成交金额</th>
                                    <th style="font-weight: bold;text-align: center">保证金</th>
                                    <th style="font-weight: bold;text-align: center">交易费</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="font-weight: bold;text-align: center">合计</td>
                                    <td  style="font-weight: bold;text-align: center;padding-right: 15px">{{totalexch_bal | ConvertDouble}}</td>
                                    <td  id="totalmargin" style="font-weight: bold;text-align: center;padding-right: 15px">{{totalmargin | ConvertDouble}}</td>
                                    <td  id="totalfare" style="font-weight: bold;text-align: center;padding-right: 15px">{{totalfare | ConvertDouble}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th>交易日期</th>
                                    <th>客户手机</th>
                                    <th>客户姓名</th>
                                    <th>客户经理</th>
                                    <th>单位名称</th>
                                    <th>合约代码</th>
                                    <th>交易类型</th>
                                    <th>成交价格</th>
                                    <th>成交数量</th>
                                    <th>成交金额</th>
                                    <th>保证金</th>
                                    <th>交易费</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="val in datas">
                                    <td >{{ val.exch_date | isNullOrEmpty}}</td>
                                    <td data-toggle="modal" data-target="#debits"   @click="getDebits(val.user_id)">
                                        <a href="javascript:void(0)">
                                            {{ val.phone | isNullOrEmpty }}
                                        </a>
                                    </td>
                                    <td >{{val.real_name | isNullOrEmpty }}</td>
                                    <td >{{val.broker_name | isNullOrEmpty }}</td>
                                    <td >{{val.branch_name | isNullOrEmpty }}</td>
                                    <td>{{val.inst_id | ContractName}}</td>
                                    <td>{{val.exch_type | ConvertExchType}}</td>
                                    <td >{{ val.match_price | ConvertDouble}}</td>
                                    <td >{{val.match_amount}}</td>
                                    <td >{{val.exch_bal | ConvertDouble}}</td>
                                    <td >{{val.margin | ConvertDouble }}</td>
                                    <td >{{val.exch_fare | ConvertDouble}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <page :url="url" :onPageChanges="page"></page>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <debits :debits="debits"></debits>
    </div>
</template>
<style>
    .titlelable {
        text-align: center;
        border:none;
        font-weight:  bold;
        font-size: 12px;
    }
</style>
<script>
    import Page from '../Common/Paginator.vue'
    import OrderThead from '../Common/OrderThead.vue';
    import Debits from '../Account/DebitsModal.vue'
    export default{
        created(){
        },
        data(){
            return {
                datas:[
                ],
                value6:"2017-04-15 - 2017-05-01",
                url:"/api/Trade/GetHistoryTradeData",
                txtdate:'',
                parentselect:[],
                childselect:[],
                debits: {
                    goldAccount: {
                        auth: {
                            app_identifier: ''
                        },
                        bank: {
                            comment: ''
                        }
                    }
                },
                totalexch_bal:"0.00",
                totalmargin:"0.00",
                totalfare:"0.00"
            }
        },
        components: {
            Page,OrderThead,Debits
        },
        methods: {
            reset(){
                $(".el-input__inner").val('');
                $("#selectbranch").val('0');
                $("#selecttradetype").val('0');
                $("#txtPhone").val('');
                $("#txtBrokerCode").val('');
                $("#selectinstid").val('0');
            },
            query(){
                var str=this.condition();
                if(this.str!='') {
                    this.getTotal(str);
                    this.url = '/api/Trade/GetHistoryTradeData?' + str;
                    vueApp.$emit('page.reset', this.url);
                }
                else {
                    toastrNotification('error', '请选择日期');
                }
            },
            condition(){
                var branchidparent=  $("#selectbranch").find("option:selected").attr("branchid");
                var parentid= $("#selectbranch").val();
                var branchidchild=  $("#selectchildbranch").find("option:selected").attr("branchid");
                var childid=$("#selectchildbranch").val();

                var instid= $("#selectinstid").val();
                var insttype=$("#selecttradetype").val();
                var phone=$("#txtPhone").val();
                var brokercode=$("#txtBrokerCode").val();
                this.txtdate = $(".el-input__inner").val();
                var timearr= this.txtdate.split(' - ')
                var begin=timearr[0];
                var end=timearr[1];

                if(this.txtdate!='') {
                    var requestdata='';
                    requestdata+='bp='+branchidparent;
                    requestdata+='&bc='+branchidchild;
                    requestdata+='&parentid='+parentid;
                    requestdata+='&childid='+childid;
                    requestdata+='&instid='+instid;
                    requestdata+='&insttype='+insttype;
                    requestdata+='&phone='+phone;
                    requestdata+='&brokercode='+brokercode;
                    requestdata+='&begin='+begin;
                    requestdata+='&end='+end;
                    return requestdata;
                }
                else {
                    return '';
                }
            },
            exports(){
                var str=this.condition();
                location.href='/HistorytradeExcel?'+str;
            },
            page(data) {
                this.datas = data;
            },
            selectbranchs:function(){
                var branchValue= document.getElementById('selectbranch').value;
                axios.get('/api/Trade/GetChildBranches/'+branchValue).then(response =>{
                    this.childselect=response.data;
                }).catch(error => {
                        toastrNotification('error', error.response.data.message);
                });
            },
            getDebits(id){
                axios.get('/api/account/debits/' + id).then(response => {
                    console.log(response.data);
                    this.debits = response.data
                }).catch(error => {
                        toastrNotification('error', error.message);
                });
            },
            getTotal(str){
                axios.get('/api/Total/totalhistorytrade?'+str).then(response =>{
                        //alert('aaa');
                        console.log(response);
                        this.totalexch_bal =response.data[0].totalexch_bal;
                        this.totalmargin =response.data[0].totalmargin;
                        this.totalfare=response.data[0].totalfare;
                }).catch(error => {
                        toastrNotification('error', error.response.data.message);
                });
            }
        },
        mounted(){

            var nowDate = new Date();
            var year = nowDate.getFullYear();
            var month = nowDate.getMonth() + 1 < 10 ? "0" + (nowDate.getMonth() + 1)
                    : nowDate.getMonth() + 1;
            var day = nowDate.getDate() < 10 ? "0" + nowDate.getDate() : nowDate
                    .getDate();
            var dateStr = year + "/" + month + "/" + day;


            $(".el-input__inner").val(dateStr+' - '+dateStr);


            axios.get('/api/Trade/GetParentBranches').then(response =>{
                this.parentselect=response.data;
            }).catch(error => {
                    toastrNotification('error', error.response.data.message);
            });
            this.getTotal('');
        }
    }
</script>