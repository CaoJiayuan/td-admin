<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>当日出入金查询</h2>
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
                                                    v-model="txtdate"
                                                    type="date"
                                                    format="yyyy-MM-dd"
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
                                        <div  class="col-md-1">
                                            <input type="text" style="background-color:#ffffff;" readonly="readonly" class="form-control titlelable" value="下级单位" />
                                        </div>
                                        <div   class="col-md-3">
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
                                    <th style="font-weight: bold;text-align: center">存入</th>
                                    <th style="font-weight: bold;text-align: center">取出</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="font-weight: bold;text-align: center">合计</td>
                                    <td style="font-weight: bold;text-align: center;padding-right: 15px">{{ InputData | ConvertDouble}}</td>
                                    <td style="font-weight: bold;text-align: center;padding-right: 15px">{{ OutPutData | ConvertDouble}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th>出入金时间</th>
                                    <th>客户手机</th>
                                    <th>客户姓名</th>
                                    <th>银行账号</th>
                                    <th>客户经理</th>
                                    <th>单位名称</th>

                                    <th>出入金方向</th>
                                    <th>金额</th>
                                    <th>是否到账</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="val in datas">
                                    <td >{{ val.o_date | isNullOrEmpty}}</td>
                                    <td data-toggle="modal" data-target="#debits"   @click="getDebits(val.user_id)">
                                        <a href="javascript:void(0)">
                                         {{ val.phone | isNullOrEmpty }}
                                        </a>
                                    </td>
                                    <td>{{val.name | isNullOrEmpty}}</td>
                                    <td >{{val.bank_num | isNullOrEmpty }}</td>
                                    <td >{{val.broker_name | isNullOrEmpty }}</td>
                                    <td >{{val.branch_name | isNullOrEmpty }}</td>
                                    <td>{{val.access_way | AccessWay }}</td>
                                    <td >{{ val.exch_bal | ConvertDouble}}</td>
                                    <td >{{val.in_account_flag | IsToAccount}}</td>
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
                url:"/api/Assets/GetCurrentAssets",
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
                InputData:"0.00",
                OutPutData:"0.00"
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
                    this.url = '/api/Assets/GetCurrentAssets?' + str;
                    vueApp.$emit('page.reset', this.url);
                }
                else {
                    toastrNotification('error', '请选择日期');
                }
            },
            condition()
            {
                var branchidparent=  $("#selectbranch").find("option:selected").attr("branchid");
                var branchidchild=  $("#selectchildbranch").find("option:selected").attr("branchid");

                var parentid= $("#selectbranch").val();
                var childid=$("#selectchildbranch").val();

                var phone=$("#txtPhone").val();
                var brokercode=$("#txtBrokerCode").val();
                this.txtdate = $(".el-input__inner").val();

                if(this.txtdate!='') {
                    var requestdata='';
                    requestdata+='bp='+branchidparent;
                    requestdata+='&bc='+branchidchild;
                    requestdata+='&parentid='+parentid;
                    requestdata+='&childid='+childid;
                    requestdata+='&phone='+phone;
                    requestdata+='&brokercode='+brokercode;
                    requestdata+='&date='+this.txtdate;
                    return requestdata;
                }
                else {
                    return ''
                }
            },
            exports(){
                var str=this.condition();
                if(str!='') {
                    location.href='/CurrentAssetsExcel?'+str;
                }
                else {
                    toastrNotification('error', '请选择日期');
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
                axios.get('/api/Total/totalcurrentassets?'+str).then(response =>{
                    //alert('aaa');
                    console.log(response);
                    if(response.data.length==0) {//都不存在
                       this.InputData ='0.00';
                       this.OutPutData='0.00';
                    }
                    else if(response.data.length==1){//只有一个元素
                        if(response.data[0].access_way=="1"){
                            this.InputData=response.data[0].totalexchbal;
                            this.OutPutData="0.00";
                        }
                        else{
                            this.InputData="0.00";
                            this.OutPutData=response.data[0].totalexchbal;
                        }
                    }
                    else{//查询出来两个
                        for(var k=0;k<response.data.length;k++){
                            if(response.data[k].access_way=="1"){
                                this.InputData=response.data[k].totalexchbal;
                            }
                            if(response.data[k].access_way=="2"){
                                this.OutPutData=response.data[k].totalexchbal;
                            }
                        }
                    }
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
            var dateStr = year + "-" + month + "-" + day;
            this.txtdate=dateStr;
            axios.get('/api/Trade/GetParentBranches').then(response =>{
                this.parentselect=response.data;
            }).catch(error => {
                    toastrNotification('error', error.response.data.message);
            });
            this.getTotal('');
        }
    }
</script>