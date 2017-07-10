<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>添加联系方式</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li>
                            <router-link to="/contacts">联系方式列表</router-link>
                        </li>
                        <li class="active"><strong>添加联系方式</strong></li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
                        <a class="button btn btn-info" @click="preservation">保存</a>
                        <router-link to="/contacts"><a class="button btn btn-danger">取消</a></router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content">
                        <form enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">联系方式名称</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="contact.key">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">联系方式</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="contact.value">
                                </div>
                            </div>
                        </form>
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
        contact:{
         key:'',
         value:'',
       }
      }
    },
    components: {
    },
    methods: {
      preservation(){
        axios.post('/api/contacts/add', this.contact).then(response => {
          toastrNotification('success', '添加成功');
          Vue.router.push('/contacts');
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      }
    },
    computed: {
    },
    mounted(){

    }
  }
</script>