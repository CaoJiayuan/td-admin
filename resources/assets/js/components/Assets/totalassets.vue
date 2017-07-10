<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>总资产查询</h2>
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
                                                    :class="form-control"
                                                    placeholder="选择日期"
                                                    :picker-options="pickerOptions0">
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
                                        <div style="padding: 0px;"  class="col-md-1">
                                            <input type="text" style="background-color:#ffffff;" readonly="readonly" class="form-control titlelable" value="下级单位" />
                                        </div>
                                        <div  style="padding: 0px;"  class="col-md-3">
                                            <select class="form-control" id="selectchildbranch">
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

                                        </div>
                                        <div style="padding: 0px"  class="col-md-3">
                                            <button @click="query()" class="btn btn-info" type="button">
                                                <i class="fa fa-search"></i>&nbsp;&nbsp;查&nbsp;&nbsp;询
                                            </button>
                                            <button  @click="exports()" class="btn btn-info" type="button" style="margin-left: 10px">
                                                <i class="glyphicon glyphicon-download-alt"></i>&nbsp;&nbsp;导&nbsp;&nbsp;出
                                            </button>

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
                                    <th style="font-weight: bold;text-align: center">上日余额</th>
                                    <th style="font-weight: bold;text-align: center">上日可用</th>
                                    <th style="font-weight: bold;text-align: center">当日余额</th>
                                    <th style="font-weight: bold;text-align: center">当日可用</th>
                                    <th style="font-weight: bold;text-align: center">交易费</th>
                                    <th style="font-weight: bold;text-align: center">其他费用</th>
                                    <th style="font-weight: bold;text-align: center">盯市盈余</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="font-weight: bold;text-align: center">合计</td>
                                    <td style="font-weight: bold;text-align: center;padding-right: 15px">{{totallastbal | ConvertDouble}}</td>
                                    <td style="font-weight: bold;text-align: center;padding-right: 15px">{{totallastcanuse | ConvertDouble}}</td>
                                    <td style="font-weight: bold;text-align: center;padding-right: 15px">{{totalcurrbal | ConvertDouble}}</td>
                                    <td style="font-weight: bold;text-align: center;padding-right: 15px">{{totalcurrcanuse | ConvertDouble}}</td>
                                    <td style="font-weight: bold;text-align: center;padding-right: 15px">{{totalexchfare | ConvertDouble}}</td>
                                    <td style="font-weight: bold;text-align: center;padding-right: 15px">{{totalotherfare | ConvertDouble}}</td>
                                    <td style="font-weight: bold;text-align: center;padding-right: 15px">{{totalmarksurplus | ConvertDouble}}</td>
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
                                    <th>上日余额</th>
                                    <th>上日可用</th>
                                    <th>当日余额</th>
                                    <th>当日可用</th>
                                    <th>交易费用</th>
                                    <th>其他费用</th>
                                    <th>盯市盈余</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="val in datas">
                                    <td >{{ val.exch_date | isNullOrEmpty}}</td>
                                    <td data-toggle="modal" data-target="#debits"   @click="getDebits(val.user_id)">
                                        <a href="javascript:void(0)">
                                            {{ val.app_identifier | isNullOrEmpty }}
                                        </a>
                                    </td>
                                    <td >{{val.real_name | isNullOrEmpty }}</td>
                                    <td >{{val.broker_name | isNullOrEmpty }}</td>
                                    <td >{{val.branch_name | isNullOrEmpty }}</td>
                                    <td>{{val.last_bal | ConvertDouble}}</td>
                                    <td>{{val.last_can_use | ConvertDouble}}</td>
                                    <td >{{ val.curr_bal | ConvertDouble}}</td>
                                    <td>{{val.curr_can_use | ConvertDouble}}</td>
                                    <td >{{val.real_exch_fare | ConvertDouble}}</td>
                                    <td >{{val.other_fare | ConvertDouble }}</td>
                                    <td >{{val.mark_surplus | ConvertDouble}}</td>
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
                value6:"",
                url:"/api/Assets/GetTotalAssets",
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
                totallastbal:"0.00",
                totallastcanuse:"0.00",
                totalcurrbal:"0.00",
                totalcurrcanuse:"0.00",
                totalexchfare:"0.00",
                totalotherfare:"0.00",
                totalmarksurplus:"0.00"
            }
        },
        components: {
            Page,OrderThead,Debits
        },
        methods: {
            pickerOptions0: {
                disabledDate(time) {
                    return time.getTime() < Date.now() - 8.64e7;
                }
            },
            reset(){
                $(".el-input__inner").val('');
                $("#selectbranch").val('0');
                $("#txtPhone").val('');
                $("#txtBrokerCode").val('');
            },
            query(){
                var str=this.condition();
                if(str!='') {
                    this.getTotal(str);
                    this.url = '/api/Assets/GetTotalAssets?' + str;
                    vueApp.$emit('page.reset', this.url);
                }
                else {
                    toastrNotification('error', '请选择日期范围');
                }
            },
            exports(){
                     var str=this.condition();
                     location.href = '/TotalAssetsExcel?' +str;
            },
            condition()
            {
                var branchidparent=  $("#selectbranch").find("option:selected").attr("branchid");
                var parentid= $("#selectbranch").val();
                var branchidchild=  $("#selectchildbranch").find("option:selected").attr("branchid");
                var childid=$("#selectchildbranch").val();

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
                    requestdata+='&phone='+phone;
                    requestdata+='&brokercode='+brokercode;
                    requestdata+='&date='+this.txtdate;
                    requestdata+='&begin='+begin;
                    requestdata+='&end='+end;
                    return requestdata;
                }
                else {
                    var requestdata='';
                    requestdata+='bp='+branchidparent;
                    requestdata+='&bc='+branchidchild;
                    requestdata+='&phone='+phone;
                    requestdata+='&brokercode='+brokercode;
                    requestdata+='&date='+this.txtdate;
                    requestdata+='&begin=';
                    requestdata+='&end=';
                    return requestdata;
                }
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
                    this.debits = response.data
                }).catch(error => {
                        toastrNotification('error', error.message);
                });
            },
            getTotal(str){
                axios.get('/api/Total/totalnumberassets?'+str).then(response =>{
                        console.log(response);
                        this.totallastbal=response.data[0].totallastbal;
                        this.totallastcanuse=response.data[0].totallastcanuse;
                        this.totalcurrbal=response.data[0].totalcurrbal;
                        this.totalcurrcanuse=response.data[0].totalcurrcanuse;
                        this.totalexchfare =response.data[0].totalexchfare;
                        this.totalotherfare=response.data[0].totalotherfare;
                        this.totalmarksurplus =response.data[0].totalmarksurplus;
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