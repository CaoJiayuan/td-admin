<template>
  <div class="container animated fadeInUp">
    <div class="row" style="margin-top: 50px">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default well">
          <h1 class="header">登录</h1>
          <div class="panel-body">
            <div role="form">
              <div class="form-group label-floating">
                <label for="email" class="control-label">请输入邮箱</label>
                <input v-model="credentials.email" type="email" class="form-control" id="email">
              </div>
              <div class="form-group label-floating">
                <label for="password" class="control-label">请输入密码</label>
                <input id="password" v-model="credentials.password" type="password" class="form-control" name="password">
              </div>
              <div class="form-group">
                <div class="col-md-4">
                  <button type="button" @click="postLogin" class="btn btn-primary btn-raised" id="post-login">
                    登录
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default{
    created(){

    },
    data(){
      return {
        credentials: {
          email   : '',
          password: '',
          remember: false,
        }
      }
    },
    components: {},
    methods   : {
      postLogin(){
        Auth.attempt('/login', this.credentials, '/')
      }
    },
    mounted(){
//      $.material.init();
      document.body.style.backgroundColor = 'white'
    }
  }
</script>