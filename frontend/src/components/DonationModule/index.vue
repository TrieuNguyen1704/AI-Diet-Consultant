<template>
  <div class="donation-container">
    <div class="donation-header">
      <div class="heart-pulse">❤️</div>
      <h2>HIẾN MÁU NHÂN ĐẠO & ỦNG HỘ</h2>
      <p class="sub-title">"Một giọt máu cho đi - Một cuộc đời ở lại". Tra cứu thông tin điều kiện sức khỏe và đăng ký hiến máu cứu người.</p>
    </div>

    <!-- Khối 1: Grid Điều kiện sức khỏe khi hiến máu -->
    <div class="info-grid">
      <div class="info-card">
        <span class="card-num">01</span>
        <h4>Cân nặng & Độ tuổi</h4>
        <p>Nam/Nữ từ đủ 18 đến 60 tuổi. Cân nặng tối thiểu đạt từ 45kg trở lên đối với các trường hợp hiến máu toàn phần.</p>
      </div>

      <div class="info-card">
        <span class="card-num">02</span>
        <h4>Chỉ số Sức khỏe</h4>
        <p>Huyết áp bình ổn, không mắc các bệnh mãn tính hoặc các bệnh lây nhiễm qua đường truyền máu.</p>
      </div>

      <div class="info-card">
        <span class="card-num">03</span>
        <h4>Khoảng cách hiến</h4>
        <p>Khoảng cách giữa 2 lần hiến máu toàn phần liên tiếp tối thiểu là 12 tuần (khoảng 3 tháng một lần).</p>
      </div>
    </div>

    <!-- Khối 2: Form Đăng ký nhanh -->
    <div class="form-card">
      <h3>📋 ĐĂNG KÝ THÔNG TIN HIẾN MÁU</h3>
      <p class="form-desc">Hệ thống sẽ đồng bộ thông tin thể trạng của anh và gửi đến trung tâm huyết học gần nhất.</p>

      <form @submit.prevent="handleDonation" class="donate-form">
        <div class="form-row">
          <div class="form-group">
            <label>Nhóm máu (Nếu biết)</label>
            <select v-model="bloodType">
              <option value="">Chưa rõ nhóm máu</option>
              <option value="A">Nhóm máu A</option>
              <option value="B">Nhóm máu B</option>
              <option value="O">Nhóm máu O</option>
              <option value="AB">Nhóm máu AB</option>
            </select>
          </div>

          <div class="form-group">
            <label>Thời gian dự kiến có thể hiến</label>
            <input type="date" v-model="donationDate" required />
          </div>
        </div>

        <button type="submit" class="btn-donate">
          ❤️ Gửi thông tin đăng ký nhân đạo
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const bloodType = ref('')
const donationDate = ref('')

const handleDonation = () => {
  alert(`Cảm ơn nghĩa cử cao đẹp của anh! Hệ thống đã ghi nhận lịch đăng ký hiến máu vào ngày: ${donationDate.value}`)
}
</script>

<style scoped>
.donation-container {
  max-width: 900px;
  margin: 40px auto;
  padding: 0 20px;
}

.donation-header {
  text-align: center;
  margin-bottom: 45px;
}

.heart-pulse {
  font-size: 45px;
  margin-bottom: 10px;
  animation: heartBeat 1.2s infinite ease-in-out;
}

@keyframes heartBeat {
  0% { transform: scale(1); }
  30% { transform: scale(1.15); }
  60% { transform: scale(1); }
}

.donation-header h2 {
  font-size: 24px;
  font-weight: 800;
  color: #c53030; /* Màu đỏ Ruby dịu */
  margin: 0 0 10px 0;
}

.sub-title {
  color: #718096;
  font-size: 14.5px;
  max-width: 650px;
  margin: 0 auto;
  line-height: 1.6;
}

/* Info Grid Layout */
.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.info-card {
  background: #ffffff;
  border-radius: 16px;
  padding: 25px;
  border: 1px solid #edf2f7;
  position: relative;
  box-shadow: 0 4px 12px rgba(0,0,0,0.01);
}

.card-num {
  font-size: 28px;
  font-weight: 800;
  color: rgba(197, 48, 48, 0.15);
  position: absolute;
  top: 15px;
  right: 20px;
}

.info-card h4 {
  font-size: 16px;
  font-weight: 700;
  color: #2d3748;
  margin: 0 0 10px 0;
}

.info-card p {
  font-size: 13.5px;
  color: #718096;
  line-height: 1.6;
  margin: 0;
}

/* Form Card */
.form-card {
  background: #ffffff;
  border-radius: 24px;
  padding: 35px;
  border: 1px solid #edf2f7;
  box-shadow: 0 10px 30px rgba(0,0,0,0.02);
}

.form-card h3 {
  font-size: 18px;
  font-weight: 800;
  color: #2d3748;
  margin: 0 0 6px 0;
}

.form-desc {
  font-size: 13.5px;
  color: #718096;
  margin: 0 0 25px 0;
}

.donate-form {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

@media (max-width: 600px) {
  .form-row { grid-template-columns: 1fr; }
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
}

.form-group select, .form-group input {
  width: 100%;
  padding: 12px;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  background-color: #f8fafc;
  font-size: 14.5px;
  color: #2d3748;
}

.form-group select:focus, .form-group input:focus {
  border-color: #c53030;
  background-color: #ffffff;
  outline: none;
  box-shadow: 0 0 0 4px rgba(197, 48, 48, 0.1);
}

.btn-donate {
  padding: 15px;
  background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 6px 15px rgba(197, 48, 48, 0.25);
  transition: all 0.2s ease;
}

.btn-donate:hover {
  transform: translateY(-1px);
  box-shadow: 0 10px 20px rgba(197, 48, 48, 0.35);
}
</style>