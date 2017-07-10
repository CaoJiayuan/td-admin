<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>新增产品</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li>
            <router-link to="/products">产品列表</router-link>
          </li>
          <li class="active"><strong>新增产品</strong></li>
        </ol>
      </div>
      <div class="col-lg-4">
        <div class="title-action">
          <button type="button" class="btn btn-info" @click="addProduct(for1)">确定</button>
          <router-link to="/products">
            <button type="button" class="btn btn-danger">取消</button>
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
                                  <input type="text" class="form-control" placeholder="请输入产品名称" v-model="resource.name">
                                </div>
                              </div>
                              <div class="form-group col-lg-12"><label class="col-lg-2 control-label">产品代码:</label>
                                <div class="col-lg-8">
                                  <input type="text" class="form-control" placeholder="请输入产品代码" v-model="resource.code">
                                </div>
                              </div>
                              <div class="form-group col-lg-12">
                                <label class="col-lg-2 control-label">品种概述:</label>
                                <div class="col-lg-8">
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
  </div>
</template>
<style>

</style>
<script>
  import Upload from './../Common/Upload.vue'
  import { quillEditor } from 'vue-quill-editor'
  export default{
    created(){

    },
    data(){
      return {
        editorOption:{
          placeholder:'请输入内容'
        },
        resource:{
          name:'',
          code:'',
          content:'',
          msgg:[]
        },

        url  : '/api/products/addProduct'

      }
    },
    components: {
      Upload,quillEditor
    },
    methods   : {
    addProduct(){
        axios.post('/api/products/addProduct', this.resource,this.name,this.code).then(response => {
          toastrNotification('success','添加成功');
          Vue.router.push('/products');
          this.resource.msgg = response.data;
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
    },
      page(data){
        this.resource = data;
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
        console.log(html);
        this.resource.content = html;
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