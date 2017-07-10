<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>用户管理</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li class="active"><strong>用户列表</strong></li>
        </ol>
      </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <search :url="url" ></search>
              <span class="input-group-btn" v-if="permission.can('role.admin.add')">
                  <button type="button" class="btn btn-info" data-target="#add-admin" data-toggle="modal" @click="resetAdmin"> <i
                      class="fa fa-plus"></i>&nbsp; 添加用户</button>
              </span>
            </div>

            <div class="ibox-content">
              <table class="table table-bordered dataTable">
                <thead>
                <tr>
                  <order-thead :column="'id'" :tTitle="'序号'"></order-thead>
                  <order-thead :column="'name'"  :tTitle="'用户名称'"></order-thead>
                  <th>用户角色</th>
                  <th>手机号</th>
                  <th>邮箱地址</th>
                  <th v-if="permission.any('role.admin.delete','role.admin.edit')">操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.roles }}</td>
                  <td>{{ user.mobile }}</td>
                  <td>{{ user.email }}</td>
                  <td v-if="permission.any('role.admin.delete','role.admin.edit')">
                     <button v-if="permission.can('role.admin.edit')" class="btn btn-sm btn-info" data-target="#add-admin" data-toggle="modal"  @click="getAdmin(user.id)">编辑</button>
                     <button v-if="user.deletable && permission.can('role.admin.delete')" @click="deleteAdmin(user.id)" class="btn btn-sm btn-danger">删除</button>
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

    <div class="modal inmodal fade" id="add-admin" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body clearfix">
            <div class="form-horizontal" role="form">
              <div class="form-group">

                <div class="form-group">
                  <label for="admin-name" class="col-sm-2 control-label">用户姓名</label>
                  <div class="col-sm-10">
                    <input type="text" v-model="admin.name" class="form-control" id="admin-name" placeholder="输入用户姓名">
                  </div>
                </div>

                <div class="form-group">
                  <label for="admin-roles" class="col-sm-2 control-label">选择角色</label>
                  <div class="col-sm-10">
                    <multiselect
                        id="admin-roles"
                        v-model="admin.roles"
                        :options="roles"
                        placeholder="选择角色"
                        multiple="true"
                        :selectLabel="'点击选择'"
                        :selectedLabel="'已选择'"
                        :deselectLabel="'点击移除'"
                        :custom-label="customLabel"
                        track-by="id">
                    </multiselect>
                  </div>
                </div>
                <div class="form-group">
                  <label for="admin-mobile" class="col-sm-2 control-label">手机号</label>
                  <div class="col-sm-10">
                    <input type="text" v-model="admin.mobile" class="form-control" id="admin-mobile"
                           placeholder="输入手机号">
                  </div>
                </div>

                <div class="form-group">
                  <label for="admin-email" class="col-sm-2 control-label">邮箱地址</label>
                  <div class="col-sm-10">
                    <input type="text" v-model="admin.email" class="form-control" id="admin-email" placeholder="输入邮箱地址">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="role-admin-dismiss" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-info" @click="postAdmin">保存</button>
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
  import Multiselect from 'vue-multiselect';
  export default{
    created(){

    },
    data(){
      return {
        url  : '/api/permission/admins',
        users: [],
        roles: [],
        admin: {
          id    : 0,
          roles : [],
          name  : '',
          email : '',
          mobile: ''
        }
      }
    },
    components: {
      Paginator, Search, OrderThead, Multiselect
    },
    methods   : {
      page(data){
        this.users = data;
      },
      getRoles() {
        axios.get('/api/permission/roles?api=1').then(response => this.roles = response.data).catch(error => toastrNotification('error', error.response.data.message));
      },
      postAdmin(){
        axios.post('/api/permission/admins',this.admin).then(response => {
          $("#role-admin-dismiss").trigger({type: "click"});
          toastrNotification('success', '保存成功!');
          vueApp.$emit('page.refresh')
        }).catch(error => toastrNotification('error', error.response.data.message))
      },
      getAdmin(id) {
        axios.get('/api/permission/admins/'+id).then(response => this.admin = response.data).catch(error => toastrNotification('error', error.response.data.message));
      },
      resetAdmin(){
        this.admin = {
          id    : 0,
          roles : [],
          name  : '',
          email : '',
          mobile: ''
        };
      },
      deleteAdmin(id) {
        deleteAlert('/api/permission/admins/'+id, data => {
          vueApp.$emit('page.refresh')
        })
      },
      customLabel({name, display_name}) {
        return null != display_name ? display_name : name;
      }
    },
    mounted(){
      this.getRoles();
    }
  }
</script>