<template>
  <div class="metrics-container">
    <h2>NHẬP CHỈ SỐ CƠ THỂ</h2>
    <form @submit.prevent="handleSubmitMetrics">
      <div class="form-group">
        <label>Loại thể trạng (Body Type):</label>
        <select v-model="body_type" required>
          <option value="Ectomorph">Ectomorph (Người gầy, khó tăng cân)</option>
          <option value="Mesomorph">Mesomorph (Người cân đối, dễ tăng cơ)</option>
          <option value="Endomorph">Endomorph (Người đậm người, dễ tăng mỡ)</option>
        </select>
      </div>

      <div class="form-group">
        <label>Chiều cao (cm):</label>
        <input type="number" v-model="height" required placeholder="Ví dụ: 170" />
      </div>

      <div class="form-group">
        <label>Cân nặng (kg):</label>
        <input type="number" v-model="weight" required placeholder="Ví dụ: 65" />
      </div>

      <div class="form-group">
        <label>Thời gian làm việc / Mức độ vận động:</label>
        <select v-model="working_hours" required>
          <option value="Sedentary">Ít vận động (Làm việc văn phòng)</option>
          <option value="Lightly Active">Vận động nhẹ (Đi lại nhẹ nhàng)</option>
          <option value="Moderately Active">Vận động nhiều (Có tập thể thao)</option>
        </select>
      </div>

      <button type="submit">Tính toán kết quả</button>
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
    const token = localStorage.getItem('token')
    
    // Gửi dữ liệu lên API Laravel bám sát kết nối C&C View
    await axios.post('http://127.0.0.1:8000/api/metrics', {
      body_type: body_type.value,
      height: height.value,
      weight: weight.value,
      working_hours: working_hours.value
    }, {
      headers: { Authorization: `Bearer ${token}` }
    })

    // Sau khi lưu chỉ số thành công, chuyển sang màn hình nhận kết quả thực đơn
    router.push('/diet-plan')
  } catch (error) {
    alert('Có lỗi xảy ra khi gửi dữ liệu, anh kiểm tra lại nhé!')
  }
}
</script>

<style scoped>
.metrics-container { max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.form-group input, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; }
button { width: 100%; padding: 10px; background-color: #2ed573; color: white; border: none; border-radius: 4px; cursor: pointer; }
</style>