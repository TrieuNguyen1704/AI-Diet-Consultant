<template>
  <div class="auth-wrapper">
    <div class="register-container">
      <div class="auth-header">
        <div class="logo-icon">📝</div>
        <h2>ĐĂNG KÝ TÀI KHOẢN</h2>
        <p class="subtitle">Khởi tạo hồ sơ để cùng AI thiết kế thực đơn sức khỏe</p>
      </div>

      <form @submit.prevent="handleRegister" class="auth-form">
        <div class="form-group">
          <label>Họ và tên của anh</label>
          <div class="input-wrapper">
            <span class="input-icon">👤</span>
            <input type="text" v-model="name" required placeholder="Ví dụ: Nguyên Đẹp Trai" />
          </div>
        </div>

        <div class="form-group">
          <label>Email đăng ký</label>
          <div class="input-wrapper">
            <span class="input-icon">✉️</span>
            <input type="email" v-model="email" required placeholder="abcxyz@gmail.com" />
          </div>
        </div>

        <div class="form-group">
          <label>Mật khẩu</label>
          <div class="input-wrapper">
            <span class="input-icon">🔒</span>
            <input type="password" v-model="password" required placeholder="Tối thiểu 6 ký tự" />
          </div>
        </div>

        <button type="submit" class="btn-submit">
          <span>Đăng ký ngay</span>
          <span class="btn-arrow">→</span>
        </button>
      </form>

      <div class="auth-navigation">
        <p class="login-text">
          Đã có tài khoản rồi?
          <a href="#" @click.prevent="goToLogin" class="nav-link login-link">Đăng nhập ngay</a>
        </p>
      </div>
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
    alert(response.data.message || 'Đăng ký thành công!')
    router.push('/')
  } catch (error) {
    if (error.response && error.response.data) {
      alert(error.response.data.message)
    } else {
      alert('Đăng ký không thành công. Vui lòng kiểm tra lại kết nối.')
    }
  }
}

const goToLogin = () => router.push('/')
</script>

<style scoped>
/* Thừa hưởng CSS đồng bộ của auth-wrapper */
.auth-wrapper {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
  padding: 20px;
}

.register-container {
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
  margin-bottom: 30px;
}

.logo-icon {
  font-size: 40px;
  margin-bottom: 12px;
}

h2 {
  color: #1a202c;
  font-size: 23px;
  font-weight: 800;
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
  gap: 20px;
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
  margin-top: 25px;
  text-align: center;
}

.login-text {
  margin: 0;
  color: #4a5568;
  font-size: 14px;
}

.nav-link {
  text-decoration: none;
  font-size: 14px;
}

.login-link {
  color: #4bc0c0;
  font-weight: 700;
}

.login-link:hover {
  color: #3ca8a8;
  text-decoration: underline;
}
</style>