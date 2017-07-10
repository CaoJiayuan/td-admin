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
                        <router-link to="/registerstat">注册统计</router-link>
                    </li>
                    <li class="active"><strong>{{routeparams}}日注册详情</strong></li>
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
                                                <router-link to="/registerstat"><a class="button btn btn-danger">返回</a></router-link>
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
                                    <order-thead :column="'pua.create_time'" :url="url" :tTitle="'注册时间'"></order-thead>
                                    <th>用户名</th>
                                    <th>姓名</th>
                                    <th>客户经理</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="val in datas">
                                    <td v-text="val.create_time"></td>
                                    <td v-text="val.app_identifier"></td>
                                    <td v-text="val.real_name"></td>
                                    <td>客户经理</td>
                                </tr>
                                </tbody>
                            </table>
                            <page :url="url" :onPageChanges="page"></page>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>
<style>

</style>
<script>
    import Page from '../Common/Paginator.vue'
    import OrderThead from '../Common/OrderThead.vue';
    export default{
        created(){
        },
        data(){
            return {
                datas:[
                ],
                url:"/api/Statistics/RegisterDetails?date="+this.$route.params.date,
                routeparams:this.$route.params.date,
                dbegin:this.$route.params.begin,
                dend:this.$route.params.end,
            }
        },
        components: {
            Page,OrderThead
        },
        methods: {
            page(data) {
                this.datas = data;
            }
        },
        mounted(){

        }
    }
</script>