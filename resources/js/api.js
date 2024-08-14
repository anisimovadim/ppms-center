import axios from "axios";
import router from "./router";

const api = axios.create();

api.interceptors.request.use(config => {
    const token = localStorage.getItem('access_token');
    // console.log('Token:', token);
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    // console.error('Request error:', error);
    return Promise.reject(error);
});

api.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.response.status === 401) {
        return axios.post('/api/auth/refresh', {}, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('access_token')}`
            }
        }).then(res => {
            localStorage.setItem('access_token', res.data.access_token);
            error.config.headers.Authorization = `Bearer ${res.data.access_token}`;
            return api.request(error.config);
        }).catch(err => {
            console.log(err);
            if (err.response && err.response.data.error === 'Token is missing') {
                router.push('/registration')
            }
            return Promise.reject(err);
        });
    }
    return Promise.reject(error);
});


export default api;
