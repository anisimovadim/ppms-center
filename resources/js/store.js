import {createStore} from "vuex";

export const store = createStore({
    state(){
        return{
            access_token: localStorage.getItem('access_token')
        }
    },
    getters:{
        getAccessToken(state){
            return state.access_token
        }
    },
    mutations:{
        setAccessToken(state, token){
            state.access_token = token;
            console.log(state);
            localStorage.setItem('access_token', token);
        },
        removeAccessToken(state){
            state.access_token = '';
            localStorage.removeItem('access_token');
        }
    }
})
