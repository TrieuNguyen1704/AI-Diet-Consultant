<template>
  <div class="diet-plan-container">
    <div class="page-title">
      <h2>📋 KẾ HOẠCH DINH DƯỠNG CỦA ANH</h2>
      <p>Hệ thống tự động cân đối thực đơn truyền thống kết hợp biến tấu linh hoạt từ trí tuệ nhân tạo Gemini</p>
    </div>

    <div v-if="loading" class="loading-state">
      <div class="pulse-loader"></div>
      <p>Đang đồng bộ dữ liệu thực đơn từ hệ thống chuyên gia...</p>
    </div>

    <div v-else-if="plan" class="plan-grid">
      <div class="plan-card primary-card">
        <div class="card-badge">HỆ THỐNG</div>
        <div class="card-icon">🥗</div>
        <h3>Thực đơn chính đề xuất</h3>
        <div class="plan-text-box">
          <p>{{ plan.primary_plan }}</p>
        </div>

        <div class="card-footer-action">
          <button v-if="!plan.is_accepted" @click="acceptPlan" class="btn-action btn-accept">
            Duyệt áp dụng thực đơn này
          </button>
          <div v-else class="badge-success">✓ Anh đã duyệt thực đơn này</div>
        </div>
      </div>

      <div class="plan-card ai-card">
        <div class="card-badge ai-badge">GEMINI AI</div>
        <div class="card-icon">🤖</div>
        <h3>Thực đơn thay thế linh hoạt</h3>
        <div class="plan-text-box ai-box">
          <p>{{ plan.alternative_plan }}</p>
        </div>

        <div class="card-footer-action">
          <button class="btn-action btn-ai-refresh" @click="requestAiAlternative" :disabled="aiLoading">
            <span v-if="!aiLoading">🔄 Yêu cầu AI đổi món khác</span>
            <span v-else class="ai-loading-text">🧬 AI đang đổi món mới...</span>
          </button>
        </div>
      </div>
    </div>

    <div v-else class="error-state">
      <p>Không tìm thấy thực đơn cũ. Anh vui lòng quay lại trang nhập chỉ số nhé!</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const plan = ref(null)
const loading = ref(true)
const aiLoading = ref(false)

const fetchPlan = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.get('http://127.0.0.1:8000/api/diet-plan', {
      headers: { Authorization: `Bearer ${token}` }
    })
    plan.value = response.data
  } catch (error) {
    console.error(error)
  } finally {
    loading.value = false
  }
}

const acceptPlan = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.post('http://127.0.0.1:8000/api/diet-plan/accept', {}, {
      headers: { Authorization: `Bearer ${token}` }
    })
    alert(response.data.message)
    plan.value.is_accepted = true
  } catch (error) {
    alert('Lỗi khi duyệt thực đơn.')
  }
}

const requestAiAlternative = async () => {
  try {
    aiLoading.value = true
    const token = localStorage.getItem('token')
    const response = await axios.get('http://127.0.0.1:8000/api/diet-plan/alternative', {
      headers: { Authorization: `Bearer ${token}` }
    })
    plan.value.alternative_plan = response.data.alternative_plan
    alert('Gemini AI đã đổi món mới thành công!')
  } catch (error) {
    alert('Không kết nối được với AI lúc này.')
  } finally {
    aiLoading.value = false
  }
}

onMounted(() => fetchPlan())
</script>

<style scoped>
.diet-plan-container {
  max-width: 1040px;
  margin: 40px auto;
  padding: 0 20px;
}

.page-title {
  text-align: center;
  margin-bottom: 40px;
}

.page-title h2 {
  font-size: 24px;
  font-weight: 800;
  color: #1a202c;
  margin: 0 0 10px 0;
}

.page-title p {
  font-size: 14px;
  color: #718096;
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.6;
}

.plan-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 30px;
}

.plan-card {
  background: #ffffff;
  border-radius: 24px;
  padding: 35px;
  border: 1px solid #edf2f7;
  position: relative;
  display: flex;
  flex-direction: column;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.01);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.plan-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.03);
}

.card-badge {
  position: absolute;
  top: 20px;
  right: 20px;
  font-size: 11px;
  font-weight: 800;
  padding: 6px 12px;
  border-radius: 30px;
  background-color: #edf2f7;
  color: #4a5568;
}

.ai-badge {
  background-color: rgba(75, 192, 192, 0.12);
  color: #3ca8a8;
}

.card-icon {
  font-size: 32px;
  margin-bottom: 16px;
}

.plan-card h3 {
  font-size: 18px;
  font-weight: 700;
  color: #2d3748;
  margin: 0 0 20px 0;
}

.plan-text-box {
  background-color: #f8fafc;
  border-radius: 16px;
  padding: 20px;
  flex-grow: 1;
  margin-bottom: 25px;
  border: 1px solid #f1f5f9;
}

.ai-box {
  background-color: rgba(75, 192, 192, 0.02);
  border-color: rgba(75, 192, 192, 0.06);
}

.plan-text-box p {
  font-size: 15px;
  line-height: 1.8;
  color: #4a5568;
  white-space: pre-line;
  margin: 0;
}

.btn-action {
  width: 100%;
  padding: 14px;
  border: none;
  border-radius: 12px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-accept {
  background-color: #e6fffa;
  color: #234e52;
  border: 1px solid #b2f5ea;
}

.btn-accept:hover {
  background-color: #319795;
  color: white;
}

.btn-ai-refresh {
  background: linear-gradient(135deg, #4bc0c0 0%, #3ca8a8 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(75, 192, 192, 0.2);
}

.btn-ai-refresh:hover:not(:disabled) {
  box-shadow: 0 8px 20px rgba(75, 192, 192, 0.3);
}

.btn-ai-refresh:disabled {
  background: #cbd5e0;
  box-shadow: none;
  cursor: not-allowed;
}

.badge-success {
  text-align: center;
  background-color: #c6f6d5;
  color: #22543d;
  padding: 12px;
  border-radius: 12px;
  font-weight: 700;
  font-size: 15px;
}

.loading-state,
.error-state {
  text-align: center;
  padding: 60px 0;
  color: #718096;
}

.pulse-loader {
  width: 40px;
  height: 40px;
  background-color: #4bc0c0;
  border-radius: 50%;
  margin: 0 auto 20px auto;
  animation: pulse 1.2s infinite ease-in-out;
}

@keyframes pulse {
  0% {
    transform: scale(0);
    opacity: 1;
  }

  100% {
    transform: scale(1.3);
    opacity: 0;
  }
}
</style>