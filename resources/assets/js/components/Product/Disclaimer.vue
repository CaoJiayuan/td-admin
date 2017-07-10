<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>免责声明</h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li><strong>免责声明</strong></li>
                </ol>
            </div>
            <div class="col-lg-4">
                <div class="title-action">
                    <button class="btn btn-info" data-toggle="modal" @click="disclaimerEdit(resource.id)">保存</button>
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
                                                        <div class="col-lg-12 html ql-editor" id="con">
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
            content:'',
            code:[],
        },
        url:'api/disclaimer/index',
      }
    },
    components: {
      quillEditor
    },
    methods: {
    getMessage(){
        axios.get('/api/disclaimer/index').then(response => {
          this.resource = response.data;
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      disclaimerEdit(id){
      console.log(this.resource.content);
        axios.put('/api/disclaimer/edit/'+id,this.resource).then(response =>{
          toastrNotification('success','保存成功');
          this.resource.code = response.data
        }).catch(error =>{
          toastrNotification('error',error.response.data.message);
          Vue.router.push('/disclaimer');
        });
      },
      updateContent(){
      },
      preservation(){

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
    this.getMessage();
    this.getMessage();
    }
  }

</script>

