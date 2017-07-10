<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>素材列表</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li class="active"><strong>素材列表</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title" style="height:65px;">
                            <search :url="url"></search>
                            <router-link to="/resources/add" v-if="permission.can('ads.resources.add')">
                                <button class="btn btn-info">新增素材</button>
                            </router-link>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <order :column="'id'" :url="url" :tTitle="'序号'"></order>
                                    <th class="col-lg-2">素材名称</th>
                                    <th>操作时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in resource">
                                    <td>{{item.id}}</td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.updated_at}}</td>
                                    <td v-if="item.status==0">已禁用</td>
                                    <td v-if="item.status==1">已启用</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" @click="preview(item.content)"
                                                data-toggle="modal" data-target="#myModal5" v-if="permission.can('ads.resources.show')">
                                            预览
                                        </button>

                                        <router-link :to="{ name: '/resources/edit', params: { id: item.id }}" v-if="permission.can('ads.resources.edit')">
                                            <button class="btn btn-sm btn-info">
                                                编辑
                                            </button>
                                        </router-link>
                                        <button v-if="item.status==0 && permission.can('ads.resources.delete')" class="btn btn-sm btn-info" @click="modifyStatus(item.id)">启用</button>
                                        <button v-if="item.status==1 && permission.can('ads.resources.delete')" class="btn btn-sm btn-danger" @click="modifyStatus(item.id)">禁用</button>
                                        <button class="btn btn-sm btn-danger" @click="deleteResource(item.id)" v-if="permission.can('ads.resources.delete')">删除
                                        </button>
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

        <div style="display: none;" class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">素材预览</h4>
                    </div>
                    <div class="lightBoxGallery" id="content">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">返回</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
  import Search from './../Common/Search.vue'
  import Order from './../Common/OrderThead.vue'
  import Page from './../Common/Paginator.vue'
  export default{
    created(){

    },
    data(){
      return {
        url: '/api/resource',
        resource: {}
      }
    },
    components: {
      Search,
      Order,
      Page
    },
    methods: {
      page(data){
        this.resource = data;
      },
      edit(id){

      },
      deleteResource(id){
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
              axios.get('/api/resource/delete/' + id).then(response => {
                if(response.data.code==200){
                  sweetAlert("已经删除", "数据已经删除!", "success");
                  vueApp.$emit('page.refresh', this.url);
                }else{
                  sweetAlert("取消", response.data.message, "error");
                }
              }).catch(error =>{
                toastrNotification('error', error.message);
              });
            } else {
              sweetAlert("取消", "数据没有删除!", "error");
            }
          });
      },
      modifyStatus(id){
        axios.get('/api/resource/modifyStatus/' + id).then(response => {
          if(response.data.code==200) {
            toastrNotification('success', '修改状态成功');
            vueApp.$emit('page.refresh', this.url);
          }else{
            toastrNotification('error',response.data.message);
          }
        }).catch(error => {
          toastrNotification('error', error);
        });
      },
      preview(content)
      {
        $('#content').html(content);
      }
    },
    mounted(){
    }
  }
</script>