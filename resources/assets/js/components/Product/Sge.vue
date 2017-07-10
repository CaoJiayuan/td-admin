<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>上金所介绍目录列表</h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li class="active"><strong>目录列表</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <search :url="url" :onSearch="onSearch"></search>
                            <span class="input-group-btn">
                              <button @click="remove" type="button" class="btn btn-info" data-target="#myModal" data-toggle="modal"> <i class="fa fa-plus"></i>&nbsp; 新增目录</button>
                            </span>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th>目录名称</th>
                                    <order-thead :column="'updated_at'" :url="url" :tTitle="'操作时间'"></order-thead>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in sge">
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.updated_at }}</td>
                                    <td class="vuetable-actions center aligned">
                                        <button type="button" @click="show(item)" class="btn btn-info btn-sm" data-target="#myModal2" data-toggle="modal">编辑</button>
                                        <router-link :to="{ name: '/sge/sgeQuestion', params: { id: item.id }}">
                                            <button type="button" class="btn btn-info btn-sm">编辑问题</button>
                                        </router-link>
                                        <button @click="delSgeCate(item.id)" type="button" class="btn btn-danger btn-sm">删除</button>
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

        <div class="modal fade" id="myModal" tabindex="-1"  role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title text-center">新增目录</h3>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="form-group col-lg-12">
                            <label class="col-lg-3 control-label text-right">
                                <strong class="height">目录名称:</strong>
                            </label>
                            <div class="col-lg-8">
                                <input type="text" v-model="sgeCate.name" class="form-control" id="remove" placeholder="请输入目录名称">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-sm" @click="addSgeCate">确定</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="sgemiss">取消</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal2" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title text-center">编辑目录</h3>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="form-group col-lg-12">
                            <label class="col-lg-3 control-label text-right">
                                <strong class="height">目录名称:</strong>
                            </label>
                            <div class="col-lg-8">
                                <input type="text" v-model="item.name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="editSgeCate(item.id)" class="btn btn-info btn-sm">确定</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="sgemiss2" @click="quit">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .height{
        line-height:36px;
    }
</style>
<script>
    import Paginator from '../Common/Paginator.vue';
    import OrderThead from '../Common/OrderThead.vue';
    import Search from '../Common/Search.vue';
    export default{
        created(){

        },
        data(){
            return {
                sge: {},
                sgeCate:{
                    name:'',
                },
                item:{
                    name:'',
                    code:[],
                },
                url  : '/api/sge'
            }
        },
        components: {
            Paginator,OrderThead,Search
        },
        methods   : {
            page(data){
                this.sge = data;
            },
            onSearch (url) {
                this.url = url;
            },
            addSgeCate(){
                axios.post('/api/sge/addSgeCate',this.sgeCate).then(response =>{
                    $("#sgemiss").trigger({type: "click"});
                    toastrNotification('success','添加成功');
                    vueApp.$emit('page.refresh',self.url)
                }).catch(error => {
                    toastrNotification('error', error.response.data.message);
                });
            },
            show(item){
                this.item = item;
            },
            remove(){
                $('#remove').val('');
            },
            quit(){
                vueApp.$emit('page.refresh',self.url)
            },
            editSgeCate(id){
                axios.put('/api/sge/editSgeCate/'+id,this.item).then(response =>{
                    toastrNotification('success','修改成功');
                    vueApp.$emit('page.refresh',this.url)
                    $("#sgemiss2").trigger({type: "click"});
                    this.item.code = response.data;
                }).catch(error =>{
                    toastrNotification('error',error.response.data.message);
                    Vue.router.push('/sge');
                });
            },
            delSgeCate(id){
                let self = this;
                var opts = {
                    title: '确定删除?',
                    text: '你将无法恢复所删数据!',
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
                            axios.delete('/api/sge/delSgeCate/'+id).then(response=>{
                                sweetAlert(
                                    '已经删除!',
                                    '数据已经被删除!',
                                    'success'
                                );
                                vueApp.$emit('page.refresh',self.url)
                            }).catch(error =>{
                                toastrNotification('error',error);
                            });
                        } else {
                            sweetAlert("取消", "数据没有删除!", "error");
                        }
                    });
            }
        },
        mounted(){

        }
    }
</script>

