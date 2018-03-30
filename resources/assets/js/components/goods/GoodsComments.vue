<template>
    <div>
        <!--- 评价内容 --->
        <div class="circle-home-content" v-for="(goods_comment,index) in goods_comments">
            <!--头像,名称,日期,板块-->
            <div class="circle-top">
                <div class="me-flex-1"><img class="me-img" :src="goods_comment.logo"></div>
                <div class="me-flex-9">
                    <div class="circle-name"><b>{{ goods_comment.username }}</b><span class="lv"></span></div>
                </div>
            </div>
            <small class="font-small">{{ goods_comment.created_at_str }} {{ goods_comment.goods_attributes }}</small>
            <!--内容显示三行,点击显示全部-->
            <div class="circle-content">
                <p v-html="goods_comment.content"></p>
            </div>
            <!--图片-->
            <div class="circle-content-img" v-if="goods_comment.goods_comment_images.length">
                <div class="me-flex-4" v-for="goods_comment_image in goods_comment.goods_comment_images" >
                    <img class="me-img lazy"
                         :src="goods_comment_image.sm_image"
                         @click.stop="showImages(goods_comment_image.image, goods_comment.goods_comment_images)"
                    >
                </div>
            </div>
        </div>

        <!--loading start-->
        <div class="weui-loadmore" v-if="is_show_loading" style="height:2rem;">
            <i class="weui-loading"></i>
            <span class="weui-loadmore__tips">正在加载</span>
        </div>
        <!--loading end-->
        <template v-else>
            <!--帖子为空时start-->
            <div class="weshop-center-block"
                 style="display:block;"
                 v-if="goods_comments.length == 0"
            >
                <i class="icon icon-community"></i>
                <div class="title">该商品暂时没有评价</div>
            </div>
            <!--帖子为空时end-->

            <!-- on more start-->
            <div class="weui-loadmore weui-loadmore_line" v-else-if="!is_more">
                <span class="weui-loadmore__tips">已经到底啦</span>
            </div>
            <!--on more end-->
        </template>
    </div>
</template>
<script>
    /*组件选项定义,包括data,methods,等*/
    export default {
        name: '',
        props : ['goods_id'],
        data () {
            return {
                goods_comments : [],
                params : {
                    offset : 0,
                    limit : 8,
                },
                is_show_loading : false,
                is_more : true,
                next_offset : 0,
            }
        },
        created(){
            this.getGoodsComments();
        },
        mounted(){
            $(window).scroll(() =>{
                if($(document).height() - $(window).height() < $(document).scrollTop() + 10){ // + 距离底部多少px进行数据的再次加载
                    if(!this.is_show_loading && this.is_more){
                        this.nextGoodsComments();
                    }
                }
            });
        },
        methods : {
            getGoodsComments(){
                //更改数据状态
                this.is_show_loading = true;
                this.is_more = true;
                this. next_offset = 0;
                axios.get('/api/goods_comments/'+this.goods_id, {
                    params: {
                        offset : this.next_offset,
                        limit : this.params.limit,
                    }
                })
                .then(response=> {
                    this.goods_comments = response.data;
                    if(response.data.length < this.params.limit) {
                        this.is_more = false; //不存在多数据了
                    }
                    this.$nextTick(function () {//等待数据渲染完毕才关闭 等待框.因为关闭了等待框才能进行下一次数据的加载,防止接口的多次调用
                        this.is_show_loading = false;
                    })
                })
                .catch(error=> {
                    this.is_show_loading = false;
                });
            },
            //加载更多接口
            nextGoodsComments(){
                this.is_show_loading = true;
                this.next_offset = this.next_offset + this.params.limit + 1; //当前的偏移量,加上条数,+1
                //得到第一次的next_params
                axios.get('/api/goods_comments/'+this.goods_id, {
                    params: {
                        offset : this.next_offset,
                        limit : this.params.limit,
                    }
                })
                .then(response=> {
                    if(response.data.length > 0) {
                        //如果数据为空时也应吧is_show_loading = false;
                        //将取出的数据push到中
                        this.goods_comments.push.apply(this.goods_comments, response.data);
                    }else{
                        this.is_more = false; //如果没有返回说明不存在更多的贴子了
                    }
                    this.$nextTick(function () {
                        this.is_show_loading = false;
                    })
                })
                .catch(error=> {
                    this.is_show_loading = false;
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
        }
    }
</script>
<style>
</style>