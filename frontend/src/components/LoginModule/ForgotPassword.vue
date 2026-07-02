<template>
  <div class="auth-wrapper">
    <div class="forgot-container">
      <div class="auth-header">
        <div class="logo-icon">🔑</div>
        <h2>KHÔI PHỤC MẬT KHẨU</h2>
        <p class="desc-text">Anh vui lòng nhập email đã đăng ký hệ thống. Một mật khẩu ngẫu nhiên mới sẽ được gửi thẳng về hòm thư của anh để đăng nhập.</p>
      </div>
      
      <form @submit.prevent="handleForgotPassword" class="auth-form">
        <div class="form-group">
          <label>Email khôi phục</label>
          <div class="input-wrapper">
            <span class="input-icon">✉️</span>
            <input 
              type="email" 
              v-model="email" 
              required 
              placeholder="Nhập email của bạn (abcxyz@gmail.com)..." 
              :disabled="loading"
            />
          </div>
        </div>
        
        <button type="submit" class="btn-submit" :disabled="loading">
          <span v-if="!loading">Gửi yêu cầu cấp lại</span>
          <span v-else class="spinner-container">
            <span class="spinner"></span> Hệ thống đang gửi mail...
          </span>
        </button>
      </form>

      <div class="auth-navigation">
        <a href="#" @click.prevent="goToLogin" class="nav-link">← Quay lại Đăng nhập</a>
      </div>
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
    const response = await axios.post('http://127.0.0.1:8000/api/forgot-password', {
      email: email.value
    })
    alert(response.data.message)
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
.auth-wrapper {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
  padding: 20px;
}

.forgot-container {
  width: 100%;
  max-width: 440px;
  padding: 40px;
  border-radius: 24px;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.7);
}

.auth-header {
  text-align: center;
  margin-bottom: 25px;
}

.logo-icon {
  font-size: 40px;
  margin-bottom: 12px;
}

h2 {
  color: #1a202c;
  font-size: 22px;
  font-weight: 800;
  letter-spacing: 0.5px;
  margin: 0 0 12px 0;
}

.desc-text {
  font-size: 13.5px;
  color: #718096;
  line-height: 1.6;
  margin: 0;
}

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-size: 13px;
  font-weight: 700;
  color: #4a5568;
  text-transform: uppercase;
}

.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon {
  position: absolute;
  left: 14px;
  font-size: 16px;
  color: #a0aec0;
}

.form-group input {
  width: 100%;
  padding: 14px 14px 14px 44px;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  font-size: 15px;
  background-color: #ffffff;
  transition: all 0.2s ease;
  color: #2d3748;
}

.form-group input:focus {
  border-color: #4bc0c0;
  box-shadow: 0 0 0 4px rgba(75, 192, 192, 0.15);
  outline: none;
}

.btn-submit {
  width: 100%;
  padding: 15px;
  background: linear-gradient(135deg, #4bc0c0 0%, #3ca8a8 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 8px 16px rgba(75, 192, 192, 0.2);
  transition: all 0.2s ease;
}

.btn-submit:hover:not(:disabled) {
  transform: translateY(-1px);
  box-shadow: 0 12px 20px rgba(75, 192, 192, 0.3);
}

.btn-submit:disabled {
  background: #cbd5e0;
  cursor: not-allowed;
  box-shadow: none;
}

.auth-navigation {
  margin-top: 25px;
  display: flex;
  justify-content: center;
}

.nav-link {
  color: #4bc0c0;
  text-decoration: none;
  font-weight: 700;
  font-size: 14px;
  transition: color 0.2s;
}

.nav-link:hover {
  color: #3ca8a8;
  text-decoration: underline;
}

.spinner-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}

.spinner {
  width: 18px;
  height: 18px;
  border: 2px solid rgba(255,255,255,0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>