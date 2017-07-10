<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2><strong>单位列表</strong></h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li class="active"><strong>单位列表</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <div class="ibox-title" style="height:65px;">
                            <search :url="url"></search>
                            <button class="btn btn-info" data-toggle="modal" data-target="#myModal2" @click="getParentBranches" v-if="permission.can('account.broker.add')">
                                新增单位
                            </button>
                        </div>

                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <order :column="'id'" :url="url" :tTitle="'序号'"></order>
                                    <order :column="'branch_id'" :url="url" :tTitle="'单位编号'"></order>
                                    <order :column="'branch_name'" :url="url" :tTitle="'单位名称'"></order>
                                    <th>上级单位名称</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in branches">
                                    <td>{{item.id}}</td>
                                    <td>{{item.branch_id}}</td>
                                    <td>{{item.branch_name}}</td>
                                    <td v-if="item.parent">{{item.parent.branch_name}}</td>
                                    <td v-else>没有上级单位</td>
                                    <td v-if="item.status==1">已启用</td>
                                    <td v-if="item.status==0">已禁用</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" @click="edit(item.id)" v-if="permission.can('account.broker.edit')">
                                            编辑
                                        </button>
                                        <button v-if="item.status==0 && permission.can('account.broker.delete')" class="btn btn-sm btn-info" @click="modifyStatus(item.id)">启用</button>
                                        <button v-if="item.status==1 && permission.can('account.broker.delete')" class="btn btn-sm btn-danger" @click="modifyStatus(item.id)">禁用</button>
                                        <button class="btn btn-sm btn-danger" @click="deleteBranch(item.id)" v-if="permission.can('account.broker.delete')">删除
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

        <div class="modal  fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title text-center">新增单位</h3>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="form-group col-lg-12">
                            <label class="col-lg-3 control-label text-right"><h3>单位名称:</h3></label>
                            <div class="col-lg-8">
                                <input type="text" v-model="branch.branch_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label text-right"><h3>上级单位：</h3></label>
                            <div class="col-lg-8">
                                <select class="form-control" v-model="branch.parent_id">
                                    <option v-for="item in parent_branches" :value="item.id">{{item.branch_name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="addBranch" class="btn btn-info">确定</button>
                        <button type="button" id="addBranch" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title text-center">编辑单位</h3>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="form-group col-lg-12">
                            <label class="col-lg-3 control-label text-right"><h3>单位名称:</h3></label>
                            <div class="col-lg-8">
                                <input type="text" v-model="branch.branch_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label text-right"><h3>上级单位：</h3></label>
                            <div class="col-lg-8">
                                <select class="form-control" v-model="branch.parent_id">
                                    <option v-for="item in parent_branches" :value="item.id">{{item.branch_name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" @click="editBranch" class="btn btn-info">确定
                            </button>
                            <button type="button" id="editBranch"  class="btn btn-default close-branch" data-dismiss="modal">关闭</button>
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
  import Order from  './../Common/OrderThead.vue'
  export default{
    data(){
      return {
        url: '/api/branch',
        branches: {},
        parent_branches:{},
        branch: {
          branch_name: '',
          parent_id: '',
        }
      }
    },
    components: {
      Search,
      Page,
      Order,
    },
    methods: {
      page(data){
        this.branches = data;
      },
      deleteBranch(id){
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
              axios.get('/api/branch/delete/' + id).then(response => {
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
        axios.get('/api/branch/modifyStatus/' + id).then(response => {
          if(response.data.code==200){
            toastrNotification('success', '修改状态成功');
            vueApp.$emit('page.refresh', this.url);
          }else{
            toastrNotification('error', response.data.message);
          }
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      getParentBranches(id=0){
        this.branch = {};
        axios.get('/api/branch/getParentBranches/'+id).then(response => {
          this.parent_branches = response.data;
          this.parent_branches.unshift({'branch_name':'','id':''});
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      edit(id){
        axios.get('/api/branch/edit/' + id).then(response => {
          this.branch = response.data;
        }).catch(error => {
          toastrNotification('error', error.message);
        });
        $('#myModal1').modal('show');
        this.getParentBranches(id);
      },
      editBranch(id){
        axios.post('/api/branch/edit', this.branch).then(response => {
          if(response.data.code==200) {
            $("#editBranch").trigger({type: "click"});
            toastrNotification('success', '编辑成功');
            vueApp.$emit('page.refresh', this.url);
          }else{
            toastrNotification('error', response.data.message);
          }
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      addBranch(){
        axios.post('/api/branch/add', this.branch).then(response => {
          if(response.data.code==200) {
            $("#addBranch").trigger({type: "click"});
            toastrNotification('success', '添加成功');
            vueApp.$emit('page.refresh', this.url);
          }else{
            toastrNotification('error', response.data.message);
          }
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
    },
    mounted(){
    }
  }

</script>