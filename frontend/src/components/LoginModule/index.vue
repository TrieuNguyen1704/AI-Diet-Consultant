<template>
  <div class="login-container">
    <h2>ĐĂNG NHẬP HỆ THỐNG</h2>
    <form @submit.prevent="handleLogin">
      <div class="form-group">
        <label>Email đăng nhập:</label>
        <input type="email" v-model="email" required placeholder="Nhập email của anh (test@gmail.com)..." />
      </div>
      <div class="form-group">
        <label>Mật khẩu:</label>
        <input type="password" v-model="password" required placeholder="Nhập mật khẩu (123456)..." />
      </div>
      <button type="submit">Đăng nhập ngay</button>
    </form>

    <div class="auth-navigation">
      <a href="#" @click.prevent="goToForgotPassword" class="nav-link">Quên mật khẩu?</a>
      <p class="register-text">
        Chưa có tài khoản? 
        <a href="#" @click.prevent="goToRegister" class="nav-link register-link">Đăng ký ngay</a>
      </p>
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
    // Gọi API thực tế từ Backend Laravel thông qua cổng 8000
    const response = await axios.post('http://127.0.0.1:8000/api/login', {
      email: email.value,
      password: password.value
    })

    // Lưu Token bảo mật Sanctum vào localStorage để làm "vé thông hành" cho các trang sau
    localStorage.setItem('token', response.data.token)
    alert(response.data.message) // Hiện thông báo Đăng nhập thành công từ Backend

    // Chuyển mượt mà sang màn hình nhập chỉ số
    router.push('/metrics')
  } catch (error) {
    // Kiểm tra xem có phản hồi từ server không trước khi đọc .data
    if (error.response && error.response.data) {
      alert(error.response.data.message)
    } else {
      alert('Không kết nối được với Server Backend Laravel. Anh kiểm tra lại xem đã bật server chưa nhé!')
    }
  }
}

// ====== HÀM ĐIỀU HƯỚNG SANG TRANG ĐĂNG KÝ VÀ QUÊN MẬT KHẨU ======
const goToRegister = () => {
  router.push('/register')
}

const goToForgotPassword = () => {
  router.push('/forgot-password')
}
// ===============================================================
</script>

<style scoped>
.login-container {
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
  margin-bottom: 25px;
  font-size: 22px;
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
  margin-bottom: 10px; /* Thêm chút khoảng cách dưới nút bấm */
}

button:hover {
  background-color: #3498db;
}

/* ====== CSS MỚI CHO PHẦN LIÊN KẾT ĐIỀU HƯỚNG MỚI THÊM VÀO ====== */
.auth-navigation {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  font-size: 14px;
}

.nav-link {
  color: #7f8c8d;
  text-decoration: none;
  transition: color 0.2s;
}

.nav-link:hover {
  color: #4bc0c0;
  text-decoration: underline;
}

.register-text {
  color: #4a5568;
  margin: 0;
}

.register-link {
  color: #4bc0c0;
  font-weight: bold;
}
/* ============================================================== */
</style>