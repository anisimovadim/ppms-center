<template>
    <div class="block container">
        <div class="items">
            <div class="item" v-for="object in objects" :style="object.type==='image'? 'display:inline-block':''" :class="object.type==='image' && 'item-image'">
                <h3 v-if="object.type==='title'">{{object.value}}</h3>
                <p v-if="object.type==='text'">{{object.value}}</p>
                <a target="_blank" :href="object.value" v-if="object.type==='link'">{{object.value}}</a>
                <div class="block-file" v-if="object.type==='image'">
                    <img :src="getUrlFile(object.value)" alt="">
                </div>
                <div class="block-file" v-if="object.type==='video'" :class="object.type==='video' && 'block-video'">
                    <video :src="object.value" controls></video>
                </div>
                <div class="block-file" v-if="object.type==='file'">
                    <a :href="object.value" :download="getFileName(object.value)">
                        <my-button>Скачать</my-button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MyButton from "@/components/ui/MyButton.vue";

export default {
    name: "PostComponent",
    components: {MyButton},
    props:{
        mode:{
            type:String
        },
        objects:{
            type: Array,
            default:[]
        }
    },
    mounted() {

    },
    methods:{
        getFileName(url) {
            // Extracts the file name from the URL for the download attribute
            return url.split('/').pop();
        },
        getUrlFile(file){
            if (file.slice(0,1)=='s'){
                return `/${file}`
            }
            return file
        }
    },
    computed:{
        accessToken() {
            return this.$store.getters.getAccessToken;
        }
    }
}
</script>

<style scoped>
.container{
    display: flex;
    align-items: center;
    justify-content: center;
}
.item{
    margin: auto auto 30px;
    position: relative;
}
.item-image{
    max-width: 400px;
    margin: auto;
}
.block-file{
    margin: auto;
}
.block-video{
    max-width: 900px;
}
img{
    max-width: 100%;
}
video{
    max-width: 100%;
}
h3{
    max-width: 900px;
    text-align: left;
    line-height: 150%;
}
p{
    white-space: pre-wrap;
    max-width: 900px;
    line-height: 160%;
    font-size: 16px;
}
a{
    color: #3C87AF;
}
</style>
