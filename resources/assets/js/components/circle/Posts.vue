<template>
    <!--定义模板-->
    <div>
        <!--********************************************-->
        <div class="circle-head">
            <div class="logo"></div>
            <div class="circle-h-mid">
                <span class="me-flex-3"></span>
                <span class="me-flex-6">校园商城</span>
                <span class="me-flex-3"><a href="/">进来逛逛 <i class="fa fa-angle-right"></i></a></span>
            </div>
        </div>
        <!--导航-->
        <div class="home-circle-nav">
            <div class="circle-nav">
                <span class="me-flex-4" :class="[params.type == null?'active':'']"><a href="" @click.prevent="setType(null)">首页</a></span>
                <span class="me-flex-4" :class="[params.type == 1?'active':'']"><a href="" @click.prevent="setType(1)">精华</a></span>
                <span class="me-flex-4" :class="[params.type == 2?'active':'']"><a href="" @click.prevent="setType(2)">我的</a></span>
            </div>
            <hr>
            <div class="circle-nav-b">
                <a  :class="{ 'active':post_category.id==params.post_category_id }"
                    v-for="post_category in  post_categories"
                    @click="setPostCateId(post_category.id)"
                >
                    {{ post_category.name }}
                </a>
            </div>
        </div>
        <!--帖子内容start-->
        <div class="circle-home-content" v-for="(post, index) in posts">
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
                    <a @click.prevent="delPost(index, post)" v-if="post.is_author">删除</a>
                </div>
            </div>
            <div  @click="skipPostInfo(post)">
                <!--内容-->
                <div class="circle-content">
                    <div v-html="post.content"></div>
                </div>
                <!--图片-->
                <div class="circle-content-img" v-if="post.post_images.length">
                    <div class="me-flex-4" v-for="post_image in post.post_images">
                        <img class="me-img lazy"
                             :src="post_image.sm_image"
                             @click.stop="showImages(post_image.image, post.post_images)"
                        >
                    </div>
                </div>
            </div>
            <!--评论-->
            <div class="circle-critic">
                <div class="critic-top"><!--评论数量和赞-->
                    <span class="critic-t-r">
                        <a @click.prevent="showComment(index ,post.id)">
                            <i class="fa fa-comment-o"></i><span> {{ post.post_comments_count }}</span>
                        </a>
                        <a href="" @click.prevent="switchLike(post)">
                           <i class="fa"
                              :class="[post.is_like?'fa-thumbs-up':'fa-thumbs-o-up']"
                           ></i>
                            <span>{{ post.user_likes_count }}</span>
                        </a>
                    </span>
                </div>
                <!--评论-->
                <div class="critic-replys" v-if="post.post_comments.length">
                    <div class="item" v-for="(post_comment, index2) in  post.post_comments" @click="showComment(index, post.id, post_comment.user_id, post_comment.username)">
                        <a>{{ post_comment.username }}</a>
                        <template v-if="post_comment.obj_username">回复 <a href="">{{ post_comment.obj_username }}</a></template>
                        :<span v-html="post_comment.content"></span>
                        <a href="" class="del" v-if="post_comment.is_author || post.is_author"
                           @click.prevent.stop="delPostComment(index2, post_comment, post.post_comments)"
                        >删除</a>
                    </div>
                </div>
            </div>
        </div>
        <!--帖子内容end-->


        <!--loading start-->
        <div class="weui-loadmore" v-if="is_show_loading">
            <i class="weui-loading"></i>
            <span class="weui-loadmore__tips">正在加载</span>
        </div>
        <!--loading end-->
        <template v-else>
            <!--帖子为空时start-->
            <div class="weshop-center-block"
                 style="display:block;"
                 v-if="posts.length == 0"
            >
                <i class="fa fa-tencent-weibo fa-5x"></i>
                <div v-if="params.type == null">暂时没有相关帖子~</div>
                <div v-else-if="params.type == 1">暂时没有精品帖子哦~</div>
                <div v-else-if="params.type == 2">你还没有发过帖子~</div>
            </div>
            <!--帖子为空时end-->

            <!-- on more start-->
            <div class="weui-loadmore weui-loadmore_line" v-else-if="!is_more">
                <span class="weui-loadmore__tips">已经到底啦</span>
            </div>
            <!--on more end-->
        </template>

        <!--底部start-->
        <div style="height:2rem"></div>
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
        <!--发帖start-->
        <div class="circle-home-bottom" v-else>
            <div class="me-flex-4">&nbsp;</div>
            <div class="me-flex-4">
                <a class="circle_send" id="fatie" href="/posts/create"><!---->
                    <i class="fa fa-pencil-square-o" ></i>
                    发帖子
                </a>
            </div>
            <div class="me-flex-4">
                <a class="new-reply" href="/post_news">
                    <span class="new-info" v-if="user.is_news">{{ user.is_news }}<!--右上角新消息数量--></span>

                    <i class="fa fa-user-circle-o"></i>
                </a>
            </div>
        </div>
        <!--底部end-->
    </div>
</template>
<script>
    /*组件选项定义,包括data,methods,等*/
    export default {
        name: 'Posts',
        data () {
            return {
                params : {
                    offset : 0,
                    limit : 8,
                    order : 'created_at',
                    sort : 'desc',
                    post_category_id : null,
                    type : null,
                },
                next_offset : 0,
                comment : { //评论对象只有一套,保证了唯一性
                    is_show : false,
                    post_id : null,
                    obj_user_id : 0,
                    obj_username : '',
                    placeholder : null,
                    content : '',
                    index : null,
                },
                post_categories : [],
                posts : [],
                is_show_loading : false,
                is_more : true,
                user : {
                    id : null,
                    logo : null,
                    is_news : false,
                }
            }
        },
        created(){
            this.getPostCate();
            this.getPosts();
            this.getUser();
            //每30秒调用一次getUser()
        },
        mounted(){
            $(window).scroll(() =>{
                 /*console.log('整个页面的高度:'+ $(document).height()); //固定值
                 console.log('可视区域的高度:'+ $(window).height()); //缩小浏览器时会改变
                 console.log('匹配元素相对于滚动条顶部的偏移' + $(document).scrollTop());*/
//                 console.log('可视区域高度:'+this.height());
                if($(document).height() - $(window).height() < $(document).scrollTop() +$('.circle-home-bottom').height()){
                    //不在loading中并且存在更多的数据才能请求该方法加载更多的数据
                    if(!this.is_show_loading && this.is_more){
                         this.nextPosts();
                     }
                }
            });
            window.setInterval(()=>{
                this.getUser();
            }, 30000);
        },
        methods : {
            getUser(){
                axios.get('/api/posts/user', {

                })
                .then(response=> {
                    this.user = response.data;
                })
                .catch(error=> {
                	console.log(error);
                });
            },
            //得到帖子数据,包括评论,图片
            getPosts(){
                //数据初始化
                this.posts = [];
                this.is_show_loading = true;
                this.is_more = true;
                //初始化next_offset
                this. next_offset = 0;


                axios.get('/api/posts', {
                    params: this.params
                })
                .then(response=> {
                    this.posts = response.data;
                    if(response.data.length < this.params.limit) {
                        this.is_more = false; //不存在多数据了
                    }

                    this.$nextTick(function () {
                        this.is_show_loading = false;
                    })
                })
                .catch(error=> {
                    this.is_show_loading = false;
                });
            },
            //加载更多接口
            nextPosts(){
                this.is_show_loading = true;
                this.next_offset = this.next_offset + this.params.limit + 1; //当前的偏移量,加上条数,+1
                //得到第一次的next_params
                axios.get('/api/posts', {
                    params: {
                        offset : this.next_offset,
                        limit : this.params.limit,
                        order :  this.params.order,
                        sort :  this.params.sort,
                        post_category_id :  this.params.post_category_id,
                        type : this.params.type
                    }
                })
                .then(response=> {
                   if(response.data.length > 0) {
                       //如果数据为空时也应吧is_show_loading = false;
                       //将取出的数据push到中
                       this.posts.push.apply(this.posts, response.data);
                   }else{
                       this.is_more = false; //如果没有返回说明不存在更多的贴子了
                   }
                    this.$nextTick(function () {
                        this.is_show_loading = false;
                    })
                })
                .catch(error=> {
                    console.log(error);
                });
            },
            //得到帖子分类数据
            getPostCate(){
                axios.get('/api/post_categories', {
                    /*params: {
                     article_id: this.article_id,
                     }*/
                })
                .then(response=> {
                    this.post_categories = response.data;
                    this.post_categories.unshift({
                        'id' : null,
                        'name' : '全部'
                    });
                })
                .catch(error=> {
                    console.log(error);
                });
            },
            setPostCateId(post_category_id){
                this.params.post_category_id = post_category_id;
                //刷新请求
                this.getPosts();
            },
            //显示评论框
            showComment(index, post_id, obj_user_id, obj_username){
                arguments[1] ? arguments[1] : 0; //设置默认值
                arguments[2] ? arguments[2] : '';
                //将默认值赋值给参数
                this.comment.index = index;
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
                }, 200);
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
                     this.posts[this.comment.index].post_comments.push(response.data);
                     this.posts[this.comment.index].post_comments_count ++;
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
            //删除帖子
            delPost(index, post){
                weui.confirm('你确定要删除该帖子吗？', () =>{
                    this.posts.splice(index, 1);
                    //发送ajax请求
                     axios.delete('/api/posts/'+post.id, {
                      	//key : value
                     })
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
            //跳转到帖子详情页
            skipPostInfo(post){
                //如果comment框显示则不进行跳转
                if(this.comment.is_show){
                    return
                }
                location.href = 'posts/' + post.id;
            },
            //设置类型
            setType(type){
                this.params.type = type;
                //刷新数据
                this.getPosts();
            }
        }
    }
</script>
<style>
    .weshop-center-block{width:60%;text-align:center;color:#bbb;margin-left: auto;margin-right: auto; margin-top: 30%;}
    .weshop-center-block i{font-size:8rem;}
    .weui-loadmore_line .weui-loadmore__tips {
        background-color: #f5f5f5;
    }
</style>