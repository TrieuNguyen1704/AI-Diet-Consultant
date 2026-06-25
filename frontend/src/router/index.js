import { createRouter, createWebHistory } from 'vue-router'

// Import các trang rời rạc
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'

// Import Layout và các trang hệ thống
import MainLayout from '../layouts/MainLayout.vue'
import MetricsView from '../views/MetricsView.vue'
import DietPlanView from '../views/DietPlanView.vue' // Mở comment nếu anh đã tạo file này
import DonationView from '../views/DonationView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // --- NHÓM 1: CÁC TRANG KHÔNG CẦN LAYOUT (AUTH) ---
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },

    // --- NHÓM 2: CÁC TRANG BÊN TRONG HỆ THỐNG (DÙNG MAIN LAYOUT) ---
    {
      path: '/app', // Chứa đường dẫn gốc ảo để bọc layout
      component: MainLayout,
      children: [
        {
          path: '/metrics', // Bấm link này sẽ chui vào thẻ <router-view> của MainLayout
          name: 'metrics',
          component: MetricsView
        },

        {
          path: '/diet-plan',
          name: 'diet-plan',
          component: DietPlanView
        },
        
        {
          path: '/donation',
          name: 'donation',
          component: DonationView
        }
      ]
    }
  ]
})

// Chặn truy cập nếu chưa có Token (Navigation Guard cơ bản)
router.beforeEach((to, from, next) => {
  const publicPages = ['/', '/register'];
  const authRequired = !publicPages.includes(to.path);
  const loggedIn = localStorage.getItem('token');

  if (authRequired && !loggedIn) {
    return next('/');
  }
  next();
})

export default router