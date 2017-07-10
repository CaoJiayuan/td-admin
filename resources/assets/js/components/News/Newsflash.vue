<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>新闻快讯</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li class="active"><strong>新闻快讯</strong></li>
        </ol>
      </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="col-lg-12 well" style="background-color: rgb(255, 255, 255);">
          <div class="ibox float-e-margins">
            <div class="row">
              <search :url="url" :onSearch="onSearch"></search>
            </div>

            <div class="ibox-content">
              <table class="table table-bordered dataTable">
                <thead>
                <tr>
                  <order-thead :column="'flash_id'" :url="url" :tTitle="'序号'"></order-thead>
                  <th class="col-lg-6">快讯内容</th>
                  <th>发布时间</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in flashes">
                  <td>{{ item.flash_id }}</td>
                  <td v-html="item.flash_sum"></td>
                  <td>{{ item.pub_time }}</td>
                  <td>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" @click="show(item)">
                      查看
                    </button>
                  </td>
                </tr>
                </tbody>
              </table>
              <paginator :url="url" :onPageChanges="page"></paginator>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <label v-html="item.flash_sum">{{ item.flash_sum }} </label>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>

</style>
<script>
  import Paginator from '../Common/Paginator.vue';
  import OrderThead from '../Common/OrderThead.vue';
  import Search from '../Common/Search.vue';
  export default{
    created(){

    },
    data(){
      return {
        flashes: {},
        item:{},
        url  : '/api/news/flash'
      }
    },
    components: {
      Paginator,Search,OrderThead
    },
    methods   : {
      page(data){
        this.flashes = data;
      },
      onSearch (url) {
        this.url = url;
      },
      show(item){
        this.item = item;
      }
    },
    mounted(){

    }
  }
</script>