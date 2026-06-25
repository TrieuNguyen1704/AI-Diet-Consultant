<template>
  <div class="auth-container">
    <h2>TẠO TÀI KHOẢN MỚI</h2>
    <form @submit.prevent="handleRegister">
      <div class="form-group">
        <label>Họ và tên của anh:</label>
        <input type="text" v-model="name" required placeholder="Nhập họ và tên..." />
      </div>
      <div class="form-group">
        <label>Email đăng ký:</label>
        <input type="email" v-model="email" required placeholder="Nhập email..." />
      </div>
      <div class="form-group">
        <label>Mật khẩu:</label>
        <input type="password" v-model="password" required placeholder="Tạo mật khẩu..." />
      </div>
      <button type="submit" class="btn-primary">Đăng ký ngay</button>
    </form>
    
    <div class="auth-links">
      <router-link to="/" class="link">Đã có tài khoản? Quay lại đăng nhập</router-link>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const name = ref('')
const email = ref('')
const password = ref('')
const router = useRouter()

const handleRegister = async () => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/register', {
      name: name.value,
      email: email.value,
      password: password.value
    })
    alert(response.data.message)
    router.push('/') // Đăng ký thành công thì chuyển về trang đăng nhập
  } catch (error) {
    alert(error.response?.data?.message || 'Đăng ký thất bại, email có thể đã tồn tại!')
  }
}
</script>

<style scoped>
.auth-container { max-width: 400px; margin: 80px auto; padding: 30px; border: 1px solid #e2e8f0; border-radius: 12px; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
h2 { text-align: center; color: #2d3748; margin-bottom: 25px; font-size: 22px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #4a5568; }
.form-group input { width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box; }
.btn-primary { width: 100%; padding: 12px; background-color: #48bb78; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 16px; }
.btn-primary:hover { background-color: #38a169; }
.auth-links { margin-top: 20px; text-align: center; font-size: 14px; }
.link { color: #3182ce; text-decoration: none; }
.link:hover { text-decoration: underline; }
</style>