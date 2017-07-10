<template>
<div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>开户协议</h2>
            <ol class="breadcrumb">
                <li>
                    <router-link to="/">首页</router-link>
                </li>
                <li class="active"><strong>协议列表</strong></li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <search :url="url" :onSearch="onSearch"></search>
                        <span class="input-group-btn">
                   <router-link to="/agreement/add">
                      <button type="button" class="btn btn-info">
                          <i class="fa fa-plus"></i>&nbsp; 新增协议
                      </button>
                  </router-link>
                </span>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-bordered dataTable">
                            <thead>
                            <tr>
                                <order-thead :column="'id'" :url="url" :tTitle="'序号'"></order-thead>
                                <th>协议名称</th>
                                <order-thead :column="'updated_at'" :url="url" :tTitle="'操作时间'"></order-thead>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="agreement in agreements">
                                <td>{{ agreement.id }}</td>
                                <td>{{ agreement.title }}</td>
                                <td>{{ agreement.updated_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#myModal" @click="show(agreement)">查看
                                    </button>
                                    <router-link :to="{ name: '/agreement/edit', params: { id: agreement.id }}">
                                        <button type="button" class="btn btn-info btn-sm">编辑</button>
                                    </router-link>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            @click="delAgr(agreement.id)">删除
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
    <!--预览-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center">{{ agreement.keyWords }}</h3>
                </div>
                <div class="form-group html ql-editor" id="agimg">
            <span class="col-sm-12" v-html="agreement.content">
            </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
    <!--预览结束-->
</div>
</template>
<style>
    #agimg img{
          width: 570px;
    }
</style>
<script>
  import Paginator from '../Common/Paginator.vue';
  import OrderThead from '../Common/OrderThead.vue';
  import Search from '../Common/Search.vue';
  export default{
    created(){},
    data(){
      return {
        agreements: {
             id:'',
             title:'',
             content:''
        },
        agreement:{
           id:'',
           keyWords:'',
           content:''
        },
        url  : '/api/agreement/index'
      }
    },
    components: {
      Paginator,OrderThead,Search
    },
    methods   : {
      page(data){
        this.agreements = data;
      },
      show(agreement){
         this.agreement = agreement;
      },
      onSearch (url) {
        this.url = url;
      },
      delAgr(id){
        let self = this;
        var opts = {
          title: '确定删除?',
          text: '你将无法恢复所删数据!',
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
                axios.delete('/api/agreement/delAgreement/'+id).then(response=>{
                  sweetAlert(
                      '已经删除!',
                      '数据已经被删除!',
                      'success'
                  );
                  vueApp.$emit('page.refresh',self.url)
            }).catch(error =>{
            toastrNotification('error',error);
            });
              } else {
                sweetAlert("取消", "数据没有删除!", "error");
              }
            });

    },
    },
    mounted(){

    }
  }


</script>


