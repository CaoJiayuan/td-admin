<template>
<div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2><strong>客服列表</strong></h2>
            <ol class="breadcrumb">
                <li>
                    <router-link to="/">首页</router-link>
                </li>
                <li class="active"><strong>客服列表</strong></li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="height:65px;">
                        <search :url="url" :onSearch="onSearch"></search>
                        <router-link to="/service/add">
                            <button class="col-md-2 btn btn-info" style="width: 100.28px;">
                                <i class="fa fa-plus"></i>&nbsp; 新增客服
                            </button>
                        </router-link>
                        <div class="form-group col-md-4" style="margin-bottom: 0px;">
                            <span class="col-md-4 text-right" id="lineh">单位编号</span>
                            <div class="col-md-8">
                                <multiselect
                                  v-model="branch.id"
                                  :options="branch"
                                  :hide-selected="true"
                                  placeholder="请选择单位编号"
                                  label="branch_id"
                                  :selectLabel="'点击选择'"
                                  track-by="id"
                                  @close="showBranchs(branch.id.id)">
                                </multiselect>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-bordered dataTable">
                            <thead>
                              <tr>
                                <order :column="'admins.id'" :url="url" :tTitle="'客服编号'"></order>
                                <th>客服姓名</th>
                                <order :column="'branchs.branch_id'" :url="url" :tTitle="'单位编号'"></order>
                                <th>手机号</th>
                                <th class="col-lg-2">邮箱</th>
                                <th class="col-lg-2">地址</th>
                                <th class="col-lg-2">操作</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in services">
                                <td>{{item.id}}</td>
                                <td>{{item.name}}</td>
                                <td>{{item.branch_id}}</td>
                                <td>{{item.mobile}}</td>
                                <td>{{item.email}}</td>
                                <td>{{item.address}}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-toggle="modal"
                                            data-target="#myModal" @click="show(item)">查看
                                    </button>
                                    <router-link :to="{ name: 'service/edit', params: { id: item.id }}">
                                        <button class="btn btn-sm btn-info">编辑</button>
                                    </router-link>
                                    <button class="btn btn-sm btn-danger" @click="delCustomer(item.id)">删除
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
    <!--预览-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center"><strong>客服信息</strong></h3>
                </div>
                <div class="modal-body">
                    <div class="modal-content col-lg-12">
                        <div class="hr-line-dashed col-lg-12" style="border: none;margin-bottom: 5px;"></div>
                        <div class="col-lg-12">
                            <span class="col-lg-6"><label>单位编号:&emsp;</label> {{item.branch_id}}</span>
                            <span class="col-lg-6"><label>客服编号:&emsp;</label> {{item.id}}</span>
                        </div>
                        <div class="hr-line-dashed col-lg-12"></div>
                        <div class=" col-lg-12">
                            <span class="col-lg-6"><label>手机号码:&emsp;</label> {{item.mobile}}</span>
                            <span class="col-lg-6"><label>客服姓名:&emsp;</label> {{item.name}}</span>
                        </div>
                        <div class="hr-line-dashed col-lg-12"></div>
                        <div class=" col-lg-12">
                            <span class="col-lg-6"><label>客服邮箱:&emsp;</label>{{item.email}}</span>
                        </div>
                        <div class="hr-line-dashed col-lg-12"></div>
                        <div class="col-lg-12">
                            <span class="col-lg-12"><label>联系地址:&emsp;</label>{{item.address}}</span>
                        </div>
                        <div class="hr-line-dashed col-lg-12"></div>
                        <div class="col-lg-12 html ql-editor" style="margin-top: -10px">
                            <div><label class="col-lg-12">备注信息:</label></div>
                            <div><span class="col-lg-12" style="margin-top: -15px">{{item.remarks}}</span></div>
                        </div>
                    </div>
                    <div class="form-footer text-right">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"
                                style="margin-top: 15px">关闭
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--预览结束-->
</div>
</template>
<style>
    #lineh{
        height: 40px;
        line-height: 40px;
    }
</style>
<script>
    import Search from './../Common/Search.vue'
    import Page from './../Common/Paginator.vue'
    import Order from  './../Common/OrderThead.vue'
    import Multiselect from 'vue-multiselect'
    export default{
        data(){
            return {
                url: '/api/service/getServices',
                services: {
                    id: '',
                    name: '',
                    branch_id: '',
                    mobile: '',
                    email: '',
                    address: '',
                    remarks: ''
                },
                item: {},
                branch: [],
            }
        },
        components: {
            Search,
            Page,
            Order,
            Multiselect,
        },
        methods: {
            page(data){
                this.services = data;
            },
            onSearch (url) {
                this.url = url;
                vueApp.$emit('page.change', url)
            },
            show(item){
                this.item = item;
            },
            getBranches(){
                axios.get('/api/service/getBranches').then(response => {
                    this.branch = response.data;
                }).catch(error => {
                    toastrNotification('error', error.response.data.message);
                });
            },
            showBranchs(branchId){
                axios.get('/api/service/showBranch/' + branchId).then(response => {
                    if (branchId == 0 && response.data.total == 0) {
                        this.url = '/api/service/getServices';
                        Vue.router.push('/service');
                        return false;
                    }
                    if (response.data.total == 0 && branchId != 0) {
                        this.url = '/api/service/getServices';
                        Vue.router.push('/service');
                        toastrNotification('success', '该单位下没有员工,特为你查出所有信息');
                    } else {
                        this.url = '/api/service/showBranch/' + branchId;
                    }
                });
                axios.get('/api/service/showBranch/' + branchId).then(response => {
                    this.url = '/api/service/showBranch/' + branchId;
                    vueApp.$emit('page.refresh', this.url);
                });
            },
            delCustomer(id){
                let self = this;
                var opts = {
                    title: '删除该客服并清除其下所有客户!',
                    text: '确认删除?',
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
                          axios.delete('/api/service/serviceDel/' + id).then(response=> {
                              sweetAlert(
                                '已经删除!',
                                '数据已经被删除!',
                                'success'
                              );
                              vueApp.$emit('page.refresh', self.url)
                          }).catch(error => {
                              toastrNotification('error', error.response.data.message);
                          });
                      } else {
                          sweetAlert("取消", "数据没有被删除!", "error");
                      }
                  });
            },
        },
        mounted(){
            this.getBranches();
        }
    }
</script>
