<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>独家专栏评论</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li>
            <router-link to="/news/scoop">独家专栏</router-link>
          </li>
          <li class="active"><strong>独家专栏评论</strong></li>
        </ol>
      </div>
      <div class="col-lg-4">
        <div class="title-action">
          <router-link to="/news/scoop">
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
                  <td>{{ item.nick_name }}</td>
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
        url  : '/api/news/comments/'+this.$route.params.id
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
        vueApp.$emit('page.refresh', url)
      },
      modifyStatus(id){
        axios.get('/api/news/scoopComments/modifyStatus/' + id).then(response =>{
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