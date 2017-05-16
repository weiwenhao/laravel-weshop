<template>
    <!--定义模板-->
    <div>
        <!--********************************************-->
        <div class="circle-head">
            <div class="logo"></div>
            <div class="circle-h-mid">
                <span class="me-flex-3"></span>
                <span class="me-flex-6" style="font-size:0.9rem">校园商城</span>
                <span class="me-flex-3">进来逛逛 <i class="fa fa-angle-right"></i></span>
            </div>
        </div>
        <!--导航-->
        <div class="home-circle-nav">
           <!-- <div class="circle-nav">
                <span class="me-flex-3 action">首页</span>
                <span class="me-flex-3">精华</span>
                <span class="me-flex-3">客服</span>
                <span class="me-flex-3">达人榜</span>
                <hr>
            </div>-->
            <div class="circle-nav-b">
                <a  :class="{ 'action':category.id==params.category_id }" v-for="category in  categories">{{ category.name }}</a>
            </div>
        </div>

        <div class="circle-home-content" v-for="circle in circles">
            <!--头像,名称,日期,板块-->
            <div class="circle-top">
                <div class="me-flex-2">
                    <img class="me-img lazy" :src="circle.logo">
                </div>
                <div class="me-flex-9">
                    <div class="circle-name"><b>{{ circle.username }}</b><span class="lv"></span></div>
                    <span class="circle-time">{{ circle.created_at_str }}</span>
                    <span class="circle-block"> 板块：<tt>{{ circle.post_category_name }}</tt></span>
                </div>
            </div>
            <!--内容显示三行,点击显示全部-->
            <div class="circle-content">
                <div v-html="circle.content">
                </div>
            </div>
            <!--图片-->
            <div class="circle-content-img" v-if="circle.post_images.length">
                <div class="me-flex-4" v-for="post_image in circle.post_images">
                    <img class="me-img lazy"
                         :src="post_image.sm_image"
                         @click="showImages(post_image.image, circle.post_images)"
                    >
                </div>
            </div>
            <!--评论-->
            <div class="circle-critic">
                <div class="critic-top"><!--评论数量和赞-->
                    <span class="critic-t-r">
                        <a class="onReply">
                            <i class="fa fa-commenting-o"></i><span style="font-size:0.8rem"> 0</span>
                        </a>
                        <i class="fa fa-thumbs-o-up"></i><span style="font-size:0.8rem"> {{ circle.likes_count }}</span>
                    </span>
                </div>
                <!--评论-->
                <!--<div class="critic-replys">
                    <div class="item">
                        <a>诚哥:</a><span>谁谁谁sadafFdf谁谁谁sadafFdfd谁谁谁d谁谁谁</span>
                    </div>
                </div>-->
                <!--弹出文本框-->
                <!--<div class="critic-main">
                    <div class="reply">
                        <textarea placeholder="回复谁谁谁"   rows="4" ></textarea>
                        <span>
					        <a class="on-reoly-no">取消</a>
                            <a class="sub">发送</a>
                        </span>
                    </div>
                </div>-->
            </div>
        </div>

        <div style="height:2rem"></div>
        <!--↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓- 底部发帖按钮 -↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓-->
        <div class="circle-home-bottom">
            <div class="me-flex-4">&nbsp;</div>
            <div class="me-flex-4">
                <a class="circle_send" id="fatie" href="/circles/create"><!---->
                    <i class="fa fa-pencil-square-o" ></i>
                    发帖子
                </a>
            </div>
            <div class="me-flex-4">&nbsp;</div>
        </div>

    </div>
</template>
<script>
    /*组件选项定义,包括data,methods,等*/
    export default {
        name: 'Circles',
        data () {
            return {
                params : {
                    offset : 0,
                    limit : 8,
                    order : 'created_at',
                    sort : 'desc',
                    category_id : null
                },
                categories : [],
                circles : [],
            }
        },
        created(){
            this.getPostCate();
            this.getCircles();
        },
        mounted(){

        },
        methods : {
            getCircles(){
                axios.get('/api/posts', {
                    params: this.params //params参数会被附加到get请求中
                })
                .then(response=> {
                    this.circles = response.data;
                })
                .catch(error=> {
                	console.log(error);
                });
            },
            getPostCate(){
                axios.get('/post_categories', {
                    /*params: {
                     article_id: this.article_id,
                     }*/
                })
                    .then(response=> {
                        this.categories = response.data;
                        this.categories.unshift({
                            'id' : null,
                            'name' : '全部'
                        });
                    })
                    .catch(error=> {
                        console.log(error);
                    });
            },
            showImages(current_img, imgs){
                //调用微信接口
                let urls = [];
                for(let i = 0; i< imgs.length; ++i){
//                    urls.push('http://' + location.hostname+ imgs[i].image)
                    urls.push(imgs[i].image)
                }
                 console.log(urls);
                wx.previewImage({
                    current: 'http://' + location.hostname+ current_img, // 当前显示图片的http链接
                    urls: urls // 需要预览的图片http链接列表
                });
            }
        }
    }
</script>
<style>

</style>