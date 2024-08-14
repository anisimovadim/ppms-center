<template>
    <div class="offcanvas offcanvas-start" :class="close?'show':''" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Меню</h5>
        </div>
        <div class="offcanvas-body" data-bs-dismiss="offcanvas" aria-label="Close">
            <ul>
                <li><router-link to="/">Главная</router-link></li>
                <li><router-link to="/news">Новости</router-link></li>
                <ol>
                    <li v-for="link in aboutUs"><router-link :to="link.url">{{link.title}}</router-link></li>
                </ol>
                <li class="category"> - Специалисты - </li>
                <ol>
                    <li v-for="link in specialists"><router-link :to="link.url">{{link.title}}</router-link></li>
                </ol>
                <li class="category"> - Родителям - </li>
                <ol>
                    <li v-for="link in parents"><router-link :to="link.url">{{link.title}}</router-link></li>
                </ol>
                <li class="category"> - Образование и методические материалы - </li>
                <ol>
                    <li v-for="link in educations"><router-link :to="link.url">{{link.title}}</router-link></li>
                </ol>
                <li><router-link to="/">Календарь событий</router-link></li>
                <p class="logout">Выйти</p>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "MobileMenu",
    props:{
        specialists:{
            type:Array
        },
        parents:{
            type:Array
        },
        educations:{
            type:Array
        },
        aboutUs:{
            type:Array
        },
    },
    data(){
        return{
            close: false
        }
    },
    methods:{
        clickLink(){
            this.close=true;
        }
    }
}
</script>

<style scoped>
ul{
    list-style: none;
}
ol{
    list-style: circle;
}
li{
    margin-bottom: 15px;
}
.offcanvas-body ul li a{
    color: black;
    font-size: 15px;
}
.offcanvas-body ul li div{
    color: black;
    font-size: 15px;
}
.category{
    background-color: #3C87AF;
    color: white;
    padding: 10px;
}
.logout{
    font-size: 15px;
    cursor: pointer;
    color: #3C87AF;
    display: flex;
    justify-content: flex-end;
}
</style>
