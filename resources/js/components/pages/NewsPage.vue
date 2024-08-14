<template>
    <div class="container">
        <div class="d-flex justify-content-between mt-5">
            <div class="btn-create" v-if="accessToken">
                <router-link class="create-link" to="/create/news">Создать новость +</router-link>
            </div>
            <h2 class="flex-grow-1 text-center">Новости центра</h2>
            <div class="input-block d-flex">
                <my-input :placeholder="`Поиск...`" v-model:value="searchValue"></my-input>
                <my-button
                    style="max-width: 80px; background-image: url('images/search.svg'); background-repeat: no-repeat; background-position: center"></my-button>
            </div>
        </div>
        <div class="page">
            <div class="new" v-for="block in blocks">
                <div class="up">
                    <div class="d-flex align-items-center">
                        <span>{{ timeFormater(block.created_at) }}</span>
                        <h3 class="flex-grow-1 text-center">{{ block.title }}</h3>
                        <span class="delete-btn" @click="deleteNew(block.id)" v-if="accessToken">Удалить новость</span>
                    </div>
                    <div class="line"></div>
                </div>
                <div class="field" :style="styleBlock(block.block_elements[0]?.media_queries[0])">
                    <block-new v-for="block_element in block?.block_elements"
                               :style="block_element.media_queries[0].style"
                               :element="block_element.element"></block-new>
                </div>
                <div class="down">
                    <router-link :to="`/comments/new=${block.id}`">
                        <my-button>Оставить комментарий</my-button>
                    </router-link>

                    <div class="line mt-4"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MyInput from "@/components/ui/MyInput.vue";
import axios from "axios";
import BlockNew from "@/components/ui/BlockNew.vue";
import MyButton from "@/components/ui/MyButton.vue";
import api from "@/api.js";

export default {
    name: "NewsPage",
    components: {MyButton, BlockNew, MyInput},
    data() {
        return {
            blocks: [],
            searchValue:'',
            screenWidth: window.innerWidth,
            accessToken: localStorage.getItem('access_token') ? localStorage.getItem('access_token') : '',
        }
    },
    created() {
        document.title = 'Новости';
    },
    mounted() {
        this.initializeDevice();
    },
    methods: {
        getNewsForDesktop() {
            api.get('api/news/desktop/')
                .then(res => {
                    this.blocks = res.data
                    console.log(res.data)
                })
        },
        getNewsForTablet() {
            api.get('/api/news/tablet/')
                .then(res => {
                    this.blocks = res.data
                    console.log(res)
                })
        },
        getNewsForMobile() {
            api.get('/api/news/mobile/')
                .then(res => {
                    this.blocks = res.data
                    console.log(res.data)
                })
        },
        initializeDevice() {
            if (this.screenWidth > 1000) {
                this.getNewsForDesktop();
            } else if (this.screenWidth > 770 && this.screenWidth < 1000) {
                this.getNewsForTablet();
            } else {
                this.getNewsForMobile();
            }
        },
        styleBlock(media_query) {
            if (media_query.title === 'desktop') {
                return {maxWidth: '1000px', height: '550px'}
            } else if (media_query.title === 'tablet') {
                return {maxWidth: '770px', height: '400px'}
            } else {
                return {maxWidth: '300px', height: '250px'}
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
        updateScreenWidth() {
            this.screenWidth = window.innerWidth;
            console.log(this.screenWidth);
        },
        deleteNew(id) {
            api.post(`/api/auth/delete/new/${id}`, {})
                .then(res => {
                    this.initializeDevice();
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
}

.new {
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

.container {
    position: relative;
    max-width: 1200px;
}

.input-block {
    max-width: 300px;
    position: absolute;
    right: 0;
}

.btn-create {
    position: absolute;
    left: 10px;
}

.delete-btn {
    cursor: pointer;
}

@media screen and (max-width: 770px) {
    .input-block {
        width: 100%;
        position: absolute;
        right: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        top: 47px;
    }

    .btn-create {
        left: 50%;
        top: 26px;
        transform: translate(-50%, -50%);
    }

}

@media screen and (max-width: 400px) {
    .new {
        padding: 0;
    }
    .up, .down{
        padding: 10px;
    }
    .page{
        margin-top: 50px;
    }
}
</style>
