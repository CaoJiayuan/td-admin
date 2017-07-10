<template>
  <div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-8">
        <h2>更新管理</h2>
        <ol class="breadcrumb">
          <li>
            <router-link to="/">首页</router-link>
          </li>
          <li class="active"><strong>版本列表</strong></li>
        </ol>
      </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <search :url="url"></search>
              <span class="input-group-btn" v-if="permission.can('base.version.add')">
                  <button type="button" class="btn btn-info" data-target="#add-version" data-toggle="modal"
                          @click="resetVersion"> <i
                      class="fa fa-plus"></i>&nbsp; 添加版本</button>
              </span>
            </div>

            <div class="ibox-content">
              <table class="table table-bordered dataTable">
                <thead>
                <tr>
                  <order-thead column="created_at" tTitle="日期"></order-thead>
                  <order-thead column="version" tTitle="版本号"></order-thead>
                  <order-thead column="build" tTitle="Build code"></order-thead>
                  <td>更新内容</td>
                  <order-thead column="type" tTitle="更新类型"></order-thead>
                  <th v-if="permission.any('base.version.delete','base.version.edit')">操作</th>
                </tr>
                </thead>
                <tbody>
                  <tr v-for="version in versions">
                    <td>{{ version.created_at }}</td>
                    <td>{{ version.version }}</td>
                    <td>{{ version.build }}</td>
                    <td v-html="replaceEol(version.content)"></td>
                    <td>{{ version.type.name }}</td>
                    <td>
                      <button v-if="permission.can('base.version.edit')" class="btn btn-sm btn-info" data-target="#add-version" data-toggle="modal"  @click="getVersion(version.id)">编辑</button>
                      <button v-if="permission.can('base.version.delete')" @click="deleteVersion(version.id)" class="btn btn-sm btn-danger">删除</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <paginator :url="url" :onPageChanges="page"></paginator>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal inmodal fade" id="add-version" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body clearfix">
            <div class="form-horizontal" role="form">
              <div class="form-group">
                <div class="form-group">
                  <label for="version-version" class="col-sm-3 control-label">版本号*</label>
                  <div class="col-sm-9">
                    <input type="text" v-model="version.version" class="form-control" id="version-version" placeholder="输入版本号">
                  </div>
                </div>
                <div class="form-group">
                  <label for="version-build" class="col-sm-3 control-label">Build code*</label>
                  <div class="col-sm-9">
                    <input type="text" v-model="version.build" class="form-control" id="version-build" placeholder="输入Build code">
                  </div>
                </div>

                <div class="form-group">
                  <label for="version-content" class="col-sm-3 control-label">更新内容*</label>
                  <div class="col-sm-9">
                    <textarea v-model="version.content" style="resize: vertical;" class="form-control" id="version-content" placeholder="输入更新内容"></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="version-type" class="col-sm-3 control-label">更新类型*</label>
                  <div class="col-sm-9">
                    <multiselect
                        id="version-type"
                        v-model="version.type"
                        :options="types"
                        placeholder="选择更新类型"
                        :selectLabel="'点击选择'"
                        :selectedLabel="'已选择'"
                        :deselectLabel="'点击移除'"
                        label="name"
                        track-by="type">
                    </multiselect>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="version-dismiss" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-info" @click="postVersion">保存</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>

</style>
<script>
  import Paginator from '../Common/Paginator.vue';
  import OrderThead from '../Common/OrderThead.vue';
  import Search from '../Common/Search.vue';
  import Multiselect from 'vue-multiselect';
  export default{
    created(){

    },
    data(){
      return {
        url: '/api/versions',
        versions : [],
        types : [],
        version : {

        }
      }
    },
    components: {
      Paginator, Search, OrderThead, Multiselect
    },
    methods   : {
      resetVersion : function () {
        this.version = {}
      },
      page(data) {
        this.versions = data;
      },
      replaceEol(content) {
        if (typeof content != 'string') {
          return content;
        }
        return content.replace(/\n/g, '<br/>')
      },
      postVersion(){
        axios.post('/api/versions', this.version).then(response => {
          $("#version-dismiss").trigger({type: "click"});
          toastrNotification('success', '保存成功!');
          vueApp.$emit('page.refresh')
        }).catch(error => toastrNotification('error', error.response.data.message))
      },
      deleteVersion(id){
        deleteAlert('/api/versions/'+id, data => {
          vueApp.$emit('page.refresh')
        })
      },
      getVersion(id) {
        axios.get('/api/versions/'+id).then(response => this.version = response.data).catch(error => toastrNotification('error', error.response.data.message));
      }
    },
    mounted(){
      axios.get('/api/versions/types').then(response => this.types = response.data);
    }
  }
</script>