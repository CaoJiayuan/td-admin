<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>转账明细</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li>
                            <router-link to="/account">客户列表</router-link>
                        </li>
                        <li class="active"><strong>转账明细</strong></li>
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
                                    <order :column="'o_date'" :url="url" :tTitle="'转账日期'"></order>
                                    <th>类型</th>
                                    <th>金额</th>
                                    <th>状态</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in data">
                                    <td>{{item.o_date}}</td>
                                    <td v-if="item.access_way==1">转入</td>
                                    <td v-if="item.access_way==2">转出</td>
                                    <td>{{item.exch_bal}}</td>
                                    <td v-if="item.in_account_flag">已入账</td>
                                    <td v-else>未入账</td>
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
        url: '/api/account/transfers/' + this.$route.params.id,
        data: {}
      }
    },
    components: {
      Search,
      Page,
      Order
    },
    methods: {
      page(data){
        this.data = data;
      }
    },
    mounted(){
    },

  }
</script>
