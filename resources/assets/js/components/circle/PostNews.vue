<template>
<div>

    <div class="me-header-top">
        <div><a href="/posts"><span class="fa fa-chevron-left fa-lg"></span></a></div>
        <div>消息中心</div>
        <div></div>
    </div>
    <div style="height:2rem;"></div>

    <div class="circle-home-content reply-me" v-for="item in post_news">
        <!--头像,名称,日期,-->
        <div class="circle-top">
            <div class="me-flex-2">
                <img class="me-img lazy"  :src="item.logo">
            </div>
            <div class="me-flex-9">
                <div class="circle-name">
                    <b>{{ item.username }}</b>
                    <b v-if="item.type == 3">
                        赞了我 <i class="fa fa-thumbs-o-up"></i>
                    </b>
                </div>
                <span class="circle-time">{{ item.created_at_str }}</span>
            </div>
            <!--div class="me-flex-1"><a>删除</a></div-->
        </div>
        <!--内容-->
        <div class="circle-content" v-if="item.type == 1 || item.type == 2">
            <div v-html="item.content"></div>
        </div>
        <div class="circle-critic">
            <!--原帖-->
            <div class="critic-replys">
                <span class="replys-triangle" v-if="item.type == 1 || item.type == 2"></span> <!--三角标志-->

                <div class="item" @click="skipPostInfo(item.post_id)" v-if="item.post_content">
                    <div >原帖：<span v-html="item.post_content"></span></div>
                </div>
                <div class="item" v-else>
                    帖子已经被删除啦!
                </div>
            </div>
            <div class="reply-me-b">
                <!--<span>板块：XXX</span>-->
                <!--<a   @click="skipPostInfo(item.post_id)" v-if="(item.type==1 || item.type==2) && item.post_content"><i class="fa fa-comment-o"></i> 回复</a>-->
            </div>
        </div>
    </div>

    <!--定义模板-->
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
             v-if="post_news.length == 0"
        >
            <i class="fa fa-bell-o fa-5x"></i>
            <div>暂时没有收到消息~</div>
        </div>
        <!--帖子为空时end-->

        <!-- on more start-->
        <div class="weui-loadmore weui-loadmore_line" v-else-if="!is_more">
            <span class="weui-loadmore__tips">已经到底啦</span>
        </div>
        <!--on more end-->
    </template>
    <!--loading end-->
</div>
</template>
<script>
    /*组件选项定义,包括data,methods,等*/
    export default {
        name: '',
        data () {
            return {
                params : {
                    offset : 0,
                    limit : 8,
                    order : 'created_at',
                    sort : 'desc',
                },
                next_offset : 0,
                post_news : [],
                is_show_loading : false,
                is_more : true,
            }
        },
        created(){
            this.getPostNews();
        },
        mounted(){
            $(window).scroll(() =>{
                /*console.log('整个页面的高度:'+ $(document).height()); //固定值
                 console.log('可视区域的高度:'+ $(window).height()); //缩小浏览器时会改变
                 console.log('匹配元素相对于滚动条顶部的偏移' + $(document).scrollTop());*/
//                 console.log('可视区域高度:'+this.height());
                if($(document).height() - $(window).height() < $(document).scrollTop() + 2){
                    //不在loading中并且存在更多的数据才能请求该方法加载更多的数据
                    if(!this.is_show_loading && this.is_more){
                        this.nextPosts();
                    }
                }
            })
        },
        methods : {
            getPostNews(){
                this.is_show_loading = true;
                axios.get('/api/post_news', {
                    params: this.params
                })
                .then(response=> {
                    this.post_news = response.data;
                    if(response.data.length < this.params.limit) {
                        this.is_more = false; //不存在多数据了
                    }else {
                        this.is_more = true;
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
                        post_category_id :  this.params.post_category_id
                    }
                })
                .then(response=> {
                    if(response.data.length > 0) {
                        //如果数据为空时也应吧is_show_loading = false;
                        //将取出的数据push到中
                        this.post_news.push.apply(this.post_news, response.data);
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
            skipPostInfo(post_id){
                 location.href="posts/"+ post_id
            }
        }
    }
</script>
<style>

</style>