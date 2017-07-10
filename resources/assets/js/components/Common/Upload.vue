<template>
  <div class="upload">
    <div class="file">
      点击上传
      <input type="file" @change="onChange" :accept="acceptFile">
    </div>
    <div class="progress">
      <div class="progress-bar progress-bar-striped active" role="progressbar" :aria-valuenow="progress" aria-valuemin="0"
           aria-valuemax="100" :style="{width: progress + '%'}">
      </div>
    </div>
  </div>
</template>
<style>
  .file {
    position: relative;
    display: inline-block;
    background: #caf1ff;
    border: 1px solid #96d2f6;
    border-radius: 4px;
    padding: 4px 12px;
    overflow: hidden;
    color: #87acc7;
    text-decoration: none;
    text-indent: 0;
    line-height: 20px;
  }

  .file input {
    position: absolute;
    font-size: 100px;
    right: 0;
    top: 0;
    opacity: 0;
  }

  .file .progress {
    position: absolute;
    top: 0;
    opacity: .3;
    background-color: #9d9cd5;
    height: 100%;
    left: 0;
  }

  .file:hover {
    border-color: #78C3F3;
    text-decoration: none;
    cursor: pointer;
  }

  .upload .progress {
    width: 82px;
    height: 6px;
    margin-bottom: 0;
  }
</style>
<script>

  export default{
    props     : {
      onSuccess: {
        type   : Function,
        default: data => {
        }
      },
      onError  : {
        type   : Function,
        default: data => {
          toastrNotification('error', data.message)
        }
      },
      url      : {
        type   : String,
        default: ''
      },
      name     : {
        type   : String,
        default: 'file'
      },
      acceptFile : {
        type   : String,
        default: '*/*'
      }
    },
    created(){

    },
    data(){
      return {
        progress: '0',
        uploading : false
      }
    },
    components: {},
    methods   : {
      onChange(e){
        let file = e.target.files[0];
        let fd   = new FormData();
        fd.append(this.name, file);
        let self = this;
        let xhr  = new XMLHttpRequest();
        xhr.open('POST', this.url);
        self.progress = '0';
        self.uploading = true;
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.upload.onprogress = function (e) {
          if (e.lengthComputable) {
            self.progress = ((e.loaded / e.loaded) * 100);
          }
        };

        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4) {
            self.uploading = false;
            var responseText = JSON.parse(xhr.responseText);
            if (xhr.status == 200) {
              self.onSuccess(responseText)
            } else {
              self.onError(responseText)
            }
          }
        };

        xhr.send(fd);
      }
    },
    mounted(){

    }
  }
</script>