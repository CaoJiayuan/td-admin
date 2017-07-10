<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>注册人数统计</h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li class="active"><strong>注册人数统计</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12 well" style="background-color: rgb(255, 255, 255);">
                    <div class="ibox float-e-margins">
                        <div class="row">
                            <div class="col-md-12" style="margin-left: 5px;padding-bottom:15px">
                                <div class="row" style="margin-left: 5px;">
                                    <div class="col-md-12">
                                        <div  class="col-md-3">
                                            <div class="block" style="width: 100%">
                                                <el-date-picker
                                                        v-model="value6"
                                                        format="yyyy/MM/dd"
                                                        type="daterange"
                                                        placeholder="选择日期范围">
                                                </el-date-picker>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <button @click="query()" class="btn btn-info" type="button">
                                                <i class="fa fa-search"></i>&nbsp;&nbsp;查&nbsp;&nbsp;询
                                            </button>
                                            <button  @click="exports()" class="btn btn-info" type="button" style="margin-left: 10px">
                                                <i class="glyphicon glyphicon-download-alt"></i>&nbsp;&nbsp;导&nbsp;&nbsp;出
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
                                    <order-thead :column="'tbl.date'" :url="url" :tTitle="'日期'"></order-thead>
                                    <order-thead :column="'num'" :url="url" :tTitle="'注册人数'"></order-thead>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="val in datas">
                                    <td v-text="val.date"></td>
                                    <td v-text="val.num"></td>
                                    <td>
                                        <router-link :to="{ name: 'regdetail', params: { date: val.date,begin:dbegin,end:dend }}">
                                            <button type="button" class="btn btn-sm btn-info">查看详情</button>
                                        </router-link>
                                    </td>
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
                value6:"",
                url:"/api/Statistics/Register",
                dbegin:'',
                dend:'',
            }
        },
        components: {
            Page,OrderThead
        },
        methods: {
            query(){
                var timearr=$('.el-input__inner').val().split(' - ');
                var begin=timearr[0];
                var end=timearr[1];
                this.dbegin=begin;
                this.dend=end;
                if(timearr!='') {
                    this.url = '/api/Statistics/Register?begin=' + begin + '&end=' + end;
                    vueApp.$emit('page.reset', this.url);
                }
                else {
                    toastrNotification('error', '请选择正确的日期');
                }
            },
            exports()
            {
                location.href='/RegisterExcel?begin='+this.dbegin.toString().replace('///g','-')+'&end='+this.dend.toString().replace('///g','-');
            },
            page(data) {
                this.datas = data;
            }
        },
        mounted(){

            let path = this.$route.path,cache = window.Vue.cache[path] || Vue.cacheKeyDefault;

            $(".el-input__inner").val(cache.begin+' - '+cache.end);

        }
    }
</script>