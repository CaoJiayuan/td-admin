<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2><strong>客户经理列表</strong></h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li class="active"><strong>客户经理列表</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <div class="ibox-title" style="height:65px;">
                            <div class="form-group col-lg-4">
                                <label class="col-lg-3 control-label" style="margin-top: 8px">选择单位</label>
                                <div class="col-lg-8">
                                    <select class="form-control col-lg-12" v-model="selectedBranch">
                                        <option value=""></option>
                                        <option v-for="item in branches" :value="item.id">{{item.branch_name}}({{item.branch_id}})</option>
                                    </select>
                                </div>
                            </div>
                            <search :url="url"></search>
                            <router-link to="/broker/add" v-if="permission.can('account.broker.add')">
                                <button class="btn btn-info">新增客户经理</button>
                            </router-link>
                        </div>

                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <order :column="'broker_name'" :url="url" :tTitle="'姓名'"></order>
                                    <th>手机号</th>
                                    <th class="col-lg-1">身份证号</th>
                                    <th>性别</th>
                                    <order :column="'broker_id'" :url="url" :tTitle="'客户经理编号'"></order>
                                    <th class="col-lg-1">单位编号</th>
                                    <th>客户数量</th>
                                    <th>状态</th>
                                    <th class="col-lg-2">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in brokers">
                                    <td>{{item.broker_name}}</td>
                                    <td>{{item.phone}}</td>
                                    <td>{{item.cred_num}}</td>
                                    <td v-if="item.sex">女</td>
                                    <td v-else>男</td>
                                    <td>{{item.broker_id}}</td>
                                    <td>{{item.branch.branch_id}}</td>
                                    <td>{{item.account_count.length}}</td>
                                    <td v-if="item.status==1">已启用</td>
                                    <td v-if="item.status==0">已禁用</td>
                                    <td>
                                        <router-link :to="{ name: 'broker/edit', params: { id: item.id }}">
                                            <button class="btn btn-sm btn-info">编辑</button>
                                        </router-link>
                                        <button v-if="item.status==0 && permission.can('account.broker.delete')" class="btn btn-sm btn-info"
                                                @click="modifyStatus(item.id)">启用
                                        </button>
                                        <button v-if="item.status==1 && permission.can('account.broker.delete')" class="btn btn-sm btn-danger"
                                                @click="modifyStatus(item.id)">禁用
                                        </button>
                                        <button class="btn btn-sm btn-danger" @click="deleteBroker(item.id)" v-if="permission.can('account.broker.delete')">删除
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
    </div>
</template>

<script>
  import Search from './../Common/Search.vue'
  import Page from './../Common/Paginator.vue'
  import Order from  './../Common/OrderThead.vue'
  export default{
    data(){
      return {
        url: '/api/broker',
        brokers: {},
        branches: {},
        selectedBranch:'',
      }
    },
    components: {
      Search,
      Page,
      Order,
    },
    methods: {
      page(data){
        this.brokers = data;
      },
      deleteBroker(id){
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
              axios.get('/api/broker/delete/' + id).then(response => {
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
        axios.get('/api/broker/modifyStatus/' + id).then(response => {
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
      getBranches()
      {
        axios.get('/api/account/getBranches').then(response=>{
          this.branches = response.data;
        }).catch(error=>{
          toastrNotification('error', error.message);
        });
      }
    },
    watch:{
      selectedBranch:function(selectedBranch){
        vueApp.$emit('page.query', {selectedBranch: this.selectedBranch});
        this.url = '/api/broker?selectedBranch='+this.selectedBranch;
      }
    },
    mounted(){
      this.getBranches();
    }
  }

</script>