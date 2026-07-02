<template>
  <div class="forgot-container">
    <h2>KHÔI PHỤC MẬT KHẨU</h2>
    <p class="desc-text">Anh vui lòng nhập email đã đăng ký hệ thống. Một mật khẩu ngẫu nhiên mới sẽ được gửi thẳng về hòm thư của anh để đăng nhập.</p>
    
    <form @submit.prevent="handleForgotPassword">
      <div class="form-group">
        <label>Email khôi phục:</label>
        <input 
          type="email" 
          v-model="email" 
          required 
          placeholder="Nhập email của bạn (abcxyz@gmail.com)..." 
          :disabled="loading"
        />
      </div>
      
      <button type="submit" :disabled="loading">
        {{ loading ? 'Hệ thống đang gửi mail...' : 'Gửi yêu cầu cấp lại' }}
      </button>
    </form>

    <div class="auth-navigation">
      <a href="#" @click.prevent="goToLogin" class="nav-link">← Quay lại Đăng nhập</a>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const email = ref('')
const loading = ref(false)
const router = useRouter()

const handleForgotPassword = async () => {
  try {
    loading.value = true
    
    // Gọi API từ Laravel Backend
    const response = await axios.post('http://127.0.0.1:8000/api/forgot-password', {
      email: email.value
    })

    // Hiện thông báo thành công từ Backend gửi về
    alert(response.data.message)
    
    // Đưa anh quay lại trang Login để đăng nhập bằng mật khẩu mới vừa nhận trong mail
    router.push('/')
  } catch (error) {
    if (error.response && error.response.data) {
      alert(error.response.data.message)
    } else {
      alert('Không kết nối được với Server Backend. Anh kiểm tra lại xem nhé!')
    }
  } finally {
    loading.value = false
  }
}

const goToLogin = () => {
  router.push('/')
}
</script>

<style scoped>
.forgot-container {
  max-width: 400px;
  margin: 80px auto;
  padding: 30px;
  border: 1px solid #e0e0e0;
  border-radius: 12px;
  background: white;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

h2 {
  text-align: center;
  color: #2c3e50;
  margin-bottom: 15px;
  font-size: 22px;
}

.desc-text {
  font-size: 14px;
  color: #7f8c8d;
  line-height: 1.5;
  text-align: center;
  margin-bottom: 25px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: #4a5568;
}

.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #cbd5e0;
  border-radius: 6px;
  box-sizing: border-box;
  font-size: 14px;
}

.form-group input:focus {
  border-color: #4bc0c0;
  outline: none;
}

button {
  width: 100%;
  padding: 12px;
  background-color: #4bc0c0;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.2s;
  margin-bottom: 10px;
}

button:hover {
  background-color: #3498db;
}

button:disabled {
  background-color: #bdc3c7;
  cursor: not-allowed;
}

.auth-navigation {
  margin-top: 20px;
  display: flex;
  justify-content: center;
  font-size: 14px;
}

.nav-link {
  color: #4bc0c0;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.2s;
}

.nav-link:hover {
  color: #3498db;
  text-decoration: underline;
}
</style>