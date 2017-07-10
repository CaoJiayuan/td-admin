<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>编辑广告</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/dashboard">首页</router-link>
                        </li>
                        <li>
                            <router-link to="/ads">广告列表</router-link>
                        </li>
                        <li class="active"><strong>编辑广告</strong></li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
                        <a class="button btn btn-info" @click="preservation">保存</a>
                        <router-link to="/ads"><a class="button btn btn-danger">取消</a></router-link>
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
                                <label class="col-sm-2 control-label">广告标题</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="ads.title">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">广告位置</label>
                                <div class="col-sm-8">
                                    <select class="form-control" v-model="ads.ad_position_id">
                                        <option v-for="item in positions" :value="item.code">{{item.name}}（{{item.description}}）</option>
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上传图片<br /><span style="color: red">（{{size}}）</span></label>
                                <div class="col-sm-4">
                                    <el-upload
                                            class="upload"
                                            action="/api/uploads"
                                            multiple="false"
                                            name="file"
                                            accept="image/*"
                                            :on-success="success"
                                            :file-list="fileList"
                                            list-type="picture">
                                        <el-button size="small" type="primary">点击上传</el-button>
                                    </el-upload>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">广告类型</label>
                                <div class="col-sm-4">
                                    <select class="form-control" v-model="type">
                                        <option v-for="item in adsType" :value="item.code">{{item.name}}</option>

                                    </select>
                                </div>
                                <div class="col-sm-1" v-if="type==0">
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#ResourceModal" @click="getResource">选择</button>
                                </div>
                                <div class="col-sm-1" v-if="type==1">
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#NewsModal" @click="getNews">选择</button>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group" v-if="type==0&&resource_name">
                                <label class="col-sm-2 control-label">素材名称</label>
                                <div class="col-sm-8" style="line-height: 27px">{{resource_name}}</div>
                            </div>
                            <div class="form-group" v-if="type==1&&resource_name">
                                <label class="col-sm-2 control-label">独家专栏名称</label>
                                <div class="col-sm-8" style="line-height: 27px">{{resource_name}}</div>
                            </div>
                            <div class="form-group" v-if="type==2">
                                <label class="col-sm-2 control-label">内部链接</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="url">
                                </div>
                            </div>
                            <div class="form-group" v-if="type==3">
                                <label class="col-sm-2 control-label">外部链接</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="url">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <resource :onChoose="chooseResource"></resource>
        <news :onChoose="chooseNews"></news>
    </div>
</template>
<script>
  import News from './NewsModal.vue'
  import Resource from './ResourceModal.vue'
  export default{
    created(){
      this.getMessage();
    },
    data(){
      return {
        positions: {},
        fileList: [],
        resource_name: '',
        url: '',
        type:'',
        adsType:{},
        ads: {
          id: '',
          title: '',
          type: '',
          ad_position_id: '',
          url: '',
          img: '',
          resource_id: '',
          resource_name: '',
          size:''
        },
      }
    },
    components: {
      News,
      Resource
    },
    methods: {
      getMessage(){
        axios.get('/api/at/edit/' + this.$route.params.id).then(response => {
          this.positions = response.data.position;
          this.adsType = response.data.type;
          this.ads = response.data.ads;
          this.resource_name = this.ads.resource_name;
          this.url = this.ads.url;
          this.type = this.ads.type;
          this.fileList = [{'name': '已选图片', 'url': this.ads.img}];
          this.size = this.ads.size;
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      success(response, file, fileList){
        this.ads.img = response;
        this.fileList = [{'name': '已选图片', 'url': response}];
      },
      preservation(){
        this.ads.url = this.url;
        this.ads.resource_name = this.resource_name;
        this.ads.type = this.type;
        axios.post('/api/at/edit', this.ads).then(response => {
          toastrNotification('success', '保存成功');
          Vue.router.push('/ads');
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      chooseNews(data){
        this.url = data.id;
        this.resource_name = data.title;
      },
      chooseResource(data){
        this.url = data.id;
        this.resource_name = data.name;
      }
    },
    mounted(){

    },
    watch: {
      type: function (type) {
        if(this.type!=this.ads.type) {
          this.url = '';
          this.resource_name = '';
        }
        if(this.type==this.ads.type) {
          this.url = this.ads.url;
          this.resource_name = this.ads.resource_name;
        }
      }
    },
    computed:{
      size:function(){
        self = this;
        var size = '';
        $(this.positions).each(function(index,value){
          if(self.ads.ad_position_id==value['code']) {
            size = value['size'];
            self.ads.size = size;
          }
        });
        return size;
      }
    }
  }
</script>