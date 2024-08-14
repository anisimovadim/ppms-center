<template>
    <div class="container">
        <div class="block">
            <div class="view p-4">
                <h3>{{ btns[selectBtn]?.title }}</h3>
                <div class="block-messages" v-if="selectBtn===1">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>От кого</th>
                            <th>Дата</th>
                            <th style="width: 400px;">Данные</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="message in messages">
                            <td>{{ message.name }}</td>
                            <td>{{ formatterTime(message.created_at) }}</td>
                            <td>
                                <ul class="comment">
                                    <li><span class="bolder-text">Адрес эл. почты:</span> {{ message.email }}</li>
                                    <li><span class="bolder-text">Сообщение:</span> {{ message.comment }}</li>
                                </ul>
                            </td>
                            <td>
                                <my-button @click="emailTo=message.email; textMessageUser=message.comment"
                                           data-bs-toggle="modal" data-bs-target="#sendMessageModal">Ответить
                                </my-button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <modal-component :id="'sendMessageModal'" title="Ответ на сообщение" @actionFrom="onSending">
                        <div class="alert alert-ppms" v-if="messageServer">{{messageServer}}</div>
                        <div class="mb-3" v-for="el in messageObj">
                            <label :for="el.name" class="form-label">{{ el.label }}</label>
                            <input :id="el.name" type="text" v-model="el.value" class="form-control" :class="valid[`${el.name}`] && 'is-invalid'">
                            <div class="text-danger" v-if="valid[`${el.name}`]">{{valid[`${el.name}`][0]}}</div>
                        </div>
                    </modal-component>
                </div>
                <div class="block-comments" v-if="selectBtn===0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Ответ</th>
                            <th>Имя</th>
                            <th>Почта</th>
                            <th style="width:250px;">Сообщение</th>
                            <th class="text-center">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="comment in comments">
                            <td>-</td>
                            <td>{{ comment.name }}</td>
                            <td>{{ comment.email }}</td>
                            <td>{{ comment.text }}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-3" v-if="comment.status === 0">
                                    <my-button style="max-width: 100px" @click="changeStatus(1, comment.id)">Принять</my-button>
                                    <my-button-grey style="max-width: 100px" @click="changeStatus(2, comment.id)">Отклонить</my-button-grey>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel">
                <div class="info">
                    <div class="avatar">
                        <img draggable="false" :src="`/images/avatar.svg`" alt="">
                    </div>
                    <div class="teta">
                        <div class="user-info">
                            <p class="bolder-text">{{ userData.name }}</p>
                            <p class="email mt-2">{{ userData.email }}</p>
                        </div>
                        <div class="line"></div>
                        <div class="btns">
                            <div v-for="btn in btns" :key="btn.id" class="d-flex align-items-center gap-2 category-btn"
                                 :class="{ select: selectBtn === btn.id }" @click="onSelect(btn.id)">
                                <div class="icon"><img :src="btn.icon" alt=""></div>
                                <p>{{ btn.title }}</p>
                            </div>
                        </div>
                        <my-button class="w-100 mt-4" @click="logout">Выйти</my-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MyButton from "@/components/ui/MyButton.vue";
import MyButtonGrey from "@/components/ui/MyButtonGrey.vue";
import axios from "axios";
import BurgerButton from "@/components/ui/BurgerButton.vue";
import api from "../../../api";
import ModalComponent from "@/components/ui/ModalComponent.vue";

export default {
    name: "AdminPage",
    components: {ModalComponent, BurgerButton, MyButtonGrey, MyButton},
    data() {
        return {
            btns: [
                {icon: '/images/comments.svg', title: 'Комментарии', id: 0},
                {icon: '/images/message.svg', title: 'Обратная связь', id: 1},
                {icon: '/images/statistic.svg', title: 'Статистика сайта', id: 2},
            ],
            selectBtn: 0,
            userData: '',
            messages: [],
            comments: [],
            messageObj: [
                {label: 'Заголовок сообщения', value: '', name: 'title'},
                {label: 'Сообщение', value: '', name: 'text'},
            ],
            emailTo: '',
            textMessageUser: '',
            valid:{},
            messageServer:'',
            valueSearch:'',
            news:[]
        };
    },
    mounted() {
        this.getUser();
    },
    created() {
        document.title = 'Админ панель';
    },
    methods: {
        onSelect(id) {
            if (id!==2){
                this.selectBtn = id;
            }else{
                window.open('https://metrika.yandex.ru/dashboard?id=97395896');
            }
        },
        getUser() {
            api.post('/api/auth/me')
                .then(res => {
                    this.getComments();
                    this.getMessages();
                    this.userData = res.data
                });
        },
        getMessages() {
            api.get('/api/auth/messages')
                .then(res => {
                    this.messages = res.data;
                })
        },
        getComments() {
            api.get('/api/auth/comments')
                .then(res => {
                    this.comments = res.data;
                })
        },
        onSending() {
            let mess = this.messageObj.reduce((acc, el) => {
                acc[el.name] = el.value;
                return acc
            }, {});
            mess.email = this.emailTo
            mess.user_message = this.textMessageUser
            api.post('/api/auth/send/message/email', mess)
                .then(res => {
                    this.messageServer = res.data
                })
                .catch(err => {
                    this.valid=err.response.data;
                    console.log(err.response.data)
                })
            let a = this.searchingNews
        },
        logout() {
            api.post('/api/auth/logout')
                .then(res => {
                    this.$store.commit('removeAccessToken');
                    this.$router.push('/registration');
                })
        },
        formatterTime(time) {
            return time.split('T')[0]
        },
        changeStatus(status, id){
            api.post(`/api/auth/change/status/comment/${id}`, {status})
                .then(res=>{
                    this.getComments();
                })
        }
    },
    // computed:{
    //     searchingNews(){
    //         if (this.valueSearch){
    //             return this.news.filter((el)=>{
    //                 if (el.type==='text'){
    //                     return el.value.toLowerCase().includes(this.valueSearch)
    //                 }else{
    //                     return el
    //                 }
    //             })
    //         }
    //     }
    // }
}
</script>

<style scoped>
.container {
    width: 100%;
}

.block {
    display: flex;
    flex-direction: row-reverse;
    width: 100%;
}

.bolder-text {
    text-align: center;
}

.form-control {
    border-radius: 0;
}

.email {
    text-align: center;
}

.info {
    width: 390px;
    padding: 30px;
}

.info, .view {
    background-color: white;
    box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.15);
}

.view {
    width: 100%;
}

.avatar {
    max-width: 180px;
    margin: auto;
}

.avatar img {
    width: 100%;
}

table {
    margin-top: 30px;
}

th {
    color: #246487;
    font-size: 15px;
}

td {
    font-size: 15px;
}

.email {
    color: #3C87AF;
    font-size: 13px;
}

.line {
    height: 1px;
    width: 100%;
    background-color: #246487;
    margin: 20px 0;
}

.category-btn {
    width: 100%;
    cursor: pointer;
    padding: 6px 9px;
    background-color: rgba(60, 135, 175, 0.23);
    margin-bottom: 11px;
}

.icon {
    width: 12px;
}

.icon img {
    width: 100%;
}

h3 {
    text-align: left;
}

.select {
    background-color: rgb(60, 135, 175);
    color: white;
}

.select .icon img {
    filter: invert(100%);
}

.comment {
    max-width: 400px;
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

@media screen and (max-width: 980px) {
    .block {
        width: 100%;
        max-width: 100%;
        flex-direction: column-reverse;
    }

    .panel {
        width: 100%;
    }

    .teta {

    }

    .btns, .line {

    }

    .panel {
        width: 100%;
    }

    .info {
        display: grid;
        grid-template-columns: 1fr auto;
        width: 100%;
        padding: 15px;
    }

    .info p {
        text-align: left;
    }

    .btns {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .btns .category-btn {
        margin: 0;
        padding: 0 5px;
        max-width: 120px;
    }

    .view {
        width: 100%;
    }

    .avatar {
        max-width: 60px;
    }
}
</style>

