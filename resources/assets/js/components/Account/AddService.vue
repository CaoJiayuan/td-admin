<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>新增客服</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li>
                            <router-link to="/service">客服列表</router-link>
                        </li>
                        <li class="active"><strong>新增客服</strong></li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
                        <a class="button btn btn-info" @click="addService">保存</a>
                        <router-link to="/service">
                            <a class="button btn btn-danger">取消</a>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content col-lg-12">
                        <form enctype="multipart/form-data" class="form-horizontal">

                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label">单位编号</label>
                                <div class="col-lg-8">
                                    <multiselect
                                            id="admin-roles"
                                            v-model="service.id"
                                            :options="branch"
                                            placeholder="请选择单位编号"
                                            label="branch_id"
                                            :selectLabel="'点击选择'"
                                            :selectedLabel="'已选择'"
                                            :deselectLabel="'点击移除'"
                                            track-by="id">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label">客服姓名</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="service.name" placeholder="请输入客服姓名">
                                </div>
                            </div>
                            <div class="hr-line-dashed col-lg-12"></div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label">手机号码</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="service.mobile" placeholder="请输入手机号码">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label">客服邮箱</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="service.email" placeholder="请输入客服邮箱">
                                </div>
                            </div>
                            <div class="hr-line-dashed col-lg-12"></div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label">客服备注</label>
                                <div class="col-lg-8">
                                    <textarea rows="5" v-model="service.remarks" class="form-control col-lg-12 html ql-editor" placeholder="请输入客服备注信息"></textarea>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label">联系地址</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="service.address" placeholder="请输入联系地址">
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
  import Multiselect from 'vue-multiselect'
  export default{
    data(){
      return {
        url: '/api/service/getBranch',
        service:{
            id:'',
            branch_id:'',
            name:'',
            mobile:'',
            email:'',
            remarks:'',
            address:''
        },
        branches:{
            id:'',
            branch_id:''
        },
        branch:[],
      }
    },
    components: {
      Multiselect
    },
    methods: {
      page(data){
        this.branches = data;
      },
      getBranches(){
        axios.get('/api/service/updateBranch').then(response => {
            this.branchs = response.data;
            this.branch = response.data;
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      addService(){
        axios.post('/api/service/addService', this.service, this.service.id).then(response => {
           toastrNotification('success','添加成功');
           Vue.router.push('/service');
        }).catch(error => {
           toastrNotification('error', error.response.data.message);
        });
      }
    },
    mounted(){
    this.getBranches();
    }
  }
</script>