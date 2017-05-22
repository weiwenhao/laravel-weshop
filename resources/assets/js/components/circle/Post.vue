<template>
    <div>
        <!--↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓- 帖子内容 -↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓-->
        <div class="circle-home-content">
            <!--头像,名称,日期,板块-->
            <div class="circle-top">
                <div class="me-flex-2">
                    <img class="me-img lazy" :src="post.logo">
                </div>
                <div class="me-flex-9">
                    <div class="circle-name"><b>{{ post.username }}</b><span class="lv"></span></div>
                    <span class="circle-time">{{ post.created_at_str }}</span>
                    <span class="circle-block"> 板块：<tt>{{ post.post_category_name }}</tt></span>
                </div>
                <div class="me-flex-1">
                    <a @click.prevent="delPost(post)" v-if="post.is_author"><i class="icon icon-delete"></i></a>
                </div>
            </div>
            <!--内容-->
            <div class="circle-content">
                <div v-html="post.content" @click="skipPostInfo(post)"></div>
            </div>
            <!--图片-->
            <div class="circle-content-img" v-if="post.post_images && post.post_images[0]">
                <div class="me-flex-12" v-for="post_image in post.post_images">
                    <img class="me-img lazy"
                         :src="post_image.image"
                         @click="showImages(post_image.image, post.post_images)"
                    >
                </div>
            </div>
            <!--评论-->
            <div class="circle-critic">
                <!--<div class="critic-top">&lt;!&ndash;评论数量和赞&ndash;&gt;
                    <span class="critic-t-r">
                        <a class="onReply" @click.prevent="showComment(index ,post.id)">
                            <i class="fa fa-commenting-o"></i><span> {{ post.post_comments_count }}</span>
                        </a>
                        <a href="" @click.prevent="switchLike(post)">
                           <i class="fa fa-thumbs-o-up"
                              :class="[post.is_like?'fa-thumbs-up':'fa-thumbs-o-up']"
                           ></i>
                            <span>{{ post.user_likes_count }}</span>
                        </a>
                    </span>
                </div>-->
                <!--评论内容区-->
                <div class="replys-top">
                    <span class="replys-num">{{ post.post_comments_count }} 条评论</span>
                    <span class="sort">{{ post.user_likes_count }} 赞</span>
                </div>
                <template v-if="post.post_comments && post.post_comments[0]">
                    <hr>
                    <!--回复详情-->
                    <div class="critic-replys-info" v-for="(post_comment, index) in  post.post_comments">
                    <!--头像,名称,日期,板块-->
                    <div class="circle-top">
                        <div class="me-flex-2">
                            <img class="me-img lazy" :src="post_comment.logo">
                        </div>
                        <div class="me-flex-10">
                            <div class="circle-name">
                                <a>{{ post_comment.username }}</a>
                                <template v-if="post_comment.obj_username">回复 <a href="">{{ post_comment.obj_username }}</a></template>
                                <a href="" class="floor" v-if="post_comment.is_author || post.is_author"
                                   @click.prevent.stop="delPostComment(index, post_comment, post.post_comments)"
                                >删除</a>
                            </div>

                            <div class="circle-content">
                                <div v-html="post_comment.content"></div>
                            </div>

                            <span class="circle-time">{{ post_comment.created_at_str }} </span>
                            <i class="icon icon-replyfill on-reply"
                               @click="showComment(post.id, post_comment.user_id, post_comment.username)"
                            ></i>
                        </div>
                    </div>
                </div>
                </template>
            </div>
        </div>


        <!--↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑- 帖子内容END -↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑-->
        <div class="weui-loadmore" v-if="is_show_loading">
            <i class="weui-loading"></i>
            <span class="weui-loadmore__tips">正在加载</span>
        </div>
        <div class="post-weshop-center-block"
             style="display:block;"
             v-else-if="!post.post_comments || !post.post_comments[0]"
        >
            <div>还没有评论，快来占个沙发吧</div>
        </div>

        <div style="height:3rem"></div>

        <!--回复文本框start-->
        <div class="critic-reply-frame"  v-if="comment.is_show">
            <textarea
                    class="me-flex-10"  rows="1"
                    name="comment"
                    v-model="comment.content"
                    :placeholder="comment.placeholder"
                    @blur="cancelComment()"
            ></textarea>
            <div class="me-flex-2">
                <button
                        class="weui-btn weui-btn_mini"
                        :class="[comment.content?'weui-btn_primary':'weui-btn_default weui-btn_plain-disabled']"
                        :disabled="!comment.content"
                        @click="createComment()"
                >发送
                </button>
            </div>
        </div>
        <div class="discuss-bottom" v-else >
            <div class="me-flex-4" @click="skipPosts()">
                <a href="javascript:void(0)"><i class="icon icon-back icon-lg"></i></a>
            </div>
            <div class="me-flex-4"  @click="showComment(post.id)">
                <a href="javascript:void(0)">
                    <i class="icon icon-comment icon-lg"></i>
                </a>
            </div>
            <div class="me-flex-4" @click="switchLike(post)">
                <a href="javascript:void(0)" >
                    <i class="icon icon-lg"
                       :class="[post.is_like?'icon-likefill':'icon-like']"
                    ></i>
                </a>
            </div>
        </div>
    </div>
</template>
<script>
    /*组件选项定义,包括data,methods,等*/
    export default {
        name: '',
        props : ['post_id'],
        data () {
            return {
                post : {},
                comment : { //评论对象只有一套,保证了唯一性
                    is_show : false,
                    post_id : null,
                    obj_user_id : 0,
                    obj_username : '',
                    placeholder : null,
                    content : '',
                },
                is_show_loading : false,
            }
        },
        created(){
            this.getPost();
        },
        mounted(){

        },
        methods : {
            //得到帖子数据,包括评论,图片
            getPost(){
                this.is_show_loading = true;
                axios.get('/api/posts/'+this.post_id, {

                })
                .then(response=> {
                    this.post = response.data;
                    this.$nextTick(function () {
                        this.is_show_loading = false;
                    })
                })
                .catch(error=> {
                    console.log(error);
                });
            },
            //创建一条评论
            createComment(){
                //点击该按钮的时候不是textarea失去焦点
                $('[name=comment]').focus();
                if(!this.comment.content){
                    return
                }
                //todo 帖子评论字数的前端限制

                let loading = weui.loading('请稍等');
                setTimeout(function () { //如果超过5秒钟没有响应则自动关闭loading框,并提示一个超时响应
                    loading.hide(function() {
                        weui.topTips('请求超时', 3000);
                    });
                }, 5000);

                axios.post('/api/post_comments', this.comment)
                    .then((response)=> {
                        //确定评论的index,往数组的底部添加一条数据,
                        this.post.post_comments.push(response.data);
                        this.post.post_comments_count ++;
                        //清空回答框,并隐藏
                        this.comment =  { //评论对象只有一套,保证了唯一性
                            is_show : false,
                            post_id : null,
                            obj_user_id : 0,
                            obj_username : '',
                            placeholder : null,
                            content : '',
                        };
                        //关闭loading并提示添加成功
                        loading.hide(function () {
                            /* weui.toast('评论成功', 1000);*/
                        });
                    })
                    .catch((error)=> {
                        loading.hide(function () {
                            weui.topTips('评论失败，请联系客服', 3000);
                        });
                    });
            },
            //显示评论框
            showComment(post_id, obj_user_id, obj_username){
                arguments[1] ? arguments[1] : 0; //设置默认值
                arguments[2] ? arguments[2] : '';
                //将默认值赋值给参数
                this.comment.post_id = post_id;
                this.comment.obj_user_id = obj_user_id;
                this.comment.obj_username = obj_username;
                this.comment.placeholder = '说点什么吧...'
                if(obj_user_id && obj_username){
                    this.comment.placeholder = '回复' + obj_username + '：';
                }
                //显示发送框
                this.comment.is_show = true;
                //使发送框获得焦点
                this.$nextTick(function () { //要等上面的数据变化完毕后再调用获得焦点事件
                    $('[name=comment]').focus();
                    this.setTextarea()//设置评论框js特效
                });
            },
            //取消评论框
            cancelComment(){
                //200ms后进行判断焦点是否丢失,如果丢失则运行
                setTimeout(() => {
                    //判断是否没有获得焦点
                    if(!$('[name="comment"]:focus').length){
                        this.comment.is_show = false;
                    }
                }, 100);
            },
            //设置评论框js事件
            setTextarea(){
                let replyHeight = $('.critic-reply-frame textarea ').height();
                $('.critic-reply-frame textarea ').each(function () {
                    this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
                }).on('input', function () {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                    if( this.scrollHeight >= replyHeight*4 ){
                        this.style.overflowY = 'scroll';
                        this.style.height = replyHeight*4+'px';
                    }
                });
            },
            //点赞或者取消点赞
            switchLike(post){
                //根据状态+或者-
                post.is_like?post.user_likes_count--:post.user_likes_count++;
                post.is_like = !post.is_like;
                axios.put('/api/post_likes/'+post.id)
            },
            delPost(post){
                weui.confirm('你确定要删除该帖子吗？', () =>{
                    //发送ajax请求
                    axios.delete('/api/posts/'+post.id, {
                        //key : value
                    })
                    //跳转回圈子主页
                    location.href = '/posts';
                });
            },
            //删除帖子评论
            delPostComment(index, post_comment, post_comments){
                weui.confirm('你确定要删除这条评论吗？', () =>{
                    post_comments.splice(index, 1);
                    //发送ajax请求
                    axios.delete('/api/post_comments/'+ post_comment.id, {
                        //key : value
                    })
                });
            },
            //使用jssdk预览图片
            showImages(current_img, imgs){
                //如果comment框显示则不进行跳转
                if(this.comment.is_show){
                    return
                }
                //调用微信接口
                let urls = [];
                for(let i = 0; i< imgs.length; ++i){
                    urls.push('http://' + location.hostname+ imgs[i].image)
//                    urls.push(imgs[i].image)
                }
                wx.previewImage({
                    current: 'http://' + location.hostname+ current_img, // 当前显示图片的http链接
                    urls: urls // 需要预览的图片http链接列表
                });
            },
            //跳转回圈子首页
            skipPosts(){
                location.href = '/posts';
            }
        }
    }
</script>
<style>
    .post-weshop-center-block {
        width:60%;
        /*margin-bottom:25%;*/
        text-align:center;
        color:#bbb;
        margin-left: auto;
        margin-right: auto;
        background-color: whitesmoke
    }
</style>