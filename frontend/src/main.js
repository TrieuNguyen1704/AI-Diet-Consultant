import { createApp } from 'vue'
import App from './App.vue'
import router from './router' // Nạp file router anh vừa tạo bằng tay vào đây

const app = createApp(App)

app.use(router) // Ép ứng dụng Vue sử dụng Router để chuyển trang

app.mount('#app')