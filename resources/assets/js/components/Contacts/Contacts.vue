<template>
    <div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2><strong>联系方式列表</strong></h2>
                <ol class="breadcrumb">
                    <li>
                        <router-link to="/">首页</router-link>
                    </li>
                    <li class="active"><strong>联系方式列表</strong></li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">

                        <div class="ibox-title" style="height:65px;">
                            <search :url="url"></search>
                            <router-link to="/contacts/add" v-if="permission.can('base.contacts.add')"><button class="btn btn-info">新增联系方式</button></router-link>

                        </div>

                        <div class="ibox-content">
                            <table class="table table-bordered dataTable">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>联系方式名称</th>
                                    <th>联系方式</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in contacts">
                                    <td>{{item.id}}</td>
                                    <td>{{item.key}}</td>
                                    <td>{{item.value}}</td>
                                    <td v-if="item.status">已启用</td>
                                    <td v-else>已禁用</td>
                                    <td>
                                        <router-link :to="{ name: 'contacts/edit', params: { id: item.id }}" v-if="permission.can('base.contacts.edit')">
                                            <button class="btn btn-info btn-sm">编辑</button>
                                        </router-link>
                                        <button v-if="item.status==0 && permission.can('base.contacts.delete')" class="btn btn-sm btn-info" @click="modifyStatus(item.id)">启用</button>
                                        <button v-if="item.status==1 && permission.can('base.contacts.delete')" class="btn btn-sm btn-danger" @click="modifyStatus(item.id)">禁用</button>
                                        <button class="btn btn-sm btn-danger" @click="deleteContact(item.id)" v-if="permission.can('base.contacts.delete')">删除
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
        url: '/api/contacts',
        contacts: {}
      }
    },
    components: {
      Search,
      Page
    },
    methods: {
      page(data){
        this.contacts = data;
      },
      modifyStatus(id){
        axios.get('/api/contacts/modifyStatus/' + id).then(response => {
          toastrNotification('success', '修改状态成功');
          vueApp.$emit('page.refresh', this.url);
        }).catch(error => {
          toastrNotification('error', error.message);
        });
      },
      deleteContact(id)
      {
        axios.get('/api/contacts/delete/' + id).then(response => {
          toastrNotification('success', '删除成功');
            vueApp.$emit('page.refresh', this.url);
        }).catch(error => {
            toastrNotification('error', error.message);
        });
      }
    },
    mounted(){
    }
  }

</script>