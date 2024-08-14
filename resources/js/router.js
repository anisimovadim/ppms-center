import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '@/components/pages/HomePage.vue';
import NewsPage from '@/components/pages/NewsPage.vue';
import RegistratePage from '@/components/pages/RegistratePage.vue';
import AdminPage from '@/components/pages/Admin/AdminPage.vue';
import EmployesPage from '@/components/pages/EmployesPage.vue';
import ConstructorPage from "@/components/pages/ConstructorPage.vue";
import MessagePage from "@/components/pages/MessagePage.vue";
import CommentPage from "@/components/pages/CommentPage.vue";
import CreatePostPage from "@/components/pages/CreatePostPage.vue";
import SpecialPage from "@/components/pages/SpecialPage.vue";
import CalendarPage from "@/components/pages/CalendarPage.vue";

// console.log(`ZeroBlock: `, ZeroBlock)

const routes = [
    { path: '/', component: HomePage },
    { path: '/news', component: NewsPage },
    { path: '/create/news', component: ConstructorPage },
    { path: '/registration', component: RegistratePage },
    { path: '/admin/page', component: AdminPage },
    { path: '/specialists', component: EmployesPage },
    { path: '/send/message/page', component: MessagePage },
    { path: '/comments/new=:id', component: CommentPage },
    { path: '/create/post/page=:id', component: CreatePostPage },
    { path: '/edit/post/page=:id/post=:post_id', component: CreatePostPage },
    { path: '/page=:id', component: SpecialPage },
    { path: '/calendar', component: CalendarPage },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
