<template>
    <div>
        <div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2><strong>推送列表</strong></h2>
                    <ol class="breadcrumb">
                        <li>
                            <router-link to="/">首页</router-link>
                        </li>
                        <li class="active"><strong>推送列表</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title" style="height:65px;">
                            <search :url="url"></search>
                            <router-link to="/notice/add" v-if="permission.can('ads.notice.add')"><button class="btn btn-info">新增推送</button></router-link>
                        </div>
                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <order :column="'id'" :url="url" :tTitle="'序号'"></order>
                                    <th class="col-lg-2">推送标题</th>
                                    <th class="col-lg-2">推送内容</th>
                                    <order :column="'publish_at'" :url="url" :tTitle="'发布时间'"></order>
                                    <th>资源名称</th>
                                    <th>跳转位置</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in notices">
                                    <td>{{item.id}}</td>
                                    <td>{{item.title}}</td>
                                    <td>{{item.content}}</td>
                                    <td v-if="item.status==2">{{item.publish_at}}</td>
                                    <td v-else>未发布</td>
                                    <td v-if="item.resource_name">{{item.resource_name}}</td>
                                    <td v-else-if="item.url">{{item.url}}</td>
                                    <td v-else>未设置</td>
                                    <td v-for="items in type" v-if="item.type==items.code">{{items.name}}</td>
                                    <td v-if="item.status==0">已禁用</td>
                                    <td v-if="item.status==1">未发布</td>
                                    <td v-if="item.status==2">已发布</td>
                                    <td v-if="item.status!=2">
                                        <router-link :to="{ name: 'notice/edit', params: { id: item.id }}" v-if="permission.can('ads.notice.edit')">
                                            <button class="btn btn-sm btn-info">编辑</button>
                                        </router-link>
                                        <button class="btn btn-sm btn-info" @click="publish(item.id)" v-if="permission.can('ads.notice.publish')">发布</button>
                                        <button class="btn btn-danger btn-sm" @click="deleteNotice(item.id)" v-if="permission.can('ads.notice.delete')">删除</button>
                                    </td>
                                    <td v-else>
                                        <button class="btn btn-sm btn-info" disabled="disabled" v-if="permission.can('ads.notice.edit')">编辑</button>
                                        <button class="btn btn-sm btn-info" disabled="disabled" v-if="permission.can('ads.notice.publish')">发布</button>
                                        <button class="btn btn-danger btn-sm" disabled="disabled" v-if="permission.can('ads.notice.delete')">删除</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <page :url="url" :onPageChanges="page"></page>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Search from './../Common/Search.vue'
    import Order from './../Common/OrderThead.vue'
    import Page from './../Common/Paginator.vue'
    export default{
    created(){

    },
    data(){
      return {
        url: '/api/notice',
        type:{},
        notices: {},
      }
    },
    components: {
      Search,
      Order,
      Page,
    },
    methods: {
      page(data){
        this.notices = data;
        this.type = data.type;
        Vue.delete(this.notices,'type');
      },

      publish(id){
        axios.get('/api/notice/publish/'+id).then(response=>{
          if(response.data.code==200) {
            toastrNotification('success', '发布成功');
            vueApp.$emit('page.refresh', this.url);
          }else{
            toastrNotification('error', '发布失败，请重新发布');
          }
        }).catch(error=>{
          toastrNotification('error', error.message);
        });
      },

      deleteNotice(id){
        var opts = {
          title: '确认删除?',
          text: '你将无法恢复数据!',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: '是,确定删除!',
          cancelButtonText: '不,取消删除',
          closeOnConfirm: false,
          closeOnCancel: false
        };

        sweetAlert(opts,
          function (isConfirm) {
            if (isConfirm) {
              axios.get('/api/notice/delete/' + id).then(response => {
                  sweetAlert("已经删除", "数据已经删除!", "success");
                  vueApp.$emit('page.refresh', this.url);
              }).catch(error =>{
                toastrNotification('error', error.message);
              });
            } else {
              sweetAlert("取消", "数据没有删除!", "error");
            }
          });
      },

    },
    mounted(){
    }
  }
</script>