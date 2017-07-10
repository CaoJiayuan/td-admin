<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>独家专栏</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li class="active"><strong>独家专栏</strong></li>
        </ol>
      </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="col-lg-12 well" style="background-color: rgb(255, 255, 255);">
          <div class="ibox float-e-margins">
            <div class="row">
              <search :url="url" :onSearch="onSearch"></search>
              <span class="input-group-btn">
                  <router-link to="/news/addScoop"><button type="button" class="btn btn-info"> <i class="fa fa-plus"></i>&nbsp; 添加专栏</button>
                    </router-link>
              </span>
            </div>

            <div id="table-container" class="ibox-content">
              <table class="table table-bordered dataTable">
                <thead>
                <tr>
                  <order-thead :column="'id'" :url="url" :tTitle="'序号'"></order-thead>
                  <th>类型</th>
                  <th class="col-lg-2">标题</th>
                  <th>缩略图</th>
                  <th>发布时间</th>
                  <th>阅读量</th>
                  <th>点赞量</th>
                  <th>评论量</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in scoops">
                  <td>{{ item.id }}</td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.title }}</td>
                    <td id="thu" class="text-center">
                      <a @click="preview(item)"  data-toggle="modal" data-target="#preview"><img :src="item.thumbnail" alt=""> </a>
                    </td>
                  <td>{{ item.published_at }}</td>
                  <td>{{ item.read }}</td>
                  <td>{{ item.like }}</td>
                  <td>{{ item.count_comments }}</td>
                  <td>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" @click="show(item)">
                      查看
                    </button>
                    <router-link :to=" '/news/editScoop/' +item.id"><button class="btn btn-info btn-sm">编辑</button></router-link>
                    <router-link :to="'/news/comment/' + item.id"><button class="btn btn-info btn-sm">查看评论</button></router-link>
                    <button @click="delScoop(item.id)" type="button" class="btn btn-danger btn-sm">删除</button>
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
            <h3 class="modal-title text-center" v-model="item.title">{{ item.title }}</h3>
          </div>
          <div class="modal-body" id="pic">
            <label v-model="item.published_at">{{ item.published_at }} </label>&nbsp;&nbsp;&nbsp;
            <label v-model="item.from">{{ item.from }}</label>
              <p class="html ql-editor" v-html="item.content"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
          </div>
        </div>`
      </div>
    </div>

    <div class="modal inmodal fade" id="preview" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
    class="sr-only">Close</span></button>
    </div>
    <img :src="item.thumbnail" alt="" class="img-container">
    <div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    </div>
    </div>
    </div>
    </div>

  </div>
</template>
<style>

#pic img{
  max-width : 100%;
}

#thu img{
  max-width : 100px;
  height : 100px;
}

#table-container{
  overflow:auto;
  display: block;
}

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
        scoops: {},
        item:{},
        url  : '/api/news/scoops'
      }
    },
    components: {
      Paginator,Search,OrderThead
    },
    methods   : {
      page(data){
        this.scoops = data;
      },
      onSearch (url) {
        this.url = url;
      },
      show(item){
        this.item = item;
        console.log(item);
      },
      delScoop(id){
        let self = this;
        var opts = {
          title: '确认删除?',
          text: '你将无法恢复数据!',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: '是,确定删除!',
          cancelButtonText: '不,取消删除',
          closeOnConfirm: false,
          closeOnCancel: false
        };

        sweetAlert(opts,
            function (isConfirm) {
              if (isConfirm) {
                axios.delete('/api/news/delScoop/'+id).then(response=>{
                  sweetAlert(
                      '已经删除!',
                      '数据已经删除!',
                      'success'
                  );
                  vueApp.$emit('page.refresh',self.url)
                }).catch(error =>{
                  toastrNotification('error',error.response.data.message);
                });
              } else {
                sweetAlert("取消", "数据没有删除!", "error");
              }
            });
      },

      preview(item){
        this.item = item
      }
    },

    mounted(){

    }
  }
</script>