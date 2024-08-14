<template>
    <div class="main-carusel">
        <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item" v-for="(img, index) in imagesSlide" :class="index===0?'active':''">
                        <div class="item-img">
                            <div class="block-img">
                                <img :src="img" class="d-block w-100" alt="...">
                            </div>
                        </div>

                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
        </div>
    </div>
    <div class="container">
        <div class="section col-6">
            <h2>Направления работы ППМС-Центра для детей с ОВЗ</h2>
            <div class="block-main-content">
                <div class="block-content">
                    <div class="item" v-for="(direction, index) in directions">
                        <div class="counter">{{index+1}}</div>
                        <p>{{direction}}</p>
                    </div>
                </div>
                <div class="element-style2">
                    <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M51.4312 0.389941C51.698 0.617644 51.8839 0.925538 51.9612 1.26763C52.0385 1.60972 52.0031 1.96765 51.8602 2.28794C46.8877 13.4354 36.4455 28.8404 28.8015 36.8679C26.6564 39.1105 24.0147 40.8181 21.0892 41.8534C21.0307 42.5912 20.8942 43.6019 20.5692 44.6744C19.916 46.8162 18.4015 49.4812 15.0182 50.3294C11.7419 51.1111 8.34596 51.2567 5.01472 50.7584C4.3961 50.6564 3.78568 50.5098 3.18822 50.3197C2.63709 50.1505 2.12314 49.8781 1.67372 49.5169C1.3764 49.2667 1.14815 48.9445 1.01072 48.5809C0.837595 48.1158 0.842224 47.6031 1.02372 47.1412C1.33247 46.3449 2.05072 45.9062 2.52197 45.6722C3.80247 45.0319 4.55322 44.1999 5.33972 42.9877C5.64847 42.5197 5.93772 42.0224 6.27247 41.4537L6.65272 40.8102C7.14347 39.9814 7.71222 39.0552 8.42722 38.0542C10.1432 35.6524 12.3305 35.0479 14.1017 35.1422C14.5134 35.1682 14.8904 35.2202 15.2327 35.2982C15.4342 34.7392 15.6942 34.0632 16.0062 33.3222C16.8545 31.3104 18.1447 28.7104 19.864 26.5979C26.936 17.9204 39.949 6.42844 49.4942 0.259941C49.7881 0.0702693 50.1353 -0.0195281 50.4843 0.00389276C50.8332 0.0273136 51.1653 0.162703 51.4312 0.389941ZM15.2912 38.7139C14.8606 38.5244 14.3993 38.4143 13.9295 38.3889C13.13 38.3467 12.0672 38.5514 11.0727 39.9457C10.4325 40.8394 9.91897 41.6747 9.44772 42.4709L9.10647 43.0462C8.76197 43.6344 8.41422 44.2227 8.06647 44.7622C7.40777 45.8283 6.57252 46.7745 5.59647 47.5604C7.83897 47.9244 11.2385 47.9212 14.2317 47.1704C16.0485 46.7187 16.9715 45.3212 17.459 43.7254C17.6983 42.9336 17.8359 42.1145 17.8685 41.2879L15.2912 38.7139ZM19.9712 38.7984C20.3612 38.6684 20.8715 38.4734 21.4597 38.2037C23.3307 37.333 25.0226 36.1205 26.4485 34.6287C32.6235 28.1417 46.1175 6.57794 46.1175 6.57794C46.1175 6.57794 28.028 21.7229 22.386 28.6519C20.9495 30.4167 19.8022 32.6917 18.9995 34.5864C18.6062 35.5224 18.304 36.3414 18.1057 36.9264L19.9712 38.7984Z" fill="#194156" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="section">
            <h2 class="col-8 m-auto" style="text-align: center">Материально-техническая база и оснащенность образовательного процесса для детей с РАС</h2>
            <div class="material-carusel">
                <div id="carouselExampleIndicators2" class="carousel carousel-dark slide w-100">
                    <div class="carousel-block col-10 m-auto">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide-to="3" aria-label="Slide 4"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item" v-for="(el, index) in materialImageSile" :class="index===0? 'active':''">
                                <div class="main-block-carusel d-flex align-items-center justify-content-center w-100">
                                    <div class="block">
                                        <div class="image col-5">
                                            <img :src="el.img" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="information d-flex flex-column justify-content-between">
                                            <div>
                                                <p style="font-weight: 600">{{el.title}}</p>
                                                <p>{{el.description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <h2 class="col-5">Информация о контингенте обучающихся</h2>
            <div class="table-block col-10 m-auto">
                <p v-if="getAccessToken" class="text-end edit" data-bs-toggle="modal" data-bs-target="#editTableModal">Редактировать</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-6">Состояние</th>
                        <th style="width: 300px">Кол-во детей</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="diagnose in tableDiagnoses">
                        <td style="padding-left: 10%;">{{diagnose.title}}</td>
                        <td style="width: 300px; text-align: center">{{diagnose.count}}</td>
                    </tr>
                    <tr class="text-center" v-if="tableDiagnoses.length===0">
                        <td colspan="2">Записей не обнаружено. Добавьте хотябы одну запись</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <modal-component id="editTableModal" title="Изменить таблицу" @actionFrom="editDiagnozesTable">
            <div class="alert alert-ppms text-center" v-if="editTable || message">{{message}}</div>
            <div class="mb-3" v-for="(diagnose, index) in tableDiagnoses">
                <div class="d-flex gap-3 align-items-center">
                    <input @change="changeInput" type="text" class="form-control" v-model="diagnose.title">
                    <input @change="changeInput" type="number" style="max-width: 100px" class="form-control" v-model="diagnose.count">
                    <svg @click="deleteElement(index)" style="max-width: 17px; cursor: pointer" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                    </svg>
                </div>
            </div>
            <div class="plus text-center">
                <plus-btn @click="createElement"></plus-btn>
            </div>
        </modal-component>
    </div>
</template>

<script>
import MyButton from "@/components/ui/MyButton.vue";
import ModalComponent from "@/components/ui/ModalComponent.vue";
import PlusBtn from "@/components/ui/PlusBtn.vue";
import api from "@/api.js";

export default {
    name: "HomePage",
    components: {PlusBtn, ModalComponent, MyButton},
    data(){
        return{
            imagesSlide:[
                '/images/slide1.jpg',
                '/images/slide2.jpg',
                '/images/slide3.jpg',
            ],
            materialImageSile:[
                {img: '/images/slideMat1.jpg', title:'Учебный кабинет',
                    description:'Кабинеты для специалистов, ' +
                        'работающих с детьми с ' +
                        'расстройствами  аутистического спектра (РАС), представляют собой специализированные  ' +
                        'помещения, в которых создаются условия для эффективной коррекционной  работы.'},
                {img: '/images/slideMat2.jpg', title:'Учебный кабинет',
                    description:'Кабинеты для специалистов, ' +
                        'работающих с детьми с ' +
                        'расстройствами  аутистического спектра (РАС), представляют собой специализированные  ' +
                        'помещения, в которых создаются условия для эффективной коррекционной  работы.'},
                {img: '/images/slideMat3.jpg', title:'Учебный кабинет',
                    description:'Кабинеты для специалистов, ' +
                        'работающих с детьми с ' +
                        'расстройствами  аутистического спектра (РАС), представляют собой специализированные  ' +
                        'помещения, в которых создаются условия для эффективной коррекционной  работы.'},
                {img: '/images/slideMat4.jpg', title:'Учебный кабинет',
                    description:'Кабинеты для специалистов, ' +
                        'работающих с детьми с ' +
                        'расстройствами  аутистического спектра (РАС), представляют собой специализированные  ' +
                        'помещения, в которых создаются условия для эффективной коррекционной  работы.'},
            ],
            directions:[
                'Профилактика социально-психологических рисков при переходе на новый уровень образования',
                'Повышение психолого-педагогической культуры участников образовательных отношений (обучение родителей и педагогов)',
                'Коррекционно-развивающая работа с различными контингентами детей',
                'Сопровождение профессионального самоопределения и профилактика безнадзорности и правонарушений',
                'Сопровождение учащихся, прошедших ПМПк, ТПМПК и  психологическая подготовка к сдаче экзаменов (в ходе ГИА)',
                'Сохранение и укрепление здоровья учащихся и педагогов, пропаганда здорового образа жизни'
            ],
            tableDiagnoses:[],
            editTable:false,
            message:''
        }
    },
    created() {
        document.title = 'Главная страница';
    },
    mounted() {
        this.getDiagnozes();
    },
    methods:{
        getDiagnozes(){
            api.get('/api/diagnoses')
                .then(res=>{
                    this.tableDiagnoses = res.data
                })
        },
        editDiagnozesTable(){
            api.post('/api/auth/change/table/diagnoses', this.tableDiagnoses)
                .then(res=>{
                    this.getDiagnozes();
                    this.message=res.data;
                    setTimeout(()=>{
                        this.editTable=false;
                        this.message='';
                    }, 3000)
                })
                .catch(err=>{
                    this.message=err.data
                })
        },
        createElement(){
            this.message='Данные не сохранены! После редактирование таблицы необходимо нажать на кнопку "Сохранить".'
            this.editTable = true;
            this.tableDiagnoses.push({
                title:'Измените поле',
                count:0
            })
        },
        changeInput(){
            this.message='Данные не сохранены! После редактирование таблицы необходимо нажать на кнопку "Сохранить".'
            this.editTable = true;
        },
        deleteElement(index){
            this.message='Данные не сохранены! После редактирование таблицы необходимо нажать на кнопку "Сохранить".'
            this.editTable = true;
            this.tableDiagnoses = this.tableDiagnoses.filter((el,i)=>i!==index);
        }
    },
    computed:{
        getAccessToken() {
            return this.$store.getters.getAccessToken;
        }
    }

}
</script>

<style scoped>
.main-carusel{
    height: 531px;
    width: 100%;
    background: linear-gradient(rgba(0, 0, 0, 0.53), rgba(0, 0, 0, 0.38)),url("/public/images/imgschool.jpg");
    background-repeat: no-repeat;
    background-position-x: center;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
}
.material-carusel{
    display: flex;
    align-items: center;
    justify-content: center;
}
#carouselExampleIndicators2{
    height: 400px;
    display: flex;
    align-items: center;
}
.block{
    display: flex;
    justify-content: center;
    gap: 20px
}
.carousel-control-next{
    justify-content: flex-end;
}
.carousel-control-prev{
    justify-content: flex-start;
}
.carousel{
    width: 800px;
}
.block-img{
    max-width: 590px;
}
.item-img{
    width: 100%;
    height: 500px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.block-img img{
    width: 100%;
}
.carousel-indicators{
    bottom: 0;
}
.block-content{
    display: grid;
    grid-template-columns: auto auto;
    gap: 90px;
    max-width: 1000px;
    margin: auto;
}
.block-main-content{
    position: relative;
    margin-top: 40px;
    padding-top: 56px;
    padding-bottom: 56px;
    background-image: url("/public/images/liner.svg");
    background-repeat: no-repeat;
    background-position-x: -10%;
}
.section{
    margin-top: 110px;
    width: 100%;
}
.table-block{
    background-image: url("/public/images/backTable.jpg");
    background-size:contain;
    background-repeat: no-repeat;
    padding: 10px;
}
.element-style2{
    right: 0;
    position: absolute;
}
.counter{
    width: 100px;
    height: 100px;
    background-color: #3C87AF;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 36px;
}
.item{
    max-width: 390px;
    display: grid;
    grid-template-columns: 100px auto;
    gap: 14px;
}
table{
    margin-top: 20px;
    margin-bottom: 100px;
    box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.15);
}
th{
    background-color: #3C87AF;
    text-align: center;
    color: white;
    padding: 15px 0;
}
td{
    padding-top: 20px;
    padding-bottom: 20px;
}
.table-block{
    background-color: white;
}
.edit{
    cursor: pointer;
    text-decoration: underline;
    color: #3C87AF;
}
.form-control{
    border-radius: 0;
}
@media screen and (max-width: 1365px) {
    .block-main-content{
        background-position-x: 70%;
    }
}
@media screen and (max-width: 980px) {
    .block-main-content{
        background-position-x: 50%;
    }
}
@media screen and (max-width: 766px){
    .block-main-content{
        background: none;
    }
    .block-content{
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .section{
        margin-top: 40px;
    }
    .element-style2{
        display: none;
    }
    .block-main-content{
        max-width: 400px;
        margin: auto;
        margin-top: 30px;
        padding: 0;
    }
    .counter{
        width: 40px;
        height: 40px;
        font-size: 15px;
    }
    .item{
        display: grid;
        grid-template-columns: 40px auto;
        gap: 20px;
    }
    #carouselExampleIndicators2{
        height: 390px;
    }
    .col-8{
        width: 100%;
    }
    .table-block.col-10{
        width: 100%;
    }
    td, th{
        font-size: 10px;
    }
}
</style>
