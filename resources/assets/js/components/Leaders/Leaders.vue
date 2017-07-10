<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2><strong>管理团队列表</strong></h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li class="active"><strong>管理团队列表</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <div class="ibox-title" style="height:65px;">
                            <search :url="url"></search>
                            <router-link to="/leaders/add" v-if="permission.can('base.group.add')"><button class="btn btn-info">新增管理团队</button></router-link>

                        </div>

                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>姓名</th>
                                    <th>职位</th>
                                    <th>头像</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in leaders">
                                    <td>{{item.id}}</td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.position}}</td>
                                    <td>
                                       <img width="100px" height="100px" :src="item.img" data-toggle="modal" data-target="#myModal" @click="preview(item.img)" >
                                    </td>
                                    <td v-if="item.status==1">已启用</td>
                                    <td v-if="item.status==0">已禁用</td>
                                    <td>
                                        <router-link :to="{ name: 'leaders/edit', params: { id: item.id }}" v-if="permission.can('base.group.edit')">
                                            <button class="btn btn-sm btn-info">编辑</button>
                                        </router-link>

                                        <button v-if="item.status==0 && permission.can('base.group.delete')" class="btn btn-sm btn-info" @click="modifyStatus(item.id)">启用</button>
                                        <button v-if="item.status==1 && permission.can('base.group.delete')" class="btn btn-sm btn-danger" @click="modifyStatus(item.id)">禁用</button>
                                        <button class="btn btn-sm btn-danger" @click="deleteLeader(item.id)" v-if="permission.can('base.group.delete')">
                                            删除
                                        </button>
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

        <div class="modal fade" id="myModal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title text-center">查看头像</h3>
                    </div>
                    <div class="modal-body" id="pic">
                        <img :src="pic">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>`
            </div>
        </div>

    </div>
</template>

<script>
  import Search from './../Common/Search.vue'
  import Page from './../Common/Paginator.vue'
  export default{
    data(){
      return {
        url: '/api/leaders',
        leaders: {},
        pic:'',
      }
    },
    components: {
      Search,
      Page
    },
    methods: {
      page(data){
        this.leaders = data;
      },
      modifyStatus(id){
        axios.get('/api/leaders/modifyStatus/' + id).then(response => {
          toastrNotification('success', '修改状态成功');
          vueApp.$emit('page.refresh', this.url);
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      deleteLeader(id){
        axios.get('/api/leaders/delete/' + id).then(response => {
          toastrNotification('success', '删除成功');
          vueApp.$emit('page.refresh', this.url);
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      preview(img){
        this.pic = img;
      },
    },
    mounted(){
    }
  }

</script>