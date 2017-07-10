<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>添加招聘信息</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li>
                            <router-link to="/recruits">招聘信息列表</router-link>
                        </li>
                        <li class="active"><strong>添加招聘信息</strong></li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
                        <a class="button btn btn-info" @click="preservation">保存</a>
                        <router-link to="/contacts"><a class="button btn btn-danger">取消</a></router-link>
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
                                <label class="col-sm-2 control-label">职位名称</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="recruit.position">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">招聘人数</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" v-model="recruit.num">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">职位描述</label>
                                <div class="col-sm-8">
                                    <textarea placeholder="各个描述之间请用中文'；'隔开" v-model="recruit.describe" class="col-sm-12" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">职位要求</label>
                                <div class="col-sm-8">
                                    <textarea placeholder="各个要求之间请用中文'；'隔开" v-model="recruit.request" class="col-sm-12" rows="6"></textarea>
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
        recruit: {
          position: '',
          describe: '',
          num: '',
          request: ''
        }
      }
    },
    components: {},
    methods: {
      preservation(){
        axios.post('/api/recruits/add', this.recruit).then(response => {
          toastrNotification('success', '添加成功');
          Vue.router.push('/recruits');
        }).catch(error => {
          toastrNotification('error', error.response.data.message);
        });
      }
    },
    computed: {},
    mounted(){

    }
  }
</script>