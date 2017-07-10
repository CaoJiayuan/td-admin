<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>资金流水</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li>
                            <router-link to="/account">客户列表</router-link>
                        </li>
                        <li class="active"><strong>资金流水</strong></li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
                        <router-link to="/account"><a class="button btn btn-info">返回</a></router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <order :column="'exch_date'" :url="url" :tTitle="'交易时间'"></order>
                                    <th>当日交易费用</th>
                                    <th>其他费用</th>
                                    <th>平仓盈余</th>
                                    <th>盯市盈亏</th>
                                    <th>浮动盈亏</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in data">
                                    <td>{{item.exch_date}}</td>
                                    <td>{{item.real_exch_fare}}</td>
                                    <td>{{item.other_fare}}</td>
                                    <td>{{item.cov_surplus}}</td>
                                    <td>{{item.mark_surplus}}</td>
                                    <td>{{item.float_surplus}}</td>
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
<script>
  import Search from './../Common/Search.vue'
  import Page from './../Common/Paginator.vue'
  import Order from './../Common/OrderThead.vue'
  export default{
    created(){

    },
    data(){
      return {
        url: '/api/account/capital/' + this.$route.params.id,
        data: {},
      }
    },
    components: {
      Page,
      Order
    },
    methods: {
      page(data){
        this.data = data;
      },
    },
    mounted(){
    },

  }
</script>