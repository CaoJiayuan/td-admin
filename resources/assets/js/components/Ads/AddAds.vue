<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>新增广告</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li>
                            <router-link to="/ads">广告列表</router-link>
                        </li>
                        <li class="active"><strong>新增广告</strong></li>
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
                                    <select class="form-control" v-model="ads.type">
                                        <option v-for="item in type" :value="item.code">{{item.name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-1" v-if="ads.type==0">
                                    <button class="btn  btn-info" data-toggle="modal" data-target="#ResourceModal">选择</button>
                                </div>
                                <div class="col-sm-1" v-if="ads.type==1">
                                    <button class="btn btn-info" data-toggle="modal" data-target="#NewsModal">选择</button>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group" v-if="ads.type==0&&ads.resource_name">
                                <label class="col-sm-2 control-label">素材名称</label>
                                <div class="col-sm-8" style="line-height: 27px">{{ads.resource_name}}</div>
                            </div>
                            <div class="form-group" v-if="ads.type==1&&ads.resource_name">
                                <label class="col-sm-2 control-label">独家专栏名称</label>
                                <div class="col-sm-8" style="line-height: 27px">{{ads.resource_name}}</div>
                            </div>
                            <div class="form-group" v-if="ads.type==2">
                                <label class="col-sm-2 control-label">内部链接</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="ads.url">
                                </div>
                            </div>
                            <div class="form-group" v-if="ads.type==3">
                                <label class="col-sm-2 control-label">外部链接</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="ads.url">
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

    },
    data(){
      return {
        resources: {},
        positions: {},
        type: {},
        url: '/api/uploads',
        fileList:[],
        ads: {
          title: '',
          type: '0',
          ad_position_id: 1,
          url: '',
          img: '',
          resource_id: '',
          resource_name:'',
          size:'',
        },
      }
    },
    components: {
      News,
      Resource
    },
    methods: {
      getPositions(){
        axios.get('/api/at/add').then(response => {
          this.positions = response.data.positions;
          this.type = response.data.type;
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      success(response,file,fileList){
        this.ads.img = response;
        this.fileList = [{'name':'已上传图片','url':response}];
      },
      preservation(){
        axios.post('/api/at/add', this.ads).then(response => {
          toastrNotification('success', '添加成功');
          Vue.router.push('/ads');
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      chooseNews(data){
        this.ads.url = data.id;
        this.ads.resource_name = data.title;
      },
      chooseResource(data){
        this.ads.url = data.id;
        this.ads.resource_name = data.name;
      },
    },
    mounted(){
      this.getPositions();
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