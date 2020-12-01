import MainHomeComponent from './components/HomePage/MainHomeComponent.vue';
import MainNotifikasiComponent from './components/NotifikasiPage/MainNotifikasiComponent.vue';
import MainPesanComponent from './components/PesanPage/MainPesanComponent.vue';
import MainUsersComponent from './components/TemanPage/MainUsersComponent.vue';
import MainProfileComponent from './components/ProfilePage/MainProfileComponent.vue';
import MainComponentError from './components/errors/MainComponentError.vue';
import MainDetailHalaman from './components/DetailPage/MainDetailComponent.vue';

export default {
    mode: 'history',
    routes: [
        {
            path: '/home',
            component: MainHomeComponent,
            props: true,
            name: "Home"
        },
        {
            path: '/notifikasi',
            component: MainNotifikasiComponent,
            props: true,
            name: "notifikasi"
        },
        {
            path: '/pesan',
            component: MainPesanComponent,
            props: true,
            name: "pesan"
        },
        {
            path: '/users',
            component: MainUsersComponent,
            props: true,
            name: "users"
        },
        {
            path: '/user/:user',
            component: MainProfileComponent,
            props: true,
            name: "profile"
        },
        {
            path: "/detail/:idPost",
            component: MainDetailHalaman,
            props: true,
            name: "DetailPost"
        },
        {
            path: '*',
            component: MainComponentError,
            name: 'Errors'
        }
    ]
}