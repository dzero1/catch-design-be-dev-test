import axios from "axios";

const axiosService = axios.create({
    baseURL: `${import.meta.env.VITE_WEB_ENDPOINT}/api/`,
});

// Add a request interceptor
axiosService.interceptors.request.use(
    config => {
      const token = localStorage.getItem("token");
      if (token) {
        config.headers['Authorization'] = 'Bearer ' + token
      }
      // config.headers['Content-Type'] = 'application/json';
      return config
    },
    error => {
      Promise.reject(error)
    }
)

export default axiosService;