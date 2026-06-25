<template>
  <div class="login-container">
    <h2>ĐĂNG NHẬP HỆ THỐNG</h2>
    <form @submit.prevent="handleLogin">
      <div class="form-group">
        <label>Email:</label>
        <input type="email" v-model="email" required placeholder="Nhập email của anh..." />
      </div>
      <div class="form-group">
        <label>Mật khẩu:</label>
        <input type="password" v-model="password" required placeholder="Nhập mật khẩu..." />
      </div>
      <button type="submit">Đăng nhập</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const router = useRouter()

const handleLogin = async () => {
  try {
    // Gửi HTTP Request tới Backend Laravel (Đúng luồng C&C View)
    const response = await axios.post('http://127.0.0.1:8000/api/login', {
      email: email.value,
      password: password.value
    })
    
    // Lưu Token xác thực vào bộ nhớ trình duyệt
    localStorage.setItem('token', response.data.token)
    alert('Đăng nhập thành công anh nhé!')
    
    // Chuyển sang màn hình nhập chỉ số cơ thể
    router.push('/metrics')
  } catch (error) {
    alert('Đăng nhập thất bại, anh kiểm tra lại tài khoản nhé!')
  }
}
</script>

<style scoped>
.login-container { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
button { width: 100%; padding: 10px; background-color: #4bc0c0; color: white; border: none; border-radius: 4px; cursor: pointer; }
</style>