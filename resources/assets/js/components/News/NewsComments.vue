<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>新闻资讯评论</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li>
            <router-link to="/news/info">新闻资讯</router-link>
          </li>
          <li class="active"><strong>新闻资讯评论</strong></li>
        </ol>
      </div>
      <div class="col-lg-4">
        <div class="title-action">
          <router-link to="/news/info">
            <button class="btn btn-info">返回</button>
          </router-link>
        </div>
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
                  <order-thead :column="'created_at'" :url="url" :tTitle="'发布时间'"></order-thead>
                  <th>用户名</th>
                  <th>发布内容</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in comments">
                  <td>{{ item.created_at }}</td>
                  <td>{{ item.user ? item.user.nick_name : ''}}</td>
                  <td>{{ item.content }}</td>
                  <td>
                    <button v-if="item.status==0" class="btn btn-sm btn-info" @click="modifyStatus(item.id)">启用</button>
                    <button v-if="item.status==1" class="btn btn-sm btn-danger" @click="modifyStatus(item.id)">禁用</button>
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
            <h3 class="modal-title text-center" id="myModalLabel"></h3>
          </div>
          <div class="modal-body">
            ...
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
        comments: {},
        url  : '/api/news/newsComments/'+this.$route.params.id
      }
    },
    components: {
      Paginator,Search,OrderThead
    },
    methods   : {
      page(data){
        this.comments = data;
      },
      onSearch (url) {
        this.url = url;
      },
      modifyStatus(id){
        axios.get('/api/news/modifyStatus/' + id).then(response =>{
          toastrNotification('success', '修改状态成功');
          vueApp.$emit('page.refresh', this.url);
        }).catch(error =>{
          toastrNotification('error', error);
        });
      },

    },
    mounted(){

    }
  }
</script>