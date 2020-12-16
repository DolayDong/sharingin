<template>
    <div class="home-teman">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h2>Users</h2>
                </div>
                <div class="loading" v-show="loading"></div>
                <div v-for="(index, user) in users" v-bind:key="user.id" >
                    <div class="card-content user-sugestion" v-if="index.teman == null" >
                        <ul v-if="index.id !== userData.id" v-on:click="profile($event, index.name)">
                            <li>
                                <img
                                    class="show__image__profile"
                                    src="/images/photo_profile_/default.png"
                                    :alt="index.name"
                                />
                            </li>
                            <li>
                                <p>{{index.name}}</p>
                                <small>pekerjaan</small>
                            </li>
                            <li class="__btn__add__teman">
                                    <button-add-teman-kecil :berteman="index.teman" v-bind:key="user.id" :user-id="index.id" :my-data="userData" />
                               
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer" v-on:click="pindahUsers" v-if="users.length !== 0">
                    <p>Lihat lebih banyak...</p>
                </div>
                <div style="margin-top: 10px; padding: 10px;" v-else>
                    <h3>Belom ada user mendaftar</h3>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ButtonAddTemanKecil from '../HelperComponent/ButtonAddTemanKecil.vue';
export default {
  components: { ButtonAddTemanKecil },
    data() {
        return {
            userData: {},
            users: {},
            loading: true
        };
    },
    mounted() {
        this.userData = JSON.parse(sessionStorage.getItem("__user"));
        this.getDataUsers();
    },
    methods: {
        getDataUsers() {
            axios
                .get("/api/users", {
                    params: {api_token: this.userData.api_token}
                })
                .then(response => {
                    this.users = response.data;
                    this.loading = false
                })
                .catch(error => {
                    console.log(error);
                });
        },
        pindahUsers(){
            if(this.$router.currentPath !== "users"){
                this.$router.push("/users");
            }
        },
        profile(event, name){
            if(event.target.getAttribute("class") !== "show__image__profile" && (event.target.classList.contains("__btn__add__teman") || event.target.classList.contains("__remove__teman"))){
                console.log(event.target.getAttribute("class"))
                // this.$router.push({name: "profile", params: {user: name}});
            }
        }
    }
};
</script>
