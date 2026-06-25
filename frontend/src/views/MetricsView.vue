<template>
  <div class="metrics-container">
    <h2>CẬP NHẬT CHỈ SỐ CƠ THỂ</h2>
    <form @submit.prevent="handleSubmitMetrics">
      <div class="form-group">
        <label>Thể trạng (Body Type):</label>
        <select v-model="body_type" required>
          <option value="Ectomorph">Ectomorph (Khó tăng cân, người gầy)</option>
          <option value="Mesomorph">Mesomorph (Dễ tăng cơ, cân đối)</option>
          <option value="Endomorph">Endomorph (Dễ tăng mỡ, đậm người)</option>
        </select>
      </div>

      <div class="form-group">
        <label>Chiều cao (cm):</label>
        <input type="number" v-model="height" required placeholder="Nhập chiều cao của anh..." />
      </div>

      <div class="form-group">
        <label>Cân nặng (kg):</label>
        <input type="number" v-model="weight" required placeholder="Nhập cân nặng hiện tại..." />
      </div>

      <div class="form-group">
        <label>Mức độ vận động / Giờ làm việc:</label>
        <select v-model="working_hours" required>
          <option value="Sedentary">Ít vận động (Làm việc văn phòng)</option>
          <option value="Lightly Active">Vận động nhẹ (Đi bộ nhẹ nhàng)</option>
          <option value="Moderately Active">Vận động nhiều (Có tập thể thao)</option>
        </select>
      </div>

      <button type="submit">Lưu chỉ số & Tạo thực đơn</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const body_type = ref('Mesomorph')
const height = ref('')
const weight = ref('')
const working_hours = ref('Sedentary')
const router = useRouter()

const handleSubmitMetrics = async () => {
  try {
    // Lấy token xác thực đã lưu từ bước đăng nhập
    const token = localStorage.getItem('token')
    
    // Gửi request kèm Header chứa Token xác thực
    const response = await axios.post('http://127.0.0.1:8000/api/metrics', {
      body_type: body_type.value,
      height: height.value,
      weight: weight.value,
      working_hours: working_hours.value
    }, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })

    alert(response.data.message)
    // Chuyển tiếp sang màn hình nhận thực đơn đề xuất
    router.push('/diet-plan')
  } catch (error) {
    alert('Không thể lưu chỉ số, anh vui lòng đăng nhập lại nhé!')
    // router.push('/')
  }
}
</script>

<style scoped>
.metrics-container { max-width: 450px; margin: 60px auto; padding: 30px; border: 1px solid #e0e0e0; border-radius: 12px; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
h2 { text-align: center; color: #2e3e50; margin-bottom: 25px; }
.form-group { margin-bottom: 18px; }
.form-group label { display: block; margin-bottom: 6px; font-weight: bold; color: #4a5568; }
.form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box; }
button { width: 100%; padding: 12px; background-color: #2ed573; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; }
button:hover { background-color: #26af5f; }
</style>