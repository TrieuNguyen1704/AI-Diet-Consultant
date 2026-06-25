import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import MetricsView from '../views/MetricsView.vue'
import DietPlanView from '../views/DietPlanView.vue'
import DonationView from '../views/DonationView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'login', component: LoginView },
    { path: '/metrics', name: 'metrics', component: MetricsView },
    { path: '/diet-plan', name: 'diet-plan', component: DietPlanView },
    { path: '/donation', name: 'donation', component: DonationView }
  ]
})

export default router