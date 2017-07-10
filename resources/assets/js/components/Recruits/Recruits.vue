<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2><strong>招聘信息列表</strong></h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li class="active"><strong>招聘信息列表</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <div class="ibox-title" style="height:65px;">
                            <search :url="url"></search>
                            <router-link to="/recruits/add" v-if="permission.can('base.recruits.add')"><button class="btn btn-info">新增招聘信息</button></router-link>

                        </div>

                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>职位名称</th>
                                    <th>招聘人数</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in recruits">
                                    <td>{{item.id}}</td>
                                    <td>{{item.position}}</td>
                                    <td>{{item.num}}</td>
                                    <td v-if="item.status==1">已启用</td>
                                    <td v-if="item.status==0">已禁用</td>
                                    <td>
                                        <router-link :to="{ name: 'recruits/edit', params: { id: item.id }}" v-if="permission.can('base.recruits.edit')">
                                            <button class="btn btn-sm btn-info">编辑</button>
                                        </router-link>
                                        <button v-if="item.status==0 && permission.can('base.recruits.delete')" class="btn btn-sm btn-info" @click="modifyStatus(item.id)">启用</button>
                                        <button v-if="item.status==1 && permission.can('base.recruits.delete')" class="btn btn-sm btn-danger" @click="modifyStatus(item.id)">禁用</button>
                                        <button class="btn btn-sm btn-danger" @click="deleteRecruits(item.id)" v-if="permission.can('base.recruits.delete')">删除
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
    </div>
</template>

<script>
  import Search from './../Common/Search.vue'
  import Page from './../Common/Paginator.vue'
  export default{
    data(){
      return {
        url: '/api/recruits',
        recruits: {}
      }
    },
    components: {
      Search,
      Page
    },
    methods: {
      page(data){
        this.recruits = data;
      },
      modifyStatus(id){
        axios.get('/api/recruits/modifyStatus/' + id).then(response => {
          toastrNotification('success', '修改状态成功');
          vueApp.$emit('page.refresh', this.url);
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      deleteRecruits(id){
        axios.get('/api/recruits/delete/' + id).then(response => {
          toastrNotification('success', '删除成功');
          vueApp.$emit('page.refresh', this.url);
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
    },
    mounted(){
    }
  }

</script>