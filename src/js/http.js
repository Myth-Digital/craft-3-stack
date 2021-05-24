import axios from 'axios';

axios.interceptors.request.use(config => {
    config.headers['X-Requested-With'] = 'XMLHttpRequest';
    config.headers['X-CSRF-Token'] = window.csrfTokenValue;
    
    if (config.method === 'post') {
        config.data[window.csrfTokenName] = window.csrfTokenValue;
    }
    

    return config;
}, err => {
    return Promise.reject(err);
});

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';