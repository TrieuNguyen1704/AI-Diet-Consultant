<template>
  <div class="donation-container">
    <h2>QUẢN LÝ HIẾN MÁU & TÌNH TRẠNG MÁU</h2>
    
    <div class="blood-status">
      <h3>Kho máu hiện tại:</h3>
      <ul>
        <li>Nhóm O: 🌟 Sẵn sàng</li>
        <li>Nhóm A: ⚠️ Đang khan hiếm</li>
        <li>Nhóm B: 🌟 Sẵn sàng</li>
        <li>Nhóm AB: ⚠️ Đang khan hiếm</li>
      </ul>
    </div>

    <hr />

    <h3>Đăng ký hiến máu cứu người</h3>
    <form @submit.prevent="handleDonate">
      <div class="form-group">
        <label>Nhóm máu của anh:</label>
        <select v-model="bloodType">
          <option value="O">Nhóm O</option>
          <option value="A">Nhóm A</option>
          <option value="B">Nhóm B</option>
          <option value="AB">Nhóm AB</option>
        </select>
      </div>
      <div class="form-group">
        <label>Ngày hẹn hiến máu:</label>
        <input type="date" v-model="donationDate" required />
      </div>
      <button type="submit" class="btn-submit">Gửi lịch đăng ký</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const bloodType = ref('O')
const donationDate = ref('')

const handleDonate = () => {
  alert(`Đăng ký hiến máu nhóm ${bloodType.value} vào ngày ${donationDate.value} thành công!`)
}
</script>

<style scoped>
.donation-container { max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
.blood-status ul { list-style: none; padding: 0; display: flex; justify-content: space-between; }
.blood-status li { padding: 5px 10px; background: #f1f2f6; border-radius: 4px; font-size: 14px; }
.form-group { margin: 15px 0; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.form-group select, .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
.btn-submit { width: 100%; padding: 10px; background-color: #ff4757; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
</style>