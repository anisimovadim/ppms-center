<template>
    <div class="container">
        <div class="head">
            <div class="info col-4">
                <h1>ППМС-Центр оздоровления и развития "Шаг к успеху"</h1>
                <p class="descriptor">- Структурное подразделение МАОУ СШ №4 г.Бор Нижегородской области</p>
            </div>
            <div class="logo col-2">
                <img draggable="false" src="../../../../public/images/logo.svg" alt="">
            </div>
            <div class="contacts col-3 text-end">
                <p class="contact">Контактная информация:</p>
                <p class="email" style="margin-top: 12px;">Email: <span>ppmscenterschool4@yandex.ru</span></p>
                <p class="phone" style="margin-top: 10px;">Номер телефона: <span>8(800)-555-35 35</span></p>
                <router-link to="/send/message/page">
                    <my-button style="width: 183px; margin-top: 16px;">Обратная связь</my-button>
                </router-link>
            </div>
        </div>
    </div>
    <div class="menu">
        <div class="container">

            <div class="links align-items-center justify-content-between">
                <router-link to="/" class="link">Главная</router-link>
                <router-link to="/news" class="link">Новости</router-link>
                <div @click="selectLinks = specialists" data-bs-toggle="dropdown" aria-expanded="false" class="link">
                    Специалисты <span><img :src="'/images/arrow.svg'" alt=""></span></div>
                <div @click="selectLinks = parents" data-bs-toggle="dropdown" aria-expanded="false" class="link">
                    Родителям <span><img :src="'/images/arrow.svg'" alt=""></span></div>
                <div @click="selectLinks = educations;" data-bs-toggle="dropdown" aria-expanded="false" class="link">
                    О нас <span><img :src="'/images/arrow.svg'" alt=""></span></div>
                <a href="http://127.0.0.1:9001/" target="_blank" class="link">Календарь событий</a>
                <router-link to="/registration" v-if="!accessToken">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                         class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                              d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                        <path fill-rule="evenodd"
                              d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                    </svg>
                </router-link>
                <router-link class="link" to="/admin/page" v-if="accessToken">Профиль</router-link>
                <dropdown-component :links="selectLinks"></dropdown-component>
            </div>
            <div class="menu-mobile">
                <div class="flex-grow-1 text-center">
                    <p style="color: white; font-size: 10px; font-weight: 500; margin: 0;">Меню</p>
                </div>
                <burger-button></burger-button>
                <mobile-menu :specialists="specialists" :parents="parents" :educations="educations"></mobile-menu>
            </div>

        </div>
    </div>
</template>

<script>
import MyButton from "@/components/ui/MyButton.vue";
import BurgerButton from "@/components/ui/BurgerButton.vue";
import DropdownComponent from "@/components/shared/DropdownComponent.vue";
import MobileMenu from "@/components/ui/MobileMenu.vue";

export default {
    name: "NavbarComponent",
    components: {MobileMenu, DropdownComponent, BurgerButton, MyButton},
    data() {
        return {
            specialists: [
                {title: 'Страница психолога', url: '/page=psychologist'},
                {title: 'Страница логопеда', url: '/page=logopedist'},
                {title: 'Страница дефектолога', url: '/page=defectologist'},
                {title: 'Страница учителя', url: '/page=teacher'},
                {title: 'Страница тьютора', url: '/page=tutor'},
            ],
            parents: [
                {title: 'Вам, родители!', url: '/'},
                {title: 'Профориентация', url: '/'},
            ],
            educations: [
                {title: 'Основные сведения', url: '/page=information'},
                {title: 'Наши сотрудники', url: '/specialists'},
                {title: 'Нормативная база инклюзивного образования', url: '/'},
                {title: 'Методические материалы', url: '/'},
            ],
            selectLinks: [],
        }
    },
    mounted() {
        this.init();
    },
    methods: {
        init() {
            this.selectLinks = this.specialists
        },
    },
    computed: {
        accessToken() {
            return this.$store.getters.getAccessToken;
        }
    },
}
</script>

<style scoped>
.head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 39px;
    margin-bottom: 56px;
}

img {
    max-width: 100%;
}

.email, .phone {
    font-weight: 200;
}

.email span, .phone span {
    color: #3C87AF;
    text-decoration: underline;
}

.menu {
    background-color: #3C87AF;
    height: 74px;
    display: flex;
    align-items: center;
}

.links {
    display: flex;
    gap: 42px;
}

.link {
    color: white;
    cursor: pointer;
    font-size: 15px;
}

.menu-mobile {
    display: none;
    align-items: center;
    justify-content: center;

}

svg {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

@media screen and (max-width: 1200px) {
    .link {
        font-size: 10px;
        white-space: nowrap;
    }
}

@media screen and (max-width: 766px) {
    .links {
        display: none;
    }

    .menu-mobile {
        display: flex;
    }

    .contacts {
        display: none;
    }
    .head {
        flex-direction: column-reverse;
        text-align: center;
        margin-top: 17px;
        margin-bottom: 27px;
        gap: 12px;
    }
}
</style>
