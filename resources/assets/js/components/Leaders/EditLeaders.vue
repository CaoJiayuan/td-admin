<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>编辑管理团队</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li>
                            <router-link to="/leaders">管理团队列表</router-link>
                        </li>
                        <li class="active"><strong>编辑管理团队</strong></li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
                        <a class="button btn btn-info" @click="preservation">保存</a>
                        <router-link to="/leaders"><a class="button btn btn-danger">取消</a></router-link>
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
                                <label class="col-sm-2 control-label">领导名字</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="leader.name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">领导职位</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="leader.position">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上传图片</label>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default{
    created(){

    },
    data(){
      return {
        leader:{
          name:'',
          img:'',
          position:'',
        }
      }
    },
    components: {},
    methods: {
      getLeader(){
        axios.get('/api/leaders/edit/'+this.$route.params.id).then(response => {
          this.leader = response.data;
        this.fileList = [{'name': '已选图片', 'url': this.leader.img}];
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      },
      success(response){
        this.leader.img = response;
        this.fileList = [{'name': '已选图片', 'url': response}];
      },
      preservation(){
        axios.post('/api/leaders/edit', this.leader).then(response => {
          toastrNotification('success', '编辑成功');
          Vue.router.push('/leaders');
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      }
    },
    computed: {
    },
    mounted(){
        this.getLeader();
    }
  }
</script>