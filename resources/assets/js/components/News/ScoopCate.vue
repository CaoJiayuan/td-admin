<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>独家专栏类别</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li class="active"><strong>独家专栏类别</strong></li>
        </ol>
      </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="col-lg-12 well" style="background-color: rgb(255, 255, 255);">
          <div class="ibox float-e-margins">
            <div  style="padding-left: 30px" class="row">
              <search :url="url" :onSearch="onSearch"></search>
              <span class="input-group-btn">
                   <button type="button" @click="remove" class="btn btn-info" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"></i>&nbsp; 添加类型</button>
              </span>
            </div>

            <div class="ibox-content">
              <table class="table table-bordered dataTable">
                <thead>
                <tr>
                  <order-thead :column="'id'" :url="url" :tTitle="'序号'"></order-thead>
                  <th>类型名称</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in categories">
                  <td>{{ item.id }}</td>
                  <td>{{ item.name }}</td>
                  <td>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal2" @click="show(item)">
                      编辑
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" @click="delCate(item.id)">
                      删除
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
            <button @click="remove" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title text-center" id="myModalLabel">新增类型</h3>
          </div>
          <div class="modal-body clearfix">
            <div class="form-group col-lg-12"><label class="col-lg-3 control-label text-right"><h3>专栏名称:</h3></label>
              <div class="col-lg-8">
                <input type="text" id="remove"  v-model="scoopCate.name" class="form-control">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" @click="addScoopCate" class="btn btn-info">确定</button>
            <button @click="remove" type="button" id="close" class="btn btn-default" data-dismiss="modal">关闭</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="myModal2" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title text-center">编辑类型</h3>
          </div>
          <div class="modal-body clearfix">
            <div class="form-group col-lg-12"><label class="col-lg-3 control-label text-right"><h3>专栏名称:</h3></label>
              <div class="col-lg-8">
                <input type="text" v-model="item.name" class="form-control">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info"  @click="editCate(item.id)">确定</button>
            <button @click="flash" type="button" id="close1" class="btn btn-default" data-dismiss="modal">关闭</button>
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
        categories: {},
        item:{
          name:''
        },
        url: '/api/news/categories',
        scoopCate: {
          name: ''
        }
      }
    },
    components: {
      Paginator, Search, OrderThead
    },
    methods: {
      page(data){
        this.categories = data;
      },
      onSearch (url) {
        this.url = url;
      },
      addScoopCate(){
        axios.post('/api/news/addScoopCate', this.scoopCate).then(response=>{
          $("#close").trigger({type: "click"});
          toastrNotification('success', '保存成功!');
          vueApp.$emit('page.refresh',this.url);
      }).catch(error => {
          toastrNotification('error', error.response.data.message);
      });
      },
      editCate(id){
        axios.put('/api/news/editScoopCate/'+id,this.item).then(response =>{
          $("#close1").trigger({type: "click"});
          toastrNotification('success', '修改成功!');
          vueApp.$emit('page.refresh',this.url);
        }).catch(error =>{
          toastrNotification('error', error.response.data.message);
        });
      },
      show(item){
        this.item = item;
      },

      remove(){
        $("#remove").val('')
      },
      flash(){
        vueApp.$emit('page.refresh',this.url);
      },
      delCate(id){
        let self = this;
        var opts = {
          title: '请先将该类型下所有新闻删除!',
          text: '确认删除?',
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
                axios.delete('/api/news/delScoopCate/'+id).then(response=>{
                  sweetAlert(
                      '已经删除!',
                      '数据已经被删除!',
                      'success'
                  );
                  vueApp.$emit('page.refresh',self.url)
            }).catch(error =>{
            toastrNotification('error',error.response.data.message);
            });
              } else {
                sweetAlert("取消", "数据没有被删除!", "error");
              }
            });
      },
      mounted(){

      }
    }
  }
</script>