<template>
  <div class="diet-container">
    <h2>KẾ HOẠCH ĂN KIÊNG CỦA ANH</h2>
    
    <div class="plan-card">
      <h3>Thực đơn đề xuất:</h3>
      <p class="plan-content">{{ currentPlan }}</p>
    </div>

    <div class="actions">
      <button @click="handleAccept" class="btn-accept">Chấp nhận thực đơn</button>
      <button @click="handleGetAlternative" class="btn-alt">Đổi thực đơn thay thế</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const currentPlan = ref('Sáng: Ức gà áp chảo + Khoai lang băm. Trưa: Cơm lứt + Cá hồi sốt cam. Tối: Salad dầu giấm + Bò áp chảo.')

const handleAccept = () => {
  alert('Đã chấp nhận thực đơn! Hệ thống sẽ lưu vào hồ sơ của anh.')
}

const handleGetAlternative = () => {
  currentPlan.value = 'Thực đơn thay thế: Sáng: Bánh mì đen + Trứng ốp la. Trưa: Bún gạo lứt thịt heo nạc. Tối: Canh bí đao nấu mọc + 1 quả táo.'
  alert('Đã đổi sang thực đơn thay thế theo luồng C&C View!')
}
</script>

<style scoped>
.diet-container { max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; text-align: center; }
.plan-card { background: #f1f2f6; padding: 15px; border-radius: 6px; margin: 20px 0; font-size: 16px; line-height: 1.6; }
.actions { display: flex; justify-content: space-around; gap: 10px; }
button { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
.btn-accept { background-color: #2ed573; color: white; }
.btn-alt { background-color: #ffa502; color: white; }
</style>