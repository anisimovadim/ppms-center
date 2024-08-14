<template>
    <div class="container">
        <div class="page" v-if="block">
            <div class="up">
                <div class="d-flex align-items-center">
                    <span>{{ timeFormater(block.created_at) }}</span>
                    <h3 class="flex-grow-1 text-center">{{ block.title }}</h3>
                </div>
                <div class="line"></div>
            </div>
            <div class="field new" :style="styleBlock(block.block_elements[0].media_queries[0])">
                <block-new v-for="block_element in block?.block_elements"
                           :style="block_element.media_queries[0].style"
                           :element="block_element.element"></block-new>
            </div>
            <div class="block-send">
                <form @submit.prevent="sendComment">
                    <h3>Оставьте комментарий</h3>
                    <div class="name-email">
                        <div class="input">
                            <label for="name" class="form-label">Имя</label>
                            <my-input id="name" v-model:value="comment.name"></my-input>
                        </div>
                        <div class="input">
                            <label for="email" class="form-label">Email <span style="color: #a9a9a9">(Ваш email не будет опубликован)</span></label>
                            <my-input id="email" v-model:value="comment.email"></my-input>
                        </div>
                    </div>
                    <div class="input mt-3">
                        <label class="form-label">Комментарий</label>
                        <textarea v-model="comment.text" class="form-control"></textarea>
                    </div>
                    <my-button class="mt-4" type="submit">Отправить</my-button>
                </form>
            </div>
            <div class="block-comments" v-if="comments.length>0">
                <h3>Комментарии</h3>
                <div class="item" v-for="el in comments">
                    <comment-component :comment="el"></comment-component>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import api from "@/api.js";
import BlockNew from "@/components/ui/BlockNew.vue";
import MyInput from "@/components/ui/MyInput.vue";
import MyButton from "@/components/ui/MyButton.vue";
import axios from "axios";
import CommentComponent from "@/components/shared/CommentComponent.vue";

export default {
    name: "CommentPage",
    components: {CommentComponent, MyButton, MyInput, BlockNew},
    data() {
        return {
            block_id: '',
            block: '',
            screenWidth: window.innerWidth,
            comment: {
                name: '',
                email: '',
                text: ''
            },
            comments:[]
        }
    },
    created() {
        document.title = `Блок #${this.$route.params.id}`
    },
    mounted() {
        this.getBlockId();
        this.initializeDevice();
    },
    methods: {
        getBlockId() {
            this.block_id = this.$route.params.id;
            this.getComments();
        },
        getNewForDesktop() {
            api.get(`/api/news/desktop/${this.block_id}`)
                .then(res => {
                    this.block = res.data
                    console.log(res.data)
                })
        },
        getNewForTablet() {
            api.get(`/api/news/tablet/${this.block_id}`)
                .then(res => {
                    this.block = res.data
                    console.log(res.data)
                })
        },
        getNewForMobile() {
            api.get(`/api/news/mobile/${this.block_id}`)
                .then(res => {
                    this.block = res.data
                    console.log(res.data)
                })
        },
        initializeDevice() {
            if (this.screenWidth > 1000) {
                this.getNewForDesktop();
            } else if (this.screenWidth > 770 && this.screenWidth < 1000) {
                this.getNewForTablet();
            } else {
                this.getNewForMobile();
            }
        },
        getComments() {
            axios.get(`/api/comments/post/${this.block_id}`)
                .then(res=>{
                    this.comments=res.data
                })
        },
        styleBlock(media_query) {
            if (media_query.title === 'desktop') {
                return {maxWidth: '1000px', height: '550px'}
            } else if (media_query.title === 'tablet') {
                return {maxWidth: '770px', height: '400px'}
            } else {
                return {maxWidth: '400px', height: '250px'}
            }
        },
        timeFormater(dataTime) {
            if (dataTime) {
                let date = dataTime.split('T')[0].split('-');
                let day = date[2];
                let month = date[1];
                let year = date[0];
                return `${day}.${month}.${year}`
            }
            return ''
        },
        sendComment() {
            api.post('/api/send/comment', this.comment, {
                params: {block_id: this.block_id}
            })
                .then(res => {
                    this.comment = {
                        name: '',
                        email: '',
                        text: ''
                    }
                    console.log('success')
                })
                .catch(error => {
                    console.log(error)
                })
        }

    }
}
</script>

<style scoped>
.page {
    background-color: white;
    box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.15);
    width: 100%;
    margin-top: 35px;
    padding: 50px;
}

.field {
    position: relative;
    margin: auto;
}

.line {
    width: 100%;
    height: 1px;
    background-color: #194156;
}

.block-send {
    max-width: 700px;
    margin: 50px auto auto;
}

.name-email {
    display: flex;
    gap: 20px;
}

.form-control {
    border-radius: 0;
}

.block-send h3 {
    text-align: left;
    font-size: 18px;
    margin-bottom: 35px;
    font-weight: 200;
}

.input {
    width: 100%;
}

input {
    width: 100%;
}
.block-comments{
    margin-top: 80px;
}
.block-comments h3{
    text-align: left;
    font-size: 18px;
    margin-bottom: 35px;
    font-weight: 200;
}
</style>
