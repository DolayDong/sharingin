<template>
    <div class="home-profile">
        <div class="card profile">
            <div class="card-header">
                <img src="/images/photo_profile_/default.png" alt="profile" />
            </div>
            <div class="card-content">
                <h1>{{user.name}}</h1>
                <h3 v-if="user.pekerjaan">{{user.pekerjaan}}</h3>
                <h3 v-else>Belum menambah pekerjaan</h3>
                <ul>
                    <li>
                        <h3>Mengikuti</h3>
                        <h4>10</h4>
                    </li>
                    <li>
                        <h3>Pengikut</h3>
                        <h4>10</h4>
                    </li>
                </ul>
            </div>
            <div class="card-footer" v-on:click.prevent.stop="profile">
                <a href="#">lihat profile</a>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            user: JSON.parse(sessionStorage.getItem("__user"))
        }
    },
    // props: ["dataUser"],
    mounted(){
        console.log(this.user);
    },
    methods: {
        profile(){
            if(this.$router.currentPath !== this.user.name){
                this.$router.push({name: "profile", params: {user: this.user.name}});
            }
        }
    }

};
</script>
