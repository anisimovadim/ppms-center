<template>
<div class="container">
    <form @submit.prevent="login">
        <h2>Авторизация</h2>
        <div class="data mb-3" v-for="(input,index) in inputs">
            <label :for="input.name" class="form-label">{{input.label}}</label>
            <my-input :id="input.name" v-model:value="inputs[index].value" :class="validateErrors[input.name] && 'is-invalid'"></my-input>
            <div v-if="validateErrors[input.name]" class="text-danger" v-for="err in validateErrors[input.name]">{{err}}</div>
        </div>
        <my-button type="submit">Войти</my-button>
    </form>
</div>
</template>

<script>
import MyInput from "@/components/ui/MyInput.vue";
import MyButton from "@/components/ui/MyButton.vue";
import axios from "axios";
export default {
    name: "RegistratePage",
    components: {MyButton, MyInput},
    data(){
        return{
            inputs:[
                {label:'Электронная почта', name:'email', value:''},
                {label:'Пароль', name:'password', value:''},
            ],
            validateErrors:[]
        }
    },
    created() {
        document.title='Авторизация'
    },
    methods:{
        login(){
            const user = this.inputs.reduce((acc, el)=>{
                acc[el.name] = el.value;
                return acc
            }, {});

            axios.post('/api/auth/login', user)
                .then(res=>{
                    this.$store.commit('setAccessToken', res.data.access_token);
                    this.$router.push('/admin/page');
                })
                .catch(err=>{
                    this.validateErrors = err.response.data.errors
                    setTimeout(()=>{
                        this.validateErrors=[]
                    }, 5000)
                    console.log(this.validateErrors)
                })
            console.log(user)
        },
    }
}
</script>

<style scoped>
h2{
    text-align: center;
    margin-bottom: 30px;
}
form{
    max-width: 500px;
    box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.15);
    background: #fff;
    padding: 30px;
    margin: 50px auto;
}
.alternative-register{
    box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.15);
    background: #fff;
    max-width: 300px;
}
button{
    width: 100%;
    margin-top: 15px;
}
</style>
