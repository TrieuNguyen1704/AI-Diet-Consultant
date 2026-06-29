<template>
  <div class="donation-container">
    <h2>QUẢN LÝ KHO MÁU & ĐĂNG KÝ HIẾN MÁU</h2>
    
    <div class="blood-stock-section">
      <h3>🩸 Trạng thái kho máu thời gian thực (Cập nhật từ Bệnh viện)</h3>
      <div class="stock-grid">
        <div v-for="blood in bloodStock" :key="blood.type" class="stock-item">
          <span class="blood-type">Nhóm máu {{ blood.type }}:</span>
          <span class="blood-status">{{ blood.status }}</span>
        </div>
      </div>
    </div>

    <hr class="divider" />

    <div class="booking-section">
      <h3>📅 Đăng ký lịch hẹn hiến máu nhân đạo</h3>
      <form @submit.prevent="handleRegisterDonation">
        <div class="form-group">
          <label>Chọn nhóm máu của anh/chị:</label>
          <select v-model="selectedBloodType" required>
            <option value="O">Nhóm máu O</option>
            <option value="A">Nhóm máu A</option>
            <option value="B">Nhóm máu B</option>
            <option value="AB">Nhóm máu AB</option>
          </select>
        </div>

        <div class="form-group">
          <label>Chọn ngày hẹn đăng ký:</label>
          <input type="date" v-model="donationDate" :min="today" required />
        </div>

        <button type="submit" class="btn-submit">Xác nhận đặt lịch hẹn</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const bloodStock = ref([])
const selectedBloodType = ref('O')
const donationDate = ref('')
const today = new Date().toISOString().split('T')[0] // Chặn không cho chọn ngày quá khứ

// 1. Tự động lấy dữ liệu kho máu từ External System khi vừa mở trang lên
const fetchBloodStock = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.get('http://127.0.0.1:8000/api/blood-availability', {
      headers: { Authorization: `Bearer ${token}` }
    })
    bloodStock.value = response.data
  } catch (error) {
    console.error('Không lấy được dữ liệu kho máu rồi anh ơi!', error)
  }
}

// 2. Xử lý gửi form đăng ký lịch hẹn hiến máu lên Database
const handleRegisterDonation = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.post('http://127.0.0.1:8000/api/donate-blood', {
      blood_type: selectedBloodType.value,
      donation_date: donationDate.value
    }, {
      headers: { Authorization: `Bearer ${token}` }
    })

    alert(response.data.message) // Bật thông báo đặt lịch thành công
    donationDate.value = '' // Reset lại ô chọn ngày
  } catch (error) {
    alert('Đăng ký thất bại, anh vui lòng kiểm tra lại kết nối nhé!')
  }
}

// Chạy hàm lấy dữ liệu kho máu ngay khi component được nạp
onMounted(() => {
  fetchBloodStock()
})
</script>

<style scoped>
.donation-container { max-width: 600px; margin: 40px auto; padding: 30px; border: 1px solid #e2e8f0; border-radius: 12px; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
h2 { text-align: center; color: #e53e3e; margin-bottom: 25px; font-size: 20px; font-weight: bold; }
h3 { color: #2d3748; font-size: 16px; margin-bottom: 15px; font-weight: 600; }
.stock-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 10px; }
.stock-item { padding: 12px; background: #fff5f5; border: 1px solid #fed7d7; border-radius: 8px; display: flex; justify-content: space-between; }
.blood-type { font-weight: bold; color: #c53030; }
.divider { margin: 25px 0; border: 0; border-top: 1px dashed #cbd5e0; }
.form-group { margin-bottom: 18px; }
.form-group label { display: block; margin-bottom: 6px; font-weight: bold; color: #4a5568; }
.form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box; }
.btn-submit { width: 100%; padding: 12px; background-color: #e53e3e; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
.btn-submit:hover { background-color: #9b2c2c; }
</style>