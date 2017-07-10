<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>评论投诉列表</h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li class="active"><strong>投诉列表</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12 well" style="background-color: #fff">
                    <div class="ibox float-e-margins">

                        <div class="row">
                            <search :url="url" :onSearch="onSearch"></search>
                        </div>

                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th>用户</th>
                                    <th>评论内容</th>
                                    <order-thead :column="'created_at'" :url="url" :tTitle="'投诉时间'"></order-thead>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in complaints">
                                    <td>{{ item.nick_name}}</td>
                                    <td>{{ item.comment ? item.comment.content : '' }}</td>
                                    <td>{{ item.created_at }}</td>
                                    <td class="vuetable-actions center aligned">
                                        <button type="button" @click="putType(item)" class="btn btn-info btn-sm" data-target="#myModal" data-toggle="modal">查看评论
                                        </button>
                                      <button v-if="item.comment_status==0" class="btn btn-sm btn-info" @click="modifyStatus(item)">启用评论</button>
                                      <button v-if="item.comment_status==1" class="btn btn-sm btn-danger" @click="modifyStatus(item)">禁用评论</button>
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
                        <h3 class="modal-title text-center">评论内容</h3>
                    </div>
                    <div class="modal-body">
                        <p>{{ comment.content }}</p>
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
        complaints:{},
        comment:{
            content:''
        },
        item:{},
        type : this.complaints,
        url  : '/api/products/complaint'
      }
    },
    components: {
      Paginator,OrderThead,Search
    },
    methods   : {
      page(data){
        this.complaints = data;
      },
      onSearch (url) {
        this.url = url;
      },
      putType (item){
          axios.post('/api/product/getComments',item).then(response => {
              this.comment = response.data;
          });
      },
      modifyStatus({type, comment_id}){
        type ? this.modifyScoopC(comment_id) : this.modifyNewsC(comment_id);
      },
      modifyNewsC(id) {
        axios.get('/api/news/modifyStatus/' + id).then(response =>{
          toastrNotification('success', '修改状态成功');
          vueApp.$emit('page.refresh', this.url);
        }).catch(error =>{
          toastrNotification('error', error);
        });
      },
      modifyScoopC(id) {
        axios.get('/api/news/scoopComments/modifyStatus/' + id).then(response =>{
          toastrNotification('success', '修改状态成功');
          vueApp.$emit('page.refresh', this.url);
        }).catch(error =>{
          toastrNotification('error', error);
        });
      }
    },
    mounted(){
    }
  }
</script>

