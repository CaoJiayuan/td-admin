<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>角色管理</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li class="active"><strong>角色配置</strong></li>
        </ol>
      </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <search :url="url"></search>
              <span class="input-group-btn" v-if="permission.can('role.role.add')">
                  <button type="button" class="btn btn-info" data-target="#add-role" data-toggle="modal"
                          @click="resetRole"> <i
                      class="fa fa-plus"></i>&nbsp; 添加角色</button>
              </span>
            </div>

            <div class="ibox-content">
              <table class="table table-bordered dataTable">
                <thead>
                <tr>
                  <order-thead :column="'id'" :tTitle="'序号'"></order-thead>
                  <order-thead :column="'name'" :tTitle="'角色名称'"></order-thead>
                  <th>角色权限</th>
                  <th class="option-th" v-if="permission.any('role.role.edit', 'role.role.delete')">操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="role in roles">
                  <td>{{ role.id }}</td>
                  <td>{{ null != role.display_name ? role.display_name : role.name }}</td>
                  <td>{{ role.permissions }}</td>
                  <td v-if="false == role.edit_able && permission.any('role.role.edit', 'role.role.delete')">不可编辑</td>
                  <td v-if="false != role.edit_able && permission.any('role.role.edit', 'role.role.delete')">
                    <button v-if="permission.can('role.role.edit')" class="btn btn-sm btn-info" data-target="#add-role"
                            data-toggle="modal" @click="getRole(role.id)">编辑
                    </button>
                    <button v-if="false != role.delete_able && permission.can('role.role.delete')"
                            class="btn btn-sm btn-danger" @click="deleteRole(role.id)">删除
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

    <div class="modal inmodal fade" id="add-role" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body clearfix">
            <div class="form-horizontal" role="form">
              <div class="form-group">
                <div class="form-group">
                  <label for="role-name" class="col-sm-2 control-label">角色名</label>
                  <div class="col-sm-10" v-if="role.change_name">
                    <input type="text" v-model="role.name" class="form-control" id="role-name" placeholder="输入角色名">
                  </div>
                  <div class="col-sm-10 form-control-static" v-if="!role.change_name">
                    {{ role.name }}
                  </div>
                </div>
                <div class="treeview">
                  <ul class="list-group">
                    <tree :data="data" v-for="data in role.permissions"></tree>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="role-dismiss" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-info" @click="postRole">保存</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
<style>

</style>
<script type="application/ecmascript">
  import Paginator from '../Common/Paginator.vue';
  import OrderThead from '../Common/OrderThead.vue';
  import Search from '../Common/Search.vue';
  import Tree from '../Common/Tree.vue';
  import Pbutton from '../Common/Pbutton.vue';
  export default{
    created(){

    },
    data(){
      return {
        roles  : {},
        role   : {
          name        : '',
          display_name: '',
          permissions : [],
          change_name : true
        },
        url    : '/api/permission/roles',
        actions: {
          del: 'role.delete'
        }
      }
    },
    components: {
      Paginator, Search, OrderThead, Tree, Pbutton
    },
    methods   : {
      page(data){
        this.roles = data;
      },
      postRole(){
        let self = this;
        axios.post('/api/permission/role', this.role).then(response => {
          $("#role-dismiss").trigger({type: "click"});
          vueApp.$emit('page.refresh', self.url);
          toastrNotification('success', '保存成功!');
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      resetRole(){
        this.role = {
          name        : '',
          display_name: '',
          permissions : [],
          change_name : true
        };
        axios.get('/api/permission/tree').then(response => {
          this.role.permissions = response.data;
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      deleteRole(id){
        deleteAlert('/api/permission/roles/' + id, data => {
          vueApp.$emit('page.refresh')
        })
      },
      getRole(id) {
        axios.get('/api/permission/roles/' + id).then(response => {
          this.role = response.data;
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      }
    },
    mounted(){

    }
  }
</script>