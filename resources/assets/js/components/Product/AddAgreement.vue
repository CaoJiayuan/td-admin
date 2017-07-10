<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>添加协议</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li class="active"><strong>新增协议</strong></li>
        </ol>
      </div>
      <div class="col-lg-4">
          <div class="title-action">
          <button type="button" class="btn btn-info" @click="addAgreement(for1)">添加</button>
          <router-link to="/agreement">
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
                                  <label class="col-lg-2 control-label">协议名称:</label>
                                <div class="col-lg-8">
                                  <input type="text" v-model="resource.title" class="form-control" placeholder="请输入协议名称"/>
                                </div>
                              </div>
                              <div class="form-group col-lg-12">
                                <label class="col-lg-2 control-label">协议类型:</label>
                                <div class="col-lg-8">
                                  <input type="text" v-model="resource.keyWords" class="form-control" placeholder="请输入协议类型"/>
                                </div>
                              </div>
                              <div class="form-group col-lg-12">
                                <label class="col-lg-2 control-label">启用/禁用:</label>
                                <div class="col-lg-8 radio">
                                  <label>
                                    <input type="radio" v-model="resource.type" value="1" >启用</label>
                                  <label>
                                    <input type="radio" v-model="resource.type" value="0">禁用</label>
                                </div>
                              </div>
                              <div class="form-group col-lg-12">
                                  <label class="col-lg-2 control-label">协议内容:</label>
                                <div class="col-lg-8 html ql-editor">
                                  <quill-editor ref="myTextEditor"
                                                v-model="resource.content"
                                                :config="editorOption"
                                                @blur="onEditorBlur($event)"
                                                @focus="onEditorFocus($event)"
                                                @ready="onEditorReady($event)"
                                                 >
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
    created(){},
    data(){
      return {
        editorOption:{
          placeholder:'请输入协议内容'
        },
        resource:{
          title:'',
          keyWords:'',
          type:'',
          content:'',
          code:[],
          },
        url  : '/api/agreement/addAgreement'
      }
    },
    components: {
      Upload,quillEditor
    },
    methods   : {
    addAgreement(){
        axios.post('/api/agreement/addAgreement', this.resource).then(response => {
          toastrNotification('success','添加成功');
          Vue.router.push('/agreement');
          this.resource.code = response.data;
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
    },
      page(data){
        this.resource = data;
      },
      onSearch (url) {
        this.url = url;
        vueApp.$emit('page.refresh', url)
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

    }
  }
</script>