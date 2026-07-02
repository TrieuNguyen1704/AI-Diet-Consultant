<template>
  <div class="auth-wrapper">
    <div class="login-container">
      <div class="auth-header">
        <div class="logo-icon">🥗</div>
        <h2>AI DIET CONSULTANT</h2>
        <p class="subtitle">Hệ thống quản lý và khuyến nghị dinh dưỡng thông minh</p>
      </div>

      <form @submit.prevent="handleLogin" class="auth-form">
        <div class="form-group">
          <label>Email đăng nhập</label>
          <div class="input-wrapper">
            <span class="input-icon">✉️</span>
            <input type="email" v-model="email" required placeholder="nhap_email_cua_anh@gmail.com" />
          </div>
        </div>

        <div class="form-group">
          <label>Mật khẩu</label>
          <div class="input-wrapper">
            <span class="input-icon">🔒</span>
            <input type="password" v-model="password" required placeholder="••••••••" />
          </div>
        </div>

        <button type="submit" class="btn-submit">
          <span>Đăng nhập ngay</span>
          <span class="btn-arrow">→</span>
        </button>
      </form>

      <div class="auth-navigation">
        <a href="#" @click.prevent="goToForgotPassword" class="nav-link forgot-pwd">Quên mật khẩu?</a>
        <div class="divider"></div>
        <p class="register-text">
          Chưa có tài khoản?
          <a href="#" @click.prevent="goToRegister" class="nav-link register-link">Đăng ký ngay</a>
        </p>
      </div>
    </div>
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
    const response = await axios.post('http://127.0.0.1:8000/api/login', {
      email: email.value,
      password: password.value
    })
    localStorage.setItem('token', response.data.token)
    alert(response.data.message)
    router.push('/metrics')
  } catch (error) {
    if (error.response && error.response.data) {
      alert(error.response.data.message)
    } else {
      alert('Không kết nối được với Server Backend Laravel.')
    }
  }
}

const goToRegister = () => router.push('/register')
const goToForgotPassword = () => router.push('/forgot-password')
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

.login-container {
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
  margin-bottom: 35px;
}

.logo-icon {
  font-size: 40px;
  margin-bottom: 12px;
}

h2 {
  color: #1a202c;
  font-size: 24px;
  font-weight: 800;
  letter-spacing: 0.5px;
  margin: 0 0 8px 0;
}

.subtitle {
  color: #718096;
  font-size: 13px;
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
  letter-spacing: 0.5px;
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
  background-color: #fff;
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
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  box-shadow: 0 8px 16px rgba(75, 192, 192, 0.2);
  transition: all 0.2s ease;
}

.btn-submit:hover {
  transform: translateY(-1px);
  box-shadow: 0 12px 20px rgba(75, 192, 192, 0.3);
}

.btn-arrow {
  transition: transform 0.2s ease;
}

.btn-submit:hover .btn-arrow {
  transform: translateX(4px);
}

.auth-navigation {
  margin-top: 30px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
}

.divider {
  width: 100%;
  height: 1px;
  background-color: #edf2f7;
}

.nav-link {
  font-size: 14px;
  text-decoration: none;
  color: #718096;
  transition: color 0.2s;
}

.forgot-pwd:hover {
  color: #e53e3e;
}

.register-text {
  margin: 0;
  color: #4a5568;
  font-size: 14px;
}

.register-link {
  color: #4bc0c0;
  font-weight: 700;
}

.register-link:hover {
  color: #3ca8a8;
  text-decoration: underline;
}
</style>