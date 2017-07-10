<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>客户列表</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li class="active"><strong>客户列表</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title" style="height:120px;">
                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label" style="margin-top: 8px">是否开户</label>
                                <div class="col-lg-8">
                                    <select class="form-control col-lg-12" v-model="isOpen">
                                        <option value="0">全部</option>
                                        <option value="1">是</option>
                                        <option value="2">否</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="col-lg-3 control-label" style="margin-top: 8px">选择单位</label>
                                <div class="col-lg-8">
                                    <select class="form-control col-lg-12" v-model="selectedBranch">
                                        <option value=""></option>
                                        <option v-for="item in branches" :value="item.id">{{item.branch_name}}({{item.branch_id}})</option>
                                    </select>
                                </div>
                            </div>

                            <search :url="url"></search>
                            <div class="col-md-2">
                                <button class="btn btn-info" @click="getBroker(0)" v-if="permission.can('account.account.setBroker')">
                                    分配客户经理
                                </button>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="i-checks">
                                            <label>
                                                <input type="checkbox" value="" v-model="isAll">
                                            </label>
                                        </div>
                                    </th>
                                    <order :column="'user.nick_name'" :url="url" :tTitle="'用户名'"></order>
                                    <th>姓名</th>
                                    <order :column="'user.phone'" :url="url" :tTitle="'手机号'"></order>
                                    <th>身份证号</th>
                                    <th>客户经理编号</th>
                                    <th>客户经理姓名</th>
                                    <th>开户</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in accounts">
                                    <td>
                                        <div class="i-checks" v-if="item.gold_num">
                                            <label>
                                                <input type="checkbox" :value="item.id" v-model="users_id">
                                            </label>
                                        </div>
                                    </td>
                                    <td v-if="item.nick_name">{{item.nick_name}}</td>
                                    <td v-else>未设置</td>
                                    <td v-if="item.name">{{item.name}}</td>
                                    <td v-else-if="item.real_name">{{item.real_name}}</td>
                                    <td v-else>未设置</td>
                                    <td>{{item.phone}}</td>
                                    <td v-if="item.cred_num">{{item.cred_num}}</td>
                                    <td v-else>未设置</td>
                                    <td v-if="item.broker_id">{{item.broker_id}}</td>
                                    <td v-else>未设置</td>
                                    <td v-if="item.broker_name">{{item.broker_name}}</td>
                                    <td v-else>未设置</td>
                                    <td v-if="item.gold_num">是</td>
                                    <td v-else>否</td>
                                    <td v-if="item.gold_num">
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#debits"
                                                @click="getDebits(item.id)"
                                                v-if="permission.can('account.account.debits')">账户详情
                                        </button>

                                        <router-link :to="{ name: 'account/transfers', params: { id: item.id }}">
                                            <button class="btn btn-sm btn-info"
                                                    v-if="permission.can('account.account.transfers')">转账明细
                                            </button>
                                        </router-link>

                                        <router-link :to="{ name: 'account/capital', params: { id: item.id }}">
                                            <button class="btn btn-sm btn-info"
                                                    v-if="permission.can('account.account.capital')">资金流水
                                            </button>
                                        </router-link>
                                    </td>
                                    <td v-else>
                                        <button class="btn btn-sm btn-info" disabled="disabled"
                                                v-if="permission.can('account.account.debits')">账户详情
                                        </button>

                                        <button class="btn btn-sm btn-info" disabled="disabled"
                                                v-if="permission.can('account.account.transfers')">转账明细
                                        </button>

                                        <button class="btn btn-sm btn-info" disabled="disabled"
                                                v-if="permission.can('account.account.capital')">资金流水
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
        <debits :debits="debits"></debits>

        <div class="modal fade" id="setBrokers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body clearfix">
                        <div class="form-group" style="margin-bottom: 50px">
                            <label class="col-lg-3 control-label">客户经理所属单位</label>
                            <div class="col-lg-8">
                                <select class="form-control" v-model="branch_id">
                                    <option v-for="item in branches" :value="item.id">{{item.branch_name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">客户经理</label>
                            <div class="col-lg-8">
                                <select class="form-control" v-model="broker_id">
                                    <option v-for="item in brokers" :value="item.id">{{item.broker_name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="setBroker" class="btn btn-info">确定</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
  import Search from './../Common/Search.vue'
  import Page from './../Common/Paginator.vue'
  import Order from './../Common/OrderThead.vue'
  import Debits from './DebitsModal.vue'
  export default{
    created(){

    },
    data(){
      return {
        url: '/api/account',
        brokers: {},
        branches: {},
        users_id: [],
        broker_id: '',
        branch_id: '',
        isOpen: 0,
        selectedBranch:'',
        isAll: false,
        accounts: {},
        capital_url: '',
        transfers_url: '',
        debits: {
          goldAccount: {
            auth: {
              app_identifier: ''
            },
            bank: {
              comment: ''
            }
          }
        },
      }
    },
    components: {
      Search,
      Page,
      Order,
      Debits,
    },
    watch: {
      isAll: function (isAll) {
        if (isAll) {
          var self = this;
          $.each(this.accounts, function (key, value) {
            if (value.gold_num) {
              self.users_id.push(value.id);
            }
          })
        } else {
          this.users_id = [];
        }
      },
      isOpen: function (isOpen) {
        vueApp.$emit('page.query', {isOpen: this.isOpen,selectedBranch: this.selectedBranch});
        this.url = '/api/account?isOpen=' + this.isOpen + this.selectedBranch;
      },
      branch_id: function () {
        this.getBroker(this.branch_id);
      },
      selectedBranch:function(selectedBranch){
        vueApp.$emit('page.query', {isOpen: this.isOpen,selectedBranch: this.selectedBranch});
        this.url = '/api/account?isOpen=' + this.isOpen + this.selectedBranch;
      }
    },
    methods: {
      page(data){
        this.accounts = data;
      },
      getBroker(branch){
        if(!this.users_id.length)
        {
          toastrNotification('error', '请选择客户');
          return false;
        }
        axios.get('/api/account/getBroker/' + branch).then(response => {
          this.brokers = response.data.brokers;
          this.branches = response.data.branches;
          $('#setBrokers').modal('show');
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      setBroker(){
        var data = {};
        data.users_id = this.users_id;
        data.broker_id = this.broker_id;
        axios.post('/api/account/setBroker', data).then(response => {
          toastrNotification('success', '设置客户经理成功');
          this.isOpen = 0;
          vueApp.$emit('page.refresh', this.url);
          this.users_id = [];
          this.isAll = false;
          $('#setBrokers').modal('hide');
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      getDebits(id){
        axios.get('/api/account/debits/' + id).then(response => {
          this.debits = response.data
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
    mounted(){
      this.getBranches();
    },
  }
</script>