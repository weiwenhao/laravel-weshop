<template>
    <!--定义模板-->
    <div>
        <div class="poster-text-body">
            <textarea class="text"
                      id="poster"
                      v-model="content"
                      placeholder="随便说两句吧"
                      spellcheck="false"></textarea>
        </div>
        <div class="poster-body">
            <hr>
            <div class="poster-top">
                <div class="poster-top-left" id="selectType">
                    <i class="icon icon-apps" data-val="0"></i>
                    <i class="icon icon-pic" data-val="1"></i>
                    <!--i class="fa fa-smile-o" data-val="2"></i-->
                </div>
                <div class="poster-top-right">
                    <a href="/posts">取消&nbsp;&nbsp;</a>
                    <a class="poster-top-sub" id="posterBtn" @click.prevent="createPost()">发送</a>
                </div>
            </div>
            <hr>
            <div class="poster-bottom">
                <div id="target_1" class="poster-bottom-type panel">
                    <label :for="category.id" v-for="category in categories">
                        <input class="attr-value" type="radio" name="radio"
                               :id="category.id" :value="category.id"
                               v-model="post_category_id" />
                        <span>{{ category.name　}}</span>
                    </label>
                </div>
                <div id="target_2" class="poster-bottom-photo panel">
                    <div class="weui-cells weui-cells_form" id="uploader">
                        <div class="weui-cell">
                            <div class="weui-cell__bd">
                                <div class="weui-uploader">
                                    <div class="weui-uploader__hd">
                                        <p class="weui-uploader__title">图片上传</p>
                                        <div class="weui-uploader__info"><span id="uploadCount">0</span>/6</div>
                                    </div>
                                    <div class="weui-uploader__bd">
                                        <ul class="weui-uploader__files" id="uploaderFiles"></ul>
                                        <div class="weui-uploader__input-box">
                                            <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/jpg, image/jpeg, image/png, image/gif" capture="camera" multiple="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="target_3" class="poster-bottom-emoticon panel">表情</div>
            </div>
        </div>
    </div>
</template>
<script>
    /*组件选项定义,包括data,methods,等*/
    var that;
    export default {
        data () {
            return {
                categories : [],
                post_category_id : null,
                content : '',
                uploadList : [],
                post_id : 0,
                create_loading : null,
            }
        },
        created(){
            that = this;
            this.getPostCate();

        },
        mounted(){
            this.uploaderImg();
        },
        methods :{
            /*
            * 场景分析:  操作① 点击发送按钮时将说说内容发送到后台,后台返回创建成功的 数据 {}
            *           操作② 从操作①中提取出 post_id.附加到图片上传的头信息中,保存图片
            *           操作③ 提示发表成功,跳转到圈子主页
            * */
            createPost(){
//                this.createPostImage();return
                if(!this.content){
                    weui.alert('说点什么吧');
                    return
                }
                if(!this.post_category_id){
                    weui.alert('你还没有选择版块呢');
                    return
                }

                this.create_loading = weui.loading('发表中');
                //发送说说
                 axios.post('/api/posts', {
                  	 'post_category_id' : this.post_category_id,
                     'content' : this.content,
                 })
                 .then(response=> {
                 	this.post_id = response.data.id;
                 	this.$nextTick(function () {
                        this.createPostImage();
                    });
                 })
                 .catch(error=> {
                     let validator_err = error.response.data;
                     if(validator_err.post_category_id){
                         this.create_loading.hide();
                         weui.alert(validator_err.post_category_id[0]);
                         return
                     }
                     if(validator_err.content){
                         this.create_loading.hide();
                         weui.alert(validator_err.content[0]);
                         return
                     }
                 });

            },
            createPostImage(){
                //异步上传图片
                that.uploadList.forEach(function(file){
                    file.upload();
                });
                //图片上传完毕后方可调用该方法 todo bug待测试
                this.createdSuccess();
            },
            getPostCate(){
                axios.get('/api/post_categories', {
                	/*params: {
                		article_id: this.article_id,
                	}*/
                })
                .then(response=> {
                	 this.categories = response.data;
                })
                .catch(error=> {
                	console.log(error);
                });
            },
            uploaderImg(){
                var uploadCount = 0;
                var uploadCountDom = document.getElementById("uploadCount");
                weui.uploader('#uploader', {
                    url: 'http://' + location.hostname + '/api/posts/upload',
                    auto: false, //不开启自动上传,手动触发上传
                    type: 'file',
                    fileVal :'post_img',
                    compress: {
                        width: 1600,
                        height: 1600,
                        quality: .8
                    },
                    onBeforeQueued: function(files) {
                        if(["image/jpg", "image/jpeg", "image/png", "image/gif"].indexOf(this.type) < 0){
                            weui.alert('请上传图片');
                            return false;
                        }
                        if(this.size > 10 * 1024 * 1024){
                            weui.alert('请上传不超过10M的图片');
                            return false;
                        }
                        if (files.length > 6) { // 防止一下子选中过多文件
                            weui.alert('最多只能上传6张图片，请重新选择');
                            return false;
                        }
                        if (uploadCount + 1 > 6) {
                            weui.alert('最多只能上传6张图片');
                            return false;
                        }

                        ++uploadCount;
                        uploadCountDom.innerHTML = uploadCount;
                    },
                    onQueued: function(){
                        that.uploadList.push(this);
//                        console.log(this);
                    },
                    onBeforeSend: function(data, headers){ //文件上传前调用
//                        console.log(this, data, headers);
                         $.extend(data, { 'post_id' : that.post_id }); // 可以扩展此对象来控制上传参数
                         $.extend(headers, { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }); // 可以扩展此对象来控制上传头部

                        // return false; // 阻止文件上传
                    },
                    onProgress: function(procent){ //上传进度的回调
//                        console.log(this, procent);
                    },
                    onSuccess: function (ret) { //上传成功的回调
//                        console.log(this, ret); //分开的
                    },
                    onError: function(err){ //上传失败的回调
//                        console.log(this, err);
                    }
                });

                //图片预览
                document.querySelector('#uploaderFiles').addEventListener('click', function(e){
                    var target = e.target;

                    while(!target.classList.contains('weui-uploader__file') && target){
                        target = target.parentNode;
                    }
                    if(!target) return;

                    var url = target.getAttribute('style') || '';
                    var id = target.getAttribute('data-id');

                    if(url){
                        url = url.match(/url\((.*?)\)/)[1].replace(/"/g, '');
                    }
                    var gallery = weui.gallery(url, {
                        className: 'custom-name',
                        onDelete: function(){
                            weui.confirm('确定删除该图片？', function(){
                                --uploadCount;
                                uploadCountDom.innerHTML = uploadCount;
                                for (var i = 0, len = that.uploadList.length; i < len; ++i) {
                                    var file = that.uploadList[i];
                                    if(file.id == id){
                                        file.stop();
                                        break;
                                    }
                                }
                                target.remove();
                                gallery.hide();
                            });
                        }
                    });
                });
            },
            createdSuccess(){
                //关闭loading
                this.create_loading.hide();
                weui.toast('发表成功',  {
                    duration: 1000,
                    callback: function(){
                        location.href='/posts'
                    }
                });
            },
        }
    }
</script>
<style>

</style>