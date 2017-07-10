<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>报表统计</h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li>
                        <router-link to="/transstat">交易手数统计</router-link>
                    </li>
                    <li class="active"><strong>{{routeparams}}交易手数统计</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12 well" style="background-color: rgb(255, 255, 255);">
                    <div class="ibox float-e-margins">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" style="margin-left: 5px;">
                                    <div class="col-md-12">
                                        <div  class="col-md-3">
                                            <div class="block" style="width: 100%;visibility: hidden">
                                                 <span class="demonstration">请选择日期</span>
                                                 <input type="text">
                                             </div>
                                         </div>
                                         <div class="col-md-6">
                                            <button style="visibility: hidden" class="btn btn-primary" type="button">
                                                 <i class="fa fa-search"></i>&nbsp;&nbsp;查&nbsp;&nbsp;询
                                             </button>
                                             <button  class="btn btn-primary" type="button" style="margin-left: 10px;visibility: hidden">
                                                 <i class="glyphicon glyphicon-download-alt"></i>&nbsp;&nbsp;导&nbsp;&nbsp;出
                                             </button>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="title-action">
                                                <router-link to="/transstat"><a class="button btn btn-danger">返回</a></router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <order-thead :column="'exch_date'" :url="url" :tTitle="'交易时间'"></order-thead>
                                    <th>用户名称</th>
                                    <th>姓名</th>
                                    <th>客户经理</th>
                                    <th>合约代码</th>
                                    <th>类型</th>
                                    <th>成交价格</th>
                                    <th>成交数量</th>
                                    <th>成交金额</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="val in datas">
                                    <td v-text="val.exch_date"></td>
                                    <td  data-toggle="modal" data-target="#debits"   @click="getDebits(val.user_id)">
                                        <a href="javascript:void(0)">{{val.app_identifier}}</a>
                                    </td>
                                    <td v-text="val.relyname"></td>
                                    <td>{{val.broker_name | isNullOrEmpty}}</td>
                                    <td >{{val.inst_id | ContractName}}</td>
                                    <td >{{val.exch_type | ConvertExchType}}</td>
                                    <td >{{val.match_price | ConvertDouble}}</td>
                                    <td v-text="val.match_amount"></td>
                                    <td>{{val.exch_bal | ConvertDouble}}</td>
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
                url:"/api/Statistics/TranDetails?date="+this.$route.params.date,
                routeparams:this.$route.params.date,
                dbegin:this.$route.params.begin,
                dend:this.$route.params.end,
                debits: {
                    goldAccount: {
                        auth: {
                            app_identifier: ''
                        },
                        bank: {
                            comment: ''
                        }
                    }
                }
            }
        },
        components: {
            Page,OrderThead,Debits
        },
        methods: {
            page(data) {
                this.datas = data;
            },
            getDebits(id){
                axios.get('/api/account/debits/' + id).then(response => {
                    this.debits = response.data
            }).catch(error => {
                    toastrNotification('error', error.message);
            });
            }
        },
        mounted(){

        }
    }
</script>