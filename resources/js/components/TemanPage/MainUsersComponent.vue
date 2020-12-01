<template>
    <div class="container cotent-cari">
        <div class="container">
            <div class="form-cari">
                <input
                    type="text"
                    autocomplete="off"
                    placeholder="ketikkan nama user..."
                />
                <i
                    class="fa fa-search fa-2x"
                    aria-hidden="true"
                    id="iconcari"
                ></i>
            </div>
        </div>
        <div class="result">
            <div class="container">
            <div class="loading" v-show="loading" style="width: 200px; height: 200px;"></div>
                <div class="container-photo-profile">
                    <div
                        class="card ketengan"
                        v-for="user in users"
                        v-bind:key="user.id"
                        v-if="user.id !== data.id"
                    >
                            <ul >
                                <li>
                                    <img
                                        :src="user.photo_profile"
                                        alt="profile"
                                        class="photo-user"
                                    />
                                </li>
                                <li>
                                    <p>{{user.name}}</p>
                                    <profile-button :name="user.name" />
                                </li>
                                <li>
                                    <button-add-teman-sedang />
                                </li>
                            </ul>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>
<script>
import ProfileButton from '../HelperComponent/ProfileButton.vue';
import ButtonAddTemanSedang from '../HelperComponent/ButtonAddTemanSedang.vue';
export default {
  components: { ProfileButton, ButtonAddTemanSedang },
    props: ["dataUser"],
    data() {
        return {
            users: {},
            data: JSON.parse(sessionStorage.getItem("__user")),
            loading: true
        };
    },
    mounted() {
        
        this.getDatUsers();
    },
    methods: {
        getDatUsers() {
            axios
                .get("/api/users", {
                    params: {api_token: this.data.api_token}
                })
                .then(response => {
                    if(response.status === 200){
                        console.log(response);
                        this.users = response.data;
                        this.loading = false;

                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    }
};
</script>
