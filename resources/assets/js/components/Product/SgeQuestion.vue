<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>问题详解</h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li>
                        <router-link to="/sge">上金所介绍目录列表</router-link>
                    </li>
                    <li class="active"><strong>问题列表</strong></li>
                </ol>
            </div>
            <div class="col-lg-4">
                <div class="title-action">
                    <router-link to="/sge">
                    <button class="btn btn-info">返回</button>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title" style="height:65px;">
                            <search :url="url" :onSearch="onSearch"></search>
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addModal" @click="remove"><i class="fa fa-plus"></i>&nbsp; 新增问题</button>
                            </span>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th>问题名称</th>
                                    <order-thead :column="'created_at'" :url="url" :tTitle="'操作时间'"></order-thead>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in detail">
                                    <td>{{ item.question }}</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" @click="show(item)">编辑</button>
                                        <button type="button" class="btn btn-danger btn-sm" @click="delStatus(item.id)">删除</button>
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

        <div class="modal fade" id="myModal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="width: 700px;">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-group" style="margin-left: 15px">
                            <label>编辑问题:</label>
                            <input type="text" v-model="item.question" class="form-control" style="width: 610px">
                        </div>
                        <div class="form-group">
                            <div class="html ql-editor">
                            <label>编辑答案:</label>
                            <quill-editor ref="myTextEditor"
                                          v-model="item.answer"
                                          :config="editorOption"
                                          @blur="onEditorBlur($event)"
                                          @focus="onEditorFocus($event)"
                                          @ready="onEditorReady($event)">
                            </quill-editor>
                        </div>
                            <div style="margin-top: 5px;">
                                <div class="col-lg-12 text-right" style="padding-right:15px;">
                                    <button type="button" class="btn btn-info btn-sm" @click="editQuestion(item.id)">保存</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" @click="quit" id="close">取消</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addModal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title text-center">新增问题</h2>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><strong>问题名称:</strong></label>
                            <input type="text" v-model="resource.question" class="form-control" placeholder="请输入问题名称" id="remove">
                        </div>
                        <div class="form-group">
                            <label><strong>问题答案:</strong></label>
                            <textarea style="height:200px;" class="form-control html ql-editor" row="20" cols="75" v-model="resource.answer" placeholder="请输入答案内容" id="removes"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-sm" @click="addQuestion">保存
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" @click="quit" id="quesmiss">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.height{
     line-height: 36px;
}
</style>
<script>
    import Paginator from '../Common/Paginator.vue';
    import OrderThead from '../Common/OrderThead.vue';
    import Search from '../Common/Search.vue';
    import { quillEditor } from 'vue-quill-editor';
    export default{
        created(){

        },
        data(){
            return {
                editorOption:{
                placeholder:'请输入答案内容'
                },
                resource:{
                question:'',
                answer:'',
                sge_catalog_id:'',
                code:[],
                },
                detail: {},
                item:{
                question:'',
                answer:'',
                code:[],
                },
                url  : '/api/sge/sgeCataDetail/'+ this.$route.params.id
            }
        },
        components: {
            Paginator,Search,OrderThead,quillEditor
        },
        methods   : {
            addQuestion(){
               this.resource.sge_catalog_id = this.$route.params.id
                axios.post('/api/sge/addQuestion', this.resource).then(response => {
                   $("#quesmiss").trigger({type: "click"});
                   toastrNotification('success','添加成功');
                   vueApp.$emit('page.refresh',self.url)
                   this.resource.code = response.data;
                }).catch(error => {
                   toastrNotification('error', error.response.data.message);
        });
            },
            editQuestion(id){
               axios.put('/api/sge/editSgeQuestion/'+id,this.item).then(response =>{
                $("#close").trigger({type: "click"});
                 toastrNotification('success','编辑成功');
                  vueApp.$emit('page.refresh',this.url)
                   this.item.code = response.data;
             }).catch(error =>{
                 toastrNotification('error',error.response.data.message);
                  vueApp.$emit('page.refresh', self.url);
             });
            },
            quit(){
                 vueApp.$emit('page.refresh',this.url)
            },
            remove(){
                 $('#remove').prop('value','');
                 $('#removes').prop('value','');
            },
            page(data){
                this.detail = data;
            },
            onSearch (url) {
                this.url = url;
                vueApp.$emit('page.refresh', url)
            },
            show(item){
                this.item = item;
            },
            delStatus(id){
                let self = this;
                var opts = {
                    title: '确定刪除?',
                    text: '你将无法恢复所删除数据!',
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
                            axios.delete('/api/sge/delQuestion/'+id).then(response=>{
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
                            sweetAlert("取消", "数据没有刪除!", "error");
                        }
                    });
            },
            onEditorBlur(editor) {
            },
            onEditorFocus(editor) {
            },
            onEditorReady(editor) {
            },
            onEditorChange({ editor, html, text }) {
                console.log(html);
                this.item.answer = html;
              }
            },

            computed: {
            editor() {
               return this.$refs.myTextEditor.quillEditor
              }
            },

            mounted(){

            }
    }
</script>