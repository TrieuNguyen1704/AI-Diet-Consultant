<template>
  <div class="app-container">
    <RouterView />
  </div>
</template>

<script setup>
import { RouterView } from 'vue-router'
</script>

<style scoped>
/* Anh có thể thêm một chút style cơ bản cho toàn app nếu muốn, hoặc để trống */
.app-container {
  font-family: Arial, sans-serif;
  color: #333;
  background-color: #f9f9f9;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>