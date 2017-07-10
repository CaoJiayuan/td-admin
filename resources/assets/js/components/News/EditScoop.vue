<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>编辑独家专栏</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li>
            <router-link to="/news/scoop">独家专栏</router-link>
          </li>
          <li class="active"><strong>编辑独家专栏</strong></li>
        </ol>
      </div>

      <div class="form-group text-right col-lg-4">
        <div class="title-action">
          <button data-target="#myModal" data-toggle="modal" type="button" class="btn btn-info" >预览</button>
          <button @click="updateScoop" type="button" class="btn btn-info" >确定</button>
          <router-link to="/news/scoop"><button type="button" class="btn btn-danger" >取消</button></router-link>
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
                            <div class="form-horizontal clearfix">

                              <div class="form-group col-lg-12"><label class="col-lg-2 control-label">独家专栏标题:</label>
                                <div class="col-lg-8">
                                  <input type="text" v-model="scoops.title"   class="form-control">
                                </div>
                              </div>
                              <div class="form-group col-lg-12"><label class="col-lg-2 control-label">独家专栏类型:</label>
                                <div class="col-lg-4">
                                  <multiselect
                                      id="admin-roles"
                                      v-model="scoops.category"
                                      :options="categories"
                                      placeholder="选择类型"
                                      label="name"
                                      :selectLabel="'点击选择'"
                                      :selectedLabel="'已选择'"
                                      :deselectLabel="'点击移除'"
                                      track-by="id">
                                  </multiselect>
                                </div>
                              </div>
                              <div class="form-group col-lg-12"><label class="col-lg-2 control-label">来源:</label>
                                <div class="col-lg-4">
                                  <input type="text" v-model="scoops.from"  class="form-control">
                                </div>
                              </div>
                              <div class="form-group col-lg-12"><label class="col-lg-2 control-label">新闻摘要:</label>
                                <div class="col-lg-8">
                                  <textarea class="form-control" cols="80" rows="3" v-model="scoops.summary"></textarea>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-2 control-label">上传图片</label>
                                <div class="col-sm-4">
                                  <el-upload
                                      class="upload"
                                      action="/api/uploads"
                                      :multiple="false"
                                      name="file"
                                      :on-success="success"
                                      :file-list="fileList"
                                      list-type="picture">
                                    <el-button size="small" type="primary">点击上传</el-button>
                                  </el-upload>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-2 control-label">发布时间</label>
                                <div class="col-sm-8">
                                  <div class="block">
                                    <el-date-picker
                                        v-model="scoops.published_at"
                                        type="datetime"
                                        placeholder="选择日期时间">
                                    </el-date-picker>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group col-lg-12"><label class="col-lg-2 control-label">新闻内容:</label>
                                <div class="col-lg-8 html ql-editor">
                                  <quill-editor ref="myTextEditor"
                                                v-model="scoops.content"
                                                :config="editorOption"
                                                @blur="onEditorBlur($event)"
                                                @focus="onEditorFocus($event)"
                                                @ready="onEditorReady($event)"
                                               >{{ scoops.content }}
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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         style="border:none;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title text-center"><strong>{{scoops.title}}</strong></h3>
          </div>
          <div class="modal-body">
            <div class="modal-content col-lg-12" style="border:none">
              <div class="hr-line-dashed col-lg-12" style="border: none;margin-bottom: 5px;"></div>
              <div class="form-group col-lg-12">
                <span>{{scoops.published_at}}&emsp;</span>
                <span>来源:&nbsp;{{scoops.from}}</span>
              </div>
              <div class="form-group col-lg-12">
                <span class="col-lg-12" id="fsize" style="color: #8C7853;">{{scoops.summary}}</span>
              </div>
              <div class="form-group col-lg-12">
                <span class="col-lg-12 html ql-editor" id="cimg"><span v-html="scoops.content"></span>
                </span>
              </div>
            </div>
            <div class="text-right">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="margin-top: 15px">
                关闭
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
<style>
#cimg img{
  width:470px;
}
#fsize{
  font-size:1px;
}
</style>
<script>
  import Upload from './../Common/Upload.vue'
  import { quillEditor } from 'vue-quill-editor'
  import OrderThead from '../Common/OrderThead.vue';
  import Multiselect from 'vue-multiselect';
  export default{
    created(){

    },
    data(){
      return {
        scoops:{
          from:'',
          summary:'',
          thumbnail:'',
          content:'',
          title:'',
          published_at:''
        },
        fileList: [],
        categories:[],
        url:'/api/uploads',
        editorOption:{
          placeholder:'请输入内容'
        },
        resource:{
          content:'',
          name:''
        },
      }
    },
    components: {
      OrderThead,quillEditor,Upload,Multiselect
    },
    methods   : {
      onEditorBlur(editor) {
      },
      onEditorFocus(editor) {
      },
      onEditorReady(editor) {
      },
      onEditorChange({ editor, html, text }) {
        console.log(html);
        this.resource.content = html;
      },
      updateScoop(){
        axios.put('/api/news/updateScoop/'+this.$route.params.id,this.scoops).then(response =>{
          toastrNotification('success','修改成功');
          Vue.router.push('/news/scoop');
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      success(response){
        this.scoops.thumbnail = response;
        this.fileList = [{'name': '已选图片', 'url': response}];
      },
    },
    computed: {
      editor() {
        return this.$refs.myTextEditor.quillEditor
      }
    },
    mounted(){
      axios.get('/api/news/getScoop/'+this.$route.params.id).then(response =>{
        this.scoops = response.data;
        this.fileList = [{'name': '已选图片', 'url': this.scoops.thumbnail}];
      });
      axios.get('/api/news/getCategories').then(response =>{
        this.categories = response.data;
      });
    }
  }
</script>