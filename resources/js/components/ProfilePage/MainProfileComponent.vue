<template>
    <div class="container cotent-profile">
        <div class="profile-card">
            <div class="card profile">
                <div class="card-header slider-profile">
                    <img
                        v-if="dataProfile"
                        :src="dataProfile.data.photo_profile"
                        alt="profile"
                        class="detail-profile-photo" 
                    />
                </div>
                <i
                    class="fa fa-info-circle"
                    aria-hidden="true"
                    id="detaildataprofile"
                ></i>
                <div class="card-content">
                    <h1>{{dataProfile.name}}</h1>
                    <h3 v-if="dataProfile.data.pekerjaan">{{dataProfile.data.pekerjaan}}</h3>
                    <h3 v-else>Belum mencantumkan pekerjaan</h3>
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
                <div class="tentang-profile">
                    <p>Tentang</p>
                    <small v-if="dataProfile.data.tentang">
                        Lorem ipsum dolor sit, amet consectetur adipisicing
                        elit. Harum, mollitia fugiat reprehenderit sequi,
                        dignissimos quas tenetur non maxime deleniti obcaecati
                        doloremque voluptate ipsum, minima quod rerum veniam
                        provident exercitationem recusandae? Tidak Boleh Terlalu
                        panjang
                    </small>
                    <small v-else>
                        巴科特·拉赫·阿什
                    </small>
                </div>
                <div class="card-footer">
                    <a href="#"
                        ><i class="fa fa-pencil fa-lg" aria-hidden="true"></i
                    ></a>
                </div>
            </div>
        </div>
        <div class="profile-post">
            <div class="container add-post">
                <ul>
                    <li>
                        <img
                            src="/images/photo_profile_/default.png"
                            alt="profile"
                            class="image_profile"
                        />
                    </li>
                    <li>
                        <button class="tombol" disabled>
                            <i class="fa fa-plus" aria-hidden="true">Video</i>
                        </button>
                    </li>
                    <li>
                        <button class="tombol" disabled>
                            <i class="fa fa-plus" aria-hidden="true">Foto</i>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="postingan-teman">
                <img src="/storage/nophoto.jpg" v-show="nopohoto" style="text-align: center"/>
                <div class="loading" v-show="loading" style="width: 200px; height: 200px;"></div>

                <div
                    class="card container-postingan"
                    v-for="post in dataProfile.postingans"
                    v-bind:key="post.id"
                >
                    <div class="card-header header-postingan">
                        <img
                            :src="
                                    dataProfile.data.photo_profile
                            "
                            alt="profile"
                        />
                        <ul>
                            <li>
                                <h3>{{ dataProfile.name }}</h3>
                                <!-- {{ post }} -->
                            </li>
                            <li>
                                <p>
                                    <i class="fa fa-clock-o" aria-hidden="true">
                                        {{
                                            convertWaktu(
                                                parseInt(post.diunggah)
                                            )
                                        }}</i
                                    >
                                </p>
                            </li>
                        </ul>
                        <span>
                            <i
                                class="fa fa-envelope-o fa-lg"
                                aria-hidden="true"
                            ></i>
                        </span>
                        <span
                            ><i
                                class="fa fa-ellipsis-v fa-lg"
                                aria-hidden="true"
                            ></i
                        ></span>
                    </div>
                    <div class="card-content postingan">
                        <div class="postingan-text">
                            <!-- layout untuk text -->
                            <div v-if="post.type === 1">
                                <p>
                                    {{ post.postingan_detail.caption }}
                                </p>
                            </div>
                            <!-- layout untuk gambar -->
                            <div
                                class="postingan-image"
                                v-else-if="post.type === 0"
                            >
                                <img
                                    :src="post.url_media"
                                    class="image__profile"
                                    alt="profile"
                                />
                                
                            </div>
                            <div class="container" v-else>
                                <video width="100%" :src="post.url_media" controls></video>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer footer-postingan">
                        <div class="container">
                            <ul>
                                <li>
                                    <i
                                        class="fa fa-heart-o fa-2x"
                                        aria-hidden="true"
                                    ></i>
                                    <p>
                                        <small>12 menyukai...</small>
                                    </p>
                                </li>
                                <li>
                                    <i
                                        class="fa fa-comments-o fa-2x"
                                        aria-hidden="true"
                                    ></i>
                                    <p>
                                        <small>12 berkomentar...</small>
                                    </p>
                                </li>
                                <li>
                                    <i
                                        class="fa fa-share-square-o fa-2x"
                                        aria-hidden="true"
                                    ></i>
                                    <p>
                                        <small>bagikan</small>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    // props: ["dataUser"],
    data() {
        return {
            dataProfile: {data: {photo_profile: ''}},
            baseApp: window.BASE_APP,
            nopohoto: false,
            loading: true,
            dataku: JSON.parse(sessionStorage.getItem("__user"))
        };
    },
    mounted() {
        this.getDataProfile();
        
    },
    methods: {
        getDataProfile() {
            axios
                .get("/api" + this.$router.currentRoute.path,{
                    params: {api_token: this.dataku.api_token}
                })
                .then(response => {
                    if(response.status === 200){
                        this.loading = false;
                        this.dataProfile = response.data;
                        console.log(this.dataProfile)
                    if(this.dataProfile.postingans.length === 0){
                        this.nopohoto = true;
                    }

                    }

                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        convertWaktu(timestamp) {
            const format = new Date(timestamp * 1000);
            const tanggalHari = format.toDateString();
            const waktu =
                this.addNolWaktu(format.getHours()) +
                ":" +
                this.addNolWaktu(format.getSeconds());
            return tanggalHari + " | " + waktu;
        },

        addNolWaktu(waktu) {
            if (waktu < 10) {
                waktu = "0" + waktu;
            }
            return waktu;
        }
    }
};
</script>
