<template>
  <div class="diet-container">
    <h2>KẾ HOẠCH DINH DƯỠNG CÁ NHÂN</h2>
    
    <div v-if="loading" class="loading-msg">Đang phân tích chỉ số để lên thực đơn cho anh...</div>
    
    <div v-else-if="plan" class="plan-content">
      <div class="plan-card primary">
        <h3>🥗 Thực đơn chính (Hệ thống đề xuất)</h3>
        <p>{{ plan.primary_plan }}</p>
        
        <button v-if="!plan.is_accepted" @click="acceptPlan" class="btn-accept">
          Duyệt thực đơn này
        </button>
        <div v-else class="badge-success">✅ Anh đã duyệt thực đơn chính</div>
      </div>

      <div class="plan-card alternative">
        <h3>🤖 Thực đơn thay thế (Gợi ý từ AI Gemini)</h3>
        <p>{{ plan.alternative_plan }}</p>
        <button class="btn-ai" @click="requestAiAlternative" :disabled="aiLoading">
          {{ aiLoading ? 'AI đang suy nghĩ món mới...' : 'Yêu cầu AI đổi món khác' }}
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
const aiLoading = ref(false) // Trạng thái đợi AI đổi món

// Hàm gọi API lấy thực đơn mới nhất từ DB
const fetchPlan = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.get('http://127.0.0.1:8000/api/diet-plan', {
      headers: { Authorization: `Bearer ${token}` }
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

// HÀM XỊN: Gọi Backend kích hoạt AI Gemini tính toán đổi món khác cho anh
const requestAiAlternative = async () => {
  try {
    aiLoading.value = true
    const token = localStorage.getItem('token')
    
    // Gọi route /diet-plan/alternative mà anh em mình đã khai báo trong api.php
    const response = await axios.get('http://127.0.0.1:8000/api/diet-plan/alternative', {
      headers: { Authorization: `Bearer ${token}` }
    })
    
    // Cập nhật lại nội dung thực đơn AI mới ngay trên màn hình
    plan.value.alternative_plan = response.data.alternative_plan
    alert('Gemini AI đã đổi món mới thành công cho anh rồi nhé!')
  } catch (error) {
    console.error('Lỗi đổi món AI:', error)
    alert('Không kết nối được với AI lúc này, anh thử lại sau nhé!')
  } finally {
    aiLoading.value = false
  }
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
.btn-ai:disabled { background-color: #a0aec0; cursor: not-allowed; } /* Style khi nút bị vô hiệu hóa lúc đợi AI */
.badge-success { color: #276749; font-weight: bold; margin-top: 10px; }
.loading-msg, .error-msg { text-align: center; font-size: 18px; color: #e53e3e; }
</style>