<template>
    <div class="container">
        <div class="maps-info">
            <div class="info">
                <div class="btn-title">
                    <h2>Обратная связь</h2>
                </div>
                <form @submit.prevent="onSendMessage" v-if="!sendMessage">
                    <div class="name-email mb-3">
                        <div class="input">
                            <label for="" class="form-label">Имя</label>
                            <input v-model="message.name" type="text" class="form-control">
                        </div>
                        <div class="input">
                            <label for="" class="form-label">Адрес эл. почты</label>
                            <input v-model="message.email" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Комментарий</label>
                        <textarea v-model="message.comment" class="form-control"></textarea>
                    </div>
                    <my-button type="submit" class="mt-2">Отправить</my-button>
                </form>
                <div class="send-message" v-if="sendMessage">
                    <h3>Ваше сообщение было отправлено</h3>
                    <p><span class="bolder-text">Имя:</span> {{sendMessage.name}}</p>
                    <p><span class="bolder-text">Email:</span> {{sendMessage.email}}</p>
                    <p><span class="bolder-text">Сообщение:</span> {{sendMessage.comment}}</p>
                </div>
            </div>
            <div class="maps">
                <div class="corpuses">
                    <my-button @click="selectCorpus=1">Здание №1</my-button>
                    <my-button @click="selectCorpus=2" style="margin-left: 20px">Здание №2</my-button>
                </div>
                <div class="block-for-map" v-if="selectCorpus===1" style="position:relative;overflow:hidden;">
                    <a href="https://yandex.ru/maps/20037/bor/?utm_medium=mapframe&utm_source=maps"
                       style="color:#eee;font-size:12px;position:absolute;top:0px;">Бор</a><a
                    href="https://yandex.ru/maps/20037/bor/house/ulitsa_8_marta_13/YE0YdgJnTkIDQFtsfX90eHlqbQ==/?indoorLevel=1&ll=44.058141%2C56.359703&utm_medium=mapframe&utm_source=maps&z=18.33"
                    style="color:#eee;font-size:12px;position:absolute;top:14px;">Яндекс Карты — транспорт, навигация,
                    поиск мест</a>
                    <iframe
                        src="https://yandex.ru/map-widget/v1/?indoorLevel=1&ll=44.058141%2C56.359703&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgg1Njk4ODY5NBJc0KDQvtGB0YHQuNGPLCDQndC40LbQtdCz0L7RgNC-0LTRgdC60LDRjyDQvtCx0LvQsNGB0YLRjCwg0JHQvtGALCDRg9C70LjRhtCwIDgg0JzQsNGA0YLQsCwgMTMiCg0qOzBCFTtwYUI%2C&z=18.33"
                        class="map" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>
                </div>
                <div class="block-for-map" v-if="selectCorpus===2" style="position:relative;overflow:hidden;">
                    <a href="https://yandex.ru/maps/20037/bor/?utm_medium=mapframe&utm_source=maps"
                       style="color:#eee;font-size:12px;position:absolute;top:0px;">Бор</a><a
                    href="https://yandex.ru/maps/20037/bor/house/ulitsa_vaneyeva_43a/YE0YdgNiSkwCQFtsfX93cnxlYQ==/?ll=44.042395%2C56.363065&utm_medium=mapframe&utm_source=maps&z=17.13"
                    style="color:#eee;font-size:12px;position:absolute;top:14px;">Улица Ванеева, 43А — Яндекс Карты</a>
                    <iframe
                        src="https://yandex.ru/map-widget/v1/?ll=44.042395%2C56.363065&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgg1Njk5MDAxNBJg0KDQvtGB0YHQuNGPLCDQndC40LbQtdCz0L7RgNC-0LTRgdC60LDRjyDQvtCx0LvQsNGB0YLRjCwg0JHQvtGALCDRg9C70LjRhtCwINCS0LDQvdC10LXQstCwLCA0M9CQIgoNaSswQhXHc2FC&z=17.13"
                        class="map" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>
                </div>
                <p class="mt-3">{{ corpuses[selectCorpus - 1] }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import MyButton from "@/components/ui/MyButton.vue";
import api from "@/api.js";

export default {
    name: "MessagePage",
    components: {MyButton},
    data() {
        return {
            message: {
                name: '',
                email: '',
                comment: ''
            },
            selectCorpus: 1,
            corpuses: [
                'Нижегородская область, г. Бор, ул. 8 марта, д. 13',
                'Нижегородская область, г. Бор, ул. Ванеева, д. 43а'
            ],
            sendMessage: ''
        }
    },
    created() {
        document.title = 'Обратная связь'
    },
    methods:{
        onSendMessage(){
            api.post('/api/send/message',this.message)
                .then(res=>{
                    this.sendMessage = {...this.message};
                    this.message = {
                        name: '',
                        email: '',
                        comment: ''
                    }
                })
        }
    }
}
</script>

<style scoped>
h2 {
    margin-bottom: 50px;
}
h3{
    font-size: 20px;
}
.name-email {
    display: flex;
    width: 100%;
    gap: 20px;
}

input {
    width: 100%;
}

.input {
    width: 100%;
}

.form-control {
    border-radius: 0;
}

form {
    max-width: 500px;
}

.btn-title {
    display: flex;
    justify-content: space-between;
}

.maps-info {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-top: 50px;
}
.maps{
    max-width: 600px;
    box-sizing: border-box;
}
.block-for-map {
    width: 100%;
    height: 300px;
    margin-top: 20px;
}

button {
    width: 290px;
}

.map {
    width: 100%;
    height: 100%;
}
</style>
