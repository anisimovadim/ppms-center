<template>
    <div class="container">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h2>{{ getTitle }}</h2>
                <router-link :to="`/create/post/page=${$route.params.id}`" v-if="accessToken">
                    <my-button>Добавить запись</my-button>
                </router-link>
            </div>
            <div class="alert alert-ppms mt-3" v-if="message">
                {{message}}
            </div>
            <div class="posts mt-5">
                <div class="post" v-for="(post, index) in posts">
<!--                    <div class="line" v-if="index===0"></div>-->
                    <router-link class="edit" v-if="accessToken" :to="`/edit/post/page=${$route.params.id}/post=${post.id}`">Редактировать</router-link>
                    <p class="delete" v-if="accessToken" @click="deletePost(post.id)">Удалить</p>
                    <post-component :objects="post.post_objects" class="item"></post-component>
<!--                    <div class="line"></div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import MyButton from "@/components/ui/MyButton.vue";
import PostComponent from "@/components/shared/PostComponent.vue";
import api from "@/api.js";
import router from "@/router.js";

export default {
    name: "SpecialPage",
    components: {PostComponent, MyButton},
    data() {
        return {
            posts: [],
            message:''
        }
    },
    mounted() {
        this.updateTitle()
    },
    watch: {
        '$route.params.id': 'updateTitle'
    },
    methods: {
        router() {
            return router
        },
        updateTitle() {
            this.posts=[];
            document.title = this.getTitle;
            this.getPosts();
        },
        getPosts() {
            axios.get(`/api/posts/${this.$route.params.id}`)
                .then(res => {
                    this.posts = res.data;
                    console.log(res.data)
                })
                .catch(err => {

                })
        },
        deletePost(id){
            api.post(`/api/auth/delete/post/${id}`)
                .then(res=>{
                    this.message = res.data;
                    this.getPosts();
                    setTimeout(()=>{
                        this.message=''
                    }, 2000)
                })
                .catch(err=>{
                    console.log(err.response)
                })
            console.log(id)
        }
    },
    computed: {
        getTitle() {
            switch (this.$route.params.id) {
                case 'psychologist':
                    return 'Страница психолога'
                case 'logopedist':
                    return 'Страница логопеда'
                case 'defectologist':
                    return 'Страница дефектолога'
                case 'teacher':
                    return 'Страница учителя'
                case 'tutor':
                    return 'Страница тьютора'
                case 'information':
                    return 'Основные сведения'
            }
        },
        accessToken() {
            return this.$store.getters.getAccessToken;
        }
    }
}
</script>

<style scoped>
.content {
    margin-top: 50px;
    margin-bottom: 30px;
}
.posts{
    background-color: white;
    box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.15);
    padding: 50px;
}
.post{
    position: relative;
    margin-bottom: 30px;
}
.line{
    width: 100%;
    height: 1px;
    background-color: #194156;
}
.item{
    margin-top: 40px;
    margin-bottom: 40px;
}
.delete{
    position: absolute;
    right: 0;
    cursor: pointer;
    color: rgba(60, 135, 175, 0.24);
    transition: .3s;
    z-index: 99;
}
.delete:hover{
    color: #3C87AF;
    transition: .3s;
}
.edit{
    position: absolute;
    left: 0;
    z-index: 99;
    color: rgba(60, 135, 175, 0.24);
}
.edit:hover{
    color: #3C87AF;
    transition: .3s;
}
</style>
