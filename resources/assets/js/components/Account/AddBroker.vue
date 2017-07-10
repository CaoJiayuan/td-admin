<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>添加客户经理</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li>
                            <router-link to="/broker">客户经理列表</router-link>
                        </li>
                        <li class="active"><strong>添加客户经理</strong></li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
                        <a class="button btn btn-info" @click="preservation">保存</a>
                        <router-link to="/broker"><a class="button btn btn-danger">取消</a></router-link>
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
                                <label class="col-lg-3 control-label"><span style="color:red">*</span>运营商编号</label>
                                <div class="col-lg-8">
                                    <select class="form-control" v-model="broker.operator_code">
                                        <option v-for="item in operators" :value="item.code">{{item.name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label"><span style="color:red">*</span>所属代理机构</label>
                                <div class="col-lg-8">
                                    <select class="form-control" v-model="broker.branch_id">
                                        <option v-for="item in branches" :value="item.id">{{item.branch_name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed col-lg-12"></div>

                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label"><span style="color:red">*</span>客户经理姓名</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="broker.broker_name">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label"><span style="color:red">*</span>身份证号</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="broker.cred_num">
                                </div>
                            </div>

                            <div class="hr-line-dashed col-lg-12"></div>

                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label"><span style="color:red">*</span>性别</label>
                                <div class="col-lg-8">
                                    <select class="form-control" v-model="broker.sex">
                                        <option value="1">女</option>
                                        <option value="0">男</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label"><span style="color:red">*</span>邮箱</label>
                                <div class="col-lg-8">
                                    <input type="email" class="form-control" v-model="broker.email">
                                </div>
                            </div>

                            <div class="hr-line-dashed col-lg-12"></div>

                            <div class="form-group col-lg-6">
                                <label class="col-sm-3 control-label"><span style="color:red">*</span>手机号码</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="broker.phone">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label">联系地址</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="broker.address">
                                </div>
                            </div>

                            <div class="hr-line-dashed col-lg-12"></div>

                            <div class="form-group col-lg-6">
                                <label class="col-sm-3 control-label">邮政编码</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="broker.zip_code">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-sm-3 control-label">联系电话</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="broker.mobile">
                                </div>
                            </div>

                            <div class="hr-line-dashed col-lg-12"></div>

                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label">传真号码</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="broker.fax">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label">备注</label>
                                <div class="col-lg-8">
                                    <textarea rows="2" class="form-control col-lg-12" v-model="broker.remark"></textarea>
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
        url: '/api/uploads',
        broker:{
          broker_name:'',
          operator_code:'1111',
          branch_id:'',
          sex: 1,
          cred_num:'',
          address:'',
          zip_code:'',
          phone:'',
          mobile:'',
          fax:'',
          email:'',
          remark:''
        },
        branches:{},
        operators:{},
      }
    },
    components: {
    },
    methods: {
      success(response){
        this.leader.img = response;
      },
      preservation(){
        axios.post('/api/broker/add', this.broker).then(response => {
          if(response.data.code==200) {
            toastrNotification('success', '添加成功');
            Vue.router.push('/broker');
          }else{
            toastrNotification('error', response.data.message);
          }

        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      getBranches(){
        axios.get('/api/broker/getBranches').then(response => {
            this.branches = response.data.branches;
            this.operators = response.data.operators;
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      }
    },
    computed: {
    },
    mounted(){
        this.getBranches();
    }
  }
</script>