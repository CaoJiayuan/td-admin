<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>编辑产品</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li>
            <router-link to="/products">产品列表</router-link>
          </li>
          <li class="active"><strong>编辑产品</strong></li>
        </ol>
      </div>
        <div class="col-lg-4">
            <div class="title-action">
                <button class="btn btn-info" data-toggle="modal"  data-target="#myModal">
                    预览
                </button>
                    <button class="btn btn-info" data-toggle="modal" @click="editProduct(resource.id)">
                        保存
                    </button>
                <router-link to="/products">
                    <button type="button" class="btn btn-danger">
                        取消
                    </button>
                </router-link>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <div class="row">
                <div class="ibox-content">
                  <div class="modal-content">
                    <div class="wrapper wrapper-content animated fadeInRight">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="ibox-content" style="border:none">
                            <div class="form-horizontal clearfix" name="for1">
                              <div class="form-group col-lg-12">
                                  <label class="col-lg-2 control-label">产品名称:</label>
                                <div class="col-lg-8">
                                  <input type="text"  class="form-control" placeholder="请输入产品名称" v-model="resource.name">
                                </div>
                              </div>
                              <div class="form-group col-lg-12"><label class="col-lg-2 control-label">产品代码:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control"  placeholder="请输入产品代码" v-model="resource.code">
                                </div>
                              </div>
                              <div class="form-group col-lg-12">
                                  <label class="col-lg-2 control-label">品种概述:</label>
                                <div class="col-lg-8 html ql-editor">
                                  <quill-editor ref="myTextEditor"
                                                v-model="resource.content"
                                                :config="editorOption"
                                                @blur="onEditorBlur($event)"
                                                @focus="onEditorFocus($event)"
                                                @ready="onEditorReady($event)">
                                  </quill-editor>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      <!--预览-->
      <div class="modal fade" id="myModal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" >
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title text-center"><strong>预览编辑项</strong></h3>
                  </div>
                  <div class="modal-body">
                      <div class="form-group">
                          <span>产品名称:&emsp;</span>{{resource.name}}
                      </div>
                      <div class="form-group">
                          <span>产品代码:&emsp;</span>{{resource.code}}
                      </div>
                      <div class="form-group" id="proimg">
                          <span class="html ql-editor" v-html="resource.content"></span>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">关闭
                      </button>
                  </div>
              </div>
          </div>
      </div>
      <!--预览结束-->
  </div>
</template>
<style>
     #proimg img{
        width: 540px;
     }
</style>
<script>
  import Upload from './../Common/Upload.vue'
  import { quillEditor } from 'vue-quill-editor'
  export default{
    created(){},
    data(){
      return {
        editorOption:{
          placeholder:'请输入内容'
        },
        resource:{
          name:'',
          code:'',
          content:'',
        },
        url  : '/api/products'
      }
    },
    components: {
      Upload,quillEditor,
    },
    methods   : {
    getMessage(){
        axios.get('/api/products/edit/' + this.$route.params.id).then(response => {
          this.resource = response.data;
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      editProduct(id){
        axios.put('/api/products/editProduct/'+id,this.resource).then(response =>{
          toastrNotification('success','编辑成功');
          Vue.router.push('/products');
        }).catch(error =>{
          toastrNotification('error',error.response.data.message);
        });
      },
      onSearch (url) {
        this.url = url;
      },
      onEditorBlur(editor) {
      },
      onEditorFocus(editor) {
      },
      onEditorReady(editor) {
      },
      onEditorChange({ editor, html, text }) {
        this.resource.content = html;
      }
    },
    computed: {
      editor() {
        return this.$refs.myTextEditor.quillEditor
      }
    },
    mounted(){
      this.getMessage();
    }
  }
</script>