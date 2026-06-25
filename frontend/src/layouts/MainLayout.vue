<template>
  <div class="app-layout">
    <header class="master-header">
      <div class="logo">
        <h2>🥗 AI Diet Consultant</h2>
      </div>
      <nav class="main-nav">
        <router-link to="/metrics" class="nav-item">Chỉ số cơ thể</router-link>
        <router-link to="/diet-plan" class="nav-item">Thực đơn AI</router-link>
        <router-link to="/donation" class="nav-item">Kho máu & Hiến máu</router-link>
      </nav>
      <div class="user-actions">
        <button @click="handleLogout" class="btn-logout">Đăng xuất</button>
      </div>
    </header>

    <main class="master-content">
      <router-view></router-view> 
    </main>

    <footer class="master-footer">
      <p>&copy; 2026 AI Diet Consultant - Hệ thống tư vấn sức khỏe thông minh</p>
    </footer>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const handleLogout = () => {
  // Xóa token bảo mật và đá về trang đăng nhập
  localStorage.removeItem('token')
  router.push('/')
}
</script>

<style scoped>
/* Reset form cơ bản cho layout */
.app-layout { display: flex; flex-direction: column; min-height: 100vh; background-color: #f7fafc; }

/* CSS Header */
.master-header { display: flex; justify-content: space-between; align-items: center; background-color: #ffffff; padding: 15px 40px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
.logo h2 { margin: 0; color: #2c3e50; font-size: 22px; }
.main-nav { display: flex; gap: 25px; }
.nav-item { text-decoration: none; color: #4a5568; font-weight: 600; padding: 8px 12px; border-radius: 6px; transition: all 0.2s; }
.nav-item:hover, .nav-item.router-link-active { background-color: #edf2f7; color: #3182ce; }

/* CSS Nút Đăng xuất */
.btn-logout { background-color: #e53e3e; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.2s; }
.btn-logout:hover { background-color: #c53030; }

/* CSS Content (Giữa) */
.master-content { flex: 1; /* Chiếm toàn bộ không gian trống còn lại */ padding: 40px; }

/* CSS Footer */
.master-footer { background-color: #2d3748; color: #e2e8f0; text-align: center; padding: 15px; font-size: 14px; }
</style>