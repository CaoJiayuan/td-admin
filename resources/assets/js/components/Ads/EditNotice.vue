<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>新增推送</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li>
                            <router-link to="/notice">推送列表</router-link>
                        </li>
                        <li class="active"><strong>新增推送</strong></li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
                        <a class="button btn btn-info" @click="preservation">保存</a>
                        <router-link to="/notice"><a class="button btn btn-danger">取消</a></router-link>
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
                                <label class="col-sm-2 control-label">推送名称</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="notice.title">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">推送内容</label>
                                <div class="col-sm-8">
                                    <textarea rows="6" class="col-sm-12" v-model="notice.content"></textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">推送类型</label>
                                <div class="col-sm-4">
                                    <select class="form-control" v-model="type">
                                        <option v-for="item in noticeType" :value="item.code">{{item.name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-1" v-if="type==3">
                                    <button class="btn  btn-info" data-toggle="modal" data-target="#ResourceModal">选择</button>
                                </div>
                                <div class="col-sm-1" v-if="type==4">
                                    <button class="btn btn-info" data-toggle="modal" data-target="#NewsModal">选择</button>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group" v-if="type==3&&resource_name">
                                <label class="col-sm-2 control-label">素材名称</label>
                                <div class="col-sm-8" style="line-height: 27px">{{resource_name}}</div>
                            </div>
                            <div class="form-group" v-if="type==4&&resource_name">
                                <label class="col-sm-2 control-label">独家专栏名称</label>
                                <div class="col-sm-8" style="line-height: 27px">{{resource_name}}</div>
                            </div>
                            <div class="form-group" v-if="type==5">
                                <label class="col-sm-2 control-label">内部跳转链接</label>
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

    },
    data(){
      return {
        noticeType: {},
        type:'',
        resource_name:'',
        url:'',
        notice: {
          title: '',
          type: '',
          content: '',
          url: '',
        },
      }
    },
    components: {
      News,
      Resource
    },
    methods: {
      getMessage(){
        axios.get('/api/notice/edit/'+this.$route.params.id).then(response => {
          this.noticeType = response.data.type;
          this.notice = response.data.notice;
          this.type = this.notice.type;
          this.resource_name = this.notice.resource_name;
          this.url = this.notice.url;
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      preservation(){
        this.notice.type = this.type;
        this.notice.url = this.url;
        this.notice.resource_name = this.resource_name;
        axios.post('/api/notice/edit', this.notice).then(response => {
          toastrNotification('success','修改成功');
          Vue.router.push('/notice');
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      chooseNews(data){
        this.url = data.id;
        this.resource_name = data.title;
      },
      chooseResource(data){
        this.notice.url = data.id;
        this.resource_name = data.name;
      }
    },
    mounted(){
      this.getMessage();
    },
    watch: {
      type: function (type) {
        if(this.type!=this.notice.type) {
          this.url = '';
          this.resource_name = '';
        }
        if(this.type==this.notice.type) {
          this.url = this.notice.url;
          this.resource_name = this.notice.resource_name;
        }
      }
    }
  }
</script>