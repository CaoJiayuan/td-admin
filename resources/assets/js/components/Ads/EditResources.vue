<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>新增素材</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li>
                            <router-link to="/resources">素材列表</router-link>
                        </li>
                        <li class="active"><strong>新增素材</strong></li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
                        <a class="button btn btn-info" @click="preservation">保存</a>
                        <button class="btn btn-primary" @click="preview()"
                                data-toggle="modal" data-target="#myModal5">
                            预览
                        </button>
                        <router-link to="/resources"><a class="button btn btn-danger">取消</a></router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content">
                        <form enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">素材名称</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="resource.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">素材内容</label>
                                <div class="col-sm-8">
                                    <quill-editor ref="myTextEditor"
                                                  v-model="resource.content"
                                                  :config="editorOption"
                                                  @blur="onEditorBlur($event)"
                                                  @focus="onEditorFocus($event)"
                                                  @ready="onEditorReady($event)">
                                    </quill-editor>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: none;" class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">素材预览</h4>
                    </div>
                    <div class="lightBoxGallery" id="content">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">返回</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<style lang="scss">
    .ql-container .ql-editor {
        min-height: 30em;
        padding-bottom: 1em;
        max-height: 40em;
    }
</style>

<script>
  import {quillEditor} from 'vue-quill-editor'
  export default{
    created(){


    },
    data(){
      return {
        editorOption: {
          placeholder: '请输入内容',
          scrollingContainer: 'auto'
        },
        resource: {
          name: '',
          content: '',
          id: '',
        }
      }
    },
    components: {
      quillEditor
    },
    methods: {
      getMessage(){
        axios.get('/api/resource/edit/' + this.$route.params.id).then(response => {
          this.resource = response.data;
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      preservation(){
        axios.post('/api/resource/edit', this.resource).then(response => {
          toastrNotification('success', '编辑成功');
          Vue.router.push('/resources');
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      onEditorBlur(editor) {
      },
      onEditorFocus(editor) {
      },
      onEditorReady(editor) {
      },
      onEditorChange({editor, html, text}) {
        this.resource.content = html;
      },
      preview()
      {
        $('#content').html(this.resource.content);
      }
    },
    computed: {
      editor() {
        return this.$refs.myTextEditor.quillEditor;
      }
    },
    mounted(){
      this.getMessage();
    }
  }
</script>