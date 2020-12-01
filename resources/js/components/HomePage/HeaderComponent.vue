<template>
    <header>
        <nav>
            <div class="container">
                <div class="logo">
                    <h1><router-link to="/home">ShareAja</router-link></h1>
                </div>
                <div class="navigasi">
                    <ul>
                        <li v-on:click="navigasi('home')">
                            <i class="fa fa-home fa-2x" aria-hidden="true"></i
                            ><br /><span class="badge badge-nav">9+</span>
                        </li>
                        <li v-on:click="navigasi('pesan')">
                            <i class="fa fa-envelope fa-2x" aria-hidden="true"
                                ><br /></i
                            ><span class="badge badge-nav">9+</span>
                        </li>
                        <li v-on:click="navigasi('notifikasi')">
                            <i class="fa fa-bell fa-2x" aria-hidden="true"></i
                            ><br /><span class="badge badge-nav">9+</span>
                        </li>
                        <li v-on:click="navigasi('cari')">
                            <i
                                class="fa fa-search fa-2x"
                                aria-hidden="true"
                            ></i>
                        </li>
                        <li>
                            <i
                                class="fa fa-sign-out fa-2x"
                                aria-hidden="true"
                                v-on:click.prevent="logout"
                            ></i>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>
<script>
export default {
    mounted() {},
    methods: {
        navigasi(kemana) {
            if (kemana === "home") {
                if (this.$router.currentRoute.name !== "Home") {
                    this.$router.push("/home");
                }
            } else if (kemana === "pesan") {
                if (this.$router.currentRoute.name !== "pesan") {
                    this.$router.push("/pesan");
                }
            } else if (kemana === "notifikasi") {
                if (this.$router.currentRoute.name !== "notifikasi") {
                    this.$router.push("/notifikasi");
                }
            } else {
                if (this.$router.currentRoute.name !== "users") {
                    this.$router.push("/users");
                }
            }
        },
        logout(){
            sessionStorage.clear();
            return window.location.href = '/logout';
        }
    }
};
</script>
