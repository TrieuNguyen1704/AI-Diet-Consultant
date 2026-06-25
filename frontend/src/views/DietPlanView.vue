<template>
  <div class="diet-container">
    <h2>KẾ HOẠCH DINH DƯỠNG CÁ NHÂN</h2>
    
    <div v-if="loading" class="loading-msg">Đang phân tích chỉ số để lên thực đơn cho anh...</div>
    
    <div v-else-if="plan" class="plan-content">
      <!-- Khối 1: Thực đơn nội bộ -->
      <div class="plan-card primary">
        <h3>🥗 Thực đơn chính (Hệ thống đề xuất)</h3>
        <p>{{ plan.primary_plan }}</p>
        
        <button v-if="!plan.is_accepted" @click="acceptPlan" class="btn-accept">
          Duyệt thực đơn này
        </button>
        <div v-else class="badge-success">✅ Anh đã duyệt thực đơn chính</div>
      </div>

      <!-- Khối 2: Thực đơn External System (Chuẩn bị cho tính năng AI) -->
      <div class="plan-card alternative">
        <h3>🤖 Thực đơn thay thế (Gợi ý từ AI Gemini)</h3>
        <p>{{ plan.alternative_plan }}</p>
        <button class="btn-ai" @click="requestAiAlternative">
          Yêu cầu AI đổi món khác
        </button>
      </div>
    </div>
    
    <div v-else class="error-msg">
      Không tìm thấy thực đơn. Anh vui lòng nhập lại chỉ số cơ thể nhé!
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const plan = ref(null)
const loading = ref(true)

// Hàm gọi API lấy thực đơn
const fetchPlan = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.get('http://127.0.0.1:8000/api/diet-plan', {
      headers: { Authorization: `Bearer ${token}` } // Phải có token mới qua được cổng Sanctum
    })
    plan.value = response.data
  } catch (error) {
    console.error('Không tải được thực đơn:', error)
  } finally {
    loading.value = false
  }
}

// Hàm duyệt thực đơn chính
const acceptPlan = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.post('http://127.0.0.1:8000/api/diet-plan/accept', {}, {
      headers: { Authorization: `Bearer ${token}` }
    })
    alert(response.data.message)
    plan.value.is_accepted = true
  } catch (error) {
    alert('Lỗi duyệt thực đơn rồi anh ơi!')
  }
}

// Hàm chờ làm cho tính năng gọi AI (sẽ xử lý sau)
const requestAiAlternative = () => {
  alert('Tính năng kết nối API Gemini AI đang được xây dựng!')
}

// Lấy dữ liệu ngay khi mở trang
onMounted(() => {
  fetchPlan()
})
</script>

<style scoped>
.diet-container { max-width: 700px; margin: 20px auto; padding: 20px; }
h2 { text-align: center; color: #2d3748; margin-bottom: 20px; }
.plan-card { padding: 20px; margin-bottom: 20px; border-radius: 10px; border: 1px solid #e2e8f0; }
.primary { background-color: #f0fff4; border-color: #9ae6b4; }
.alternative { background-color: #ebf8ff; border-color: #90cdf4; }
h3 { margin-top: 0; color: #2c5282; font-size: 18px; }
p { font-size: 16px; line-height: 1.6; color: #4a5568; white-space: pre-line; }
.btn-accept { background-color: #48bb78; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold; }
.btn-accept:hover { background-color: #38a169; }
.btn-ai { background-color: #3182ce; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold; margin-top: 10px; }
.btn-ai:hover { background-color: #2b6cb0; }
.badge-success { color: #276749; font-weight: bold; margin-top: 10px; }
.loading-msg, .error-msg { text-align: center; font-size: 18px; color: #e53e3e; }
</style>