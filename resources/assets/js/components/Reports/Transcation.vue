<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>报表统计</h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li class="active"><strong>交易人数统计</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12 well" style="background-color: rgb(255, 255, 255);">
                    <div class="ibox float-e-margins">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" style="margin-left: 5px;padding-bottom:15px">
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
                                        <div class="col-md-7">
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
                                <thead class="tabletitle">
                                <tr><th style="padding-top: 25px" rowspan="2">日期</th><th style="padding-top: 25px" rowspan="2">成交人数</th>
                                    <th style="padding-top: 25px" rowspan="2">成交总量</th><th colspan="4">黄金延期</th>
                                    <th colspan="4">白银延期</th><th colspan="4">MiNi黄金延期</th><th style="padding-top: 25px" rowspan="2">操作</th>
                                </tr>
                                <tr><th>开多</th><th>开空</th><th>平多</th><th>平空</th>
                                    <th>开多</th><th>开空</th><th>平多</th><th>平空</th>
                                    <th>开多</th><th>开空</th><th>平多</th><th>平空</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="val in datas">
                                    <td v-text="val.date"></td>
                                    <td v-text="val.totalperson"></td>
                                    <td v-text="val.match_amount"></td>
                                    <td v-text="val.au1"></td>
                                    <td v-text="val.au2"></td>
                                    <td v-text="val.au3"></td>
                                    <td v-text="val.au4"></td>
                                    <td v-text="val.ag1"></td>
                                    <td v-text="val.ag2"></td>
                                    <td v-text="val.ag3"></td>
                                    <td v-text="val.ag4"></td>
                                    <td v-text="val.mau1"></td>
                                    <td v-text="val.mau2"></td>
                                    <td v-text="val.mau3"></td>
                                    <td v-text="val.mau4"></td>
                                    <td>
                                        <router-link :to="{ name: 'transstatdetails', params: { date: val.date,begin:dbegin,end:dend }}">
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
.tabletitle tr th{
    text-align: center;
}
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
                url:"/api/Statistics/Transcation",
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
                    this.url = '/api/Statistics/Transcation?begin=' + begin + '&end=' + end;
                    vueApp.$emit('page.reset', this.url);
                }
                else {
                    toastrNotification('error', '请选择正确的日期');
                }
            },
            exports()
            {
                //location.href='/TradeExcel?begin='+this.dbegin.toString().replace('///g','-')+'&end='+this.dend.toString().replace('///g','-');


                location.href='/TradeDetailsExcel?begin='+this.dbegin.toString().replace('///g','-')+'&end='+this.dend.toString().replace('///g','-');

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