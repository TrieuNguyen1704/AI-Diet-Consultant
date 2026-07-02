<template>
  <div class="metrics-container">
    <div class="metrics-card">
      <div class="card-header">
        <h2>📊 THÔNG SỐ CƠ THỂ</h2>
        <p>Cung cấp chỉ số chính xác để AI cá nhân hóa thực đơn tối ưu cho anh</p>
      </div>

      <form @submit.prevent="handleSubmit" class="metrics-form">
        <div class="form-grid">
          <div class="form-group">
            <label>Chiều cao (cm)</label>
            <div class="input-unit-wrapper">
              <input type="number" v-model="height" required min="100" max="250" placeholder="Ví dụ: 175" />
              <span class="unit-tag">cm</span>
            </div>
          </div>

          <div class="form-group">
            <label>Cân nặng (kg)</label>
            <div class="input-unit-wrapper">
              <input type="number" v-model="weight" required min="30" max="200" placeholder="Ví dụ: 70" />
              <span class="unit-tag">kg</span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Thời gian làm việc & Vận động</label>
          <div class="select-wrapper">
            <select v-model="working_hours" required>
              <option value="" disabled selected>Chọn mức độ vận động hàng ngày...</option>
              <option value="4">Nhẹ nhàng (Làm việc văn phòng, ít vận động)</option>
              <option value="8">Trung bình (Vận động vừa phải, có tập thể thao)</option>
              <option value="12">Nặng (Lao động chân tay, cường độ tập luyện cao)</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Tạng người (Body Type)</label>
          <div class="body-type-selector">
            <label class="type-box" :class="{ active: body_type === 'Ectomorph' }">
              <input type="radio" v-model="body_type" value="Ectomorph" required />
              <span class="type-icon">🏃‍♂️</span>
              <span class="type-name">Ectomorph</span>
              <span class="type-desc">Khó tăng cân, người gầy, chuyển hóa nhanh</span>
            </label>

            <label class="type-box" :class="{ active: body_type === 'Mesomorph' }">
              <input type="radio" v-model="body_type" value="Mesomorph" />
              <span class="type-icon">🏋️‍♂️</span>
              <span class="type-name">Mesomorph</span>
              <span class="type-desc">Dễ tăng cơ, cấu trúc xương cân đối</span>
            </label>

            <label class="type-box" :class="{ active: body_type === 'Endomorph' }">
              <input type="radio" v-model="body_type" value="Endomorph" />
              <span class="type-icon">🧍‍♂️</span>
              <span class="type-name">Endomorph</span>
              <span class="type-desc">Dễ tích mỡ, khung xương to, chuyển hóa chậm</span>
            </label>
          </div>
        </div>

        <button type="submit" class="btn-submit-metrics" :disabled="loading">
          <span v-if="!loading">🧠 Lưu Chỉ Số & Phân Tích Thực Đơn</span>
          <span v-else class="spinner-container">
            <span class="spinner"></span> AI Đang Tính Toán Thực Đơn...
          </span>
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const height = ref('')
const weight = ref('')
const working_hours = ref('')
const body_type = ref('')
const loading = ref(false)
const router = useRouter()

const handleSubmit = async () => {
  try {
    loading.value = true
    const token = localStorage.getItem('token')
    await axios.post('http://127.0.0.1:8000/api/metrics', {
      body_type: body_type.value,
      height: height.value,
      weight: weight.value,
      working_hours: working_hours.value
    }, {
      headers: { Authorization: `Bearer ${token}` }
    })
    router.push('/diet-plan')
  } catch (error) {
    alert('Có lỗi xảy ra khi lưu chỉ số.')
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.metrics-container {
  max-width: 680px;
  margin: 40px auto;
  padding: 0 20px;
}

.metrics-card {
  background: #ffffff;
  border-radius: 24px;
  padding: 40px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
  border: 1px solid #edf2f7;
}

.card-header {
  margin-bottom: 35px;
  text-align: center;
}

.card-header h2 {
  font-size: 22px;
  font-weight: 800;
  color: #1a202c;
  margin: 0 0 8px 0;
}

.card-header p {
  font-size: 14px;
  color: #718096;
  margin: 0;
}

.metrics-form {
  display: flex;
  flex-direction: column;
  gap: 28px;
}

.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.form-group label {
  font-size: 14px;
  font-weight: 700;
  color: #2d3748;
}

.input-unit-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.input-unit-wrapper input,
.select-wrapper select {
  width: 100%;
  padding: 14px;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  font-size: 15px;
  background-color: #f8fafc;
  transition: all 0.2s;
}

.input-unit-wrapper input:focus,
.select-wrapper select:focus {
  border-color: #4bc0c0;
  background-color: #ffffff;
  box-shadow: 0 0 0 4px rgba(75, 192, 192, 0.1);
  outline: none;
}

.unit-tag {
  position: absolute;
  right: 16px;
  font-size: 14px;
  color: #a0aec0;
  font-weight: 600;
}

.body-type-selector {
  display: grid;
  grid-template-columns: 1fr;
  gap: 12px;
}

.type-box {
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 16px;
  display: grid;
  grid-template-columns: auto 1fr;
  column-gap: 16px;
  align-items: center;
  cursor: pointer;
  background-color: #f8fafc;
  transition: all 0.2s ease;
}

.type-box input[type="radio"] {
  display: none;
}

.type-icon {
  grid-row: span 2;
  font-size: 28px;
  background: white;
  padding: 8px;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
}

.type-name {
  font-size: 15px;
  font-weight: 700;
  color: #2d3748;
}

.type-desc {
  font-size: 12px;
  color: #718096;
}

.type-box.active {
  border-color: #4bc0c0;
  background-color: rgba(75, 192, 192, 0.04);
  box-shadow: 0 4px 12px rgba(75, 192, 192, 0.08);
}

.type-box.active .type-name {
  color: #3ca8a8;
}

.btn-submit-metrics {
  width: 100%;
  padding: 16px;
  background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
  transition: all 0.2s ease;
}

.btn-submit-metrics:hover:not(:disabled) {
  background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
  transform: translateY(-1px);
}

.btn-submit-metrics:disabled {
  background: #a0aec0;
  cursor: not-allowed;
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
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>