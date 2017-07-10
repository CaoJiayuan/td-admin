<template>
  <div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
        <form role="search" class="navbar-form-custom">
          <div class="form-group">

          </div>
        </form>
      </div>
      <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
          <a type="button" class="dropdown-toggle" data-toggle="dropdown">您好 <strong>{{ user.name }}</strong></a>
          <ul class="dropdown-menu">
            <li data-toggle="modal" data-target="#edit-admin">
              <i class="fa fa-user"></i>
              <span> 个人设置</span>
            </li>
            <li data-toggle="modal" data-target="#pass-admin" @click="resetPass">
              <i class="fa fa-lock"></i>
              <span> 修改密码</span>
            </li>
            <li @click="logout">
              <i class="fa fa-sign-out"></i>
              <span> 退出</span>
            </li>
          </ul>
        </li>
      </ul>
    </nav>

    <div class="modal inmodal fade" id="edit-admin" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body clearfix">
            <div class="form-horizontal" role="form">
              <div class="form-group">
                <div class="form-group">
                  <label for="admin-name" class="col-sm-2 control-label">用户姓名</label>
                  <div class="col-sm-10">
                    <input type="text" v-model="user.name" class="form-control" id="admin-name" placeholder="输入用户姓名">
                  </div>
                </div>
                <div class="form-group">
                  <label for="admin-mobile" class="col-sm-2 control-label">手机号</label>
                  <div class="col-sm-10">
                    <input type="text" v-model="user.mobile" class="form-control" id="admin-mobile"
                           placeholder="输入手机号">
                  </div>
                </div>
                <div class="form-group">
                  <label for="admin-email" class="col-sm-2 control-label">邮箱地址</label>
                  <div class="col-sm-10">
                    <input type="text" v-model="user.email" class="form-control" id="admin-email" placeholder="输入邮箱地址">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="admin-dismiss" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-primary" @click="editAdmin">保存</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal inmodal fade" id="pass-admin" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body clearfix">
            <div class="form-horizontal" role="form">
              <div class="form-group">
                <div class="form-group">
                  <label for="admin-oldpass" class="col-sm-2 control-label">原密码</label>
                  <div class="col-sm-10">
                    <input type="password" v-model="user.old_pass" class="form-control" id="admin-oldpass" placeholder="输入原密码">
                  </div>
                </div>
                <div class="form-group">
                  <label for="admin-pass" class="col-sm-2 control-label">新密码</label>
                  <div class="col-sm-10">
                    <input type="password" v-model="user.password" class="form-control" id="admin-pass"
                           placeholder="输入新密码">
                  </div>
                </div>
                <div class="form-group">
                  <label for="admin-pass-com" class="col-sm-2 control-label">确认密码</label>
                  <div class="col-sm-10">
                    <input type="password" v-model="user.password_confirmation" class="form-control" id="admin-pass-com" placeholder="再次输入新密码">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="pass-dismiss" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-primary" @click="setPass">保存</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>

</style>
<script>
  export default{
    created(){

    },
    data(){
      return {
        user: {}
      }
    },
    components: {},
    methods   : {
      logout(){
        Auth.logout();
      },
      fetchUser(){
        Auth.user(user => this.user = user);
      },
      editAdmin (){
        axios.post('/api/permission/admin', this.user).then(response => {
          $("#admin-dismiss").trigger({type: "click"});
          this.fetchUser();
          toastrNotification('success', '保存成功!');
        }).catch(error => toastrNotification('error', error.response.data.message))
      },
      setPass(){
        axios.post('/api/permission/admin/password', this.user).then(response => {
          $("#pass-dismiss").trigger({type: "click"});
          this.fetchUser();
          toastrNotification('success', '保存成功!');
        }).catch(error => toastrNotification('error', error.response.data.message))
      },
      resetPass(){
        this.user.old_pass = '';
        this.user.password = '';
        this.user.password_confirmation = '';
        document.getElementById('admin-oldpass').value = '';
        document.getElementById('admin-pass').value = '';
        document.getElementById('admin-pass-com').value = '';
      }
    },
    mounted(){
      this.fetchUser();
    }
  }
</script>