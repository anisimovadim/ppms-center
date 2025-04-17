import axios from "axios";
import router from "./router";

const api = axios.create();

// === Интерсептор запроса ===
api.interceptors.request.use(config => {
    const token = localStorage.getItem('access_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

// === Интерсептор ответа ===
api.interceptors.response.use(response => {
    return response;
}, async error => {
    const originalRequest = error.config;

    // Если refresh тоже вернул 401 — не повторяем его
    if (originalRequest.url.includes('/auth/refresh')) {
        router.push('/registration');
        return Promise.reject(error);
    }

    if (error.response && error.response.status === 401 && !originalRequest._retry) {
        originalRequest._retry = true; // Помечаем, что уже пробовали refresh

        try {
            const res = await api.post('/api/auth/refresh');
            const newToken = res.data.access_token;

            localStorage.setItem('access_token', newToken);

            // Обновляем заголовок и повторяем оригинальный запрос
            originalRequest.headers.Authorization = `Bearer ${newToken}`;
            return api.request(originalRequest);
        } catch (refreshError) {
            console.error('Ошибка refresh:', refreshError);
            router.push('/registration');
            return Promise.reject(refreshError);
        }
    }

    return Promise.reject(error);
});

export default api;
