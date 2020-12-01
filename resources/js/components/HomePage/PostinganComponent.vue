<template>
    <div class="home-post">
        <div class="container add-post">
            <ul>
                <li>
                    <img
                        class="image_profile"
                        src="/images/photo_profile_/default.png"
                        alt="profile"
                    />
                </li>
                <li>
                    <!-- section add foto -->
                    <modal-component>
                        <template v-slot:__judul>
                            Foto
                        </template>
                        <template v-slot:__title>
                            <h2>Add Photo</h2>
                        </template>
                        <template v-slot:__body>
                            <div class="container">
                                <div
                                    class="__preview__gambar"
                                    :style="resetPadding"
                                >
                                    <img
                                        :src="urlImage"
                                        alt=""
                                        v-show="isPreviewGambar"
                                        class="preview__gambar"
                                    />
                                    <h2 v-show="!isPreviewGambar">
                                        Preview Gambar
                                    </h2>
                                </div>
                            </div>
                        </template>
                        <template v-slot:__footer>
                            <form-add-foto v-on:previewGambar="previewGambar" />
                        </template>
                    </modal-component>
                    <!-- akhir section add foto -->
                </li>
                <li>
                    <!-- section add video -->
                    <modal-component>
                        <template v-slot:__judul>
                            Video
                        </template>
                        <template v-slot:__title>
                            <h2>Add Video</h2>
                        </template>
                        <template v-slot:__body>
                            <div class="container">
                                <div
                                    class="__preview__gambar"
                                    :style="resetPadding"
                                >
                                    <video
                                    width="500"
                                    height="250"
                                        controls
                                        :src="urlVideo"
                                        v-show="isPreviewVideo"
                                        class="preview__gambar"
                                    />
                                    <h2 v-show="!isPreviewGambar">
                                        Preview Gambar
                                    </h2>
                                </div>
                            </div>
                        </template>
                        <template v-slot:__footer>
                            <form-add-video v-on:previewVideo="previewVideo"/>
                        </template>
                    </modal-component>
                    <!-- akhir section add video -->
                </li>
                <li>
                    <!-- section add video -->
                    <modal-component>
                        <template v-slot:__judul>
                            Status
                        </template>
                        <template v-slot:__title>
                            <h2>Add Status</h2>
                        </template>
                        <template v-slot:__footer>
                            <form-add-status v-on:closeModalStatus="closeModalStatus" />
                        </template>
                    </modal-component>
                    <!-- akhir section add video -->
                </li>
            </ul>
        </div>
        <div class="postingan-teman">
            <div class="card container-postingan" v-for="postingan in postingans" v-bind:key="postingan.id">
                <div class="card-header header-postingan">
                    <img
                        :src="postingan.user.data.photo_profile"
                        alt="profile"
                    />
                    <ul>
                        <li>
                            <h3>{{postingan.user.name}}</h3>
                        </li>
                        <li>
                            <p>
                                <i class="fa fa-clock-o" aria-hidden="true">
                                    {{convertWaktu(postingan.diunggah)}}</i
                                >
                            </p>
                        </li>
                    </ul>
                    <span v-on:click.prevent="halamanPesan">
                        <send-message-postingan-component />
                    </span>
                    <span>
                        <button-option-postingan-component />
                    </span>
                </div>
                <div class="card-content postingan">
                    <div class="loading" style="width: 100px; height: 100px;" v-show="loading"></div>
                    <div class="postingan-text">
                                               <!-- layout untuk text -->
                            <div v-if="postingan.type === 1">
                                <p>
                                    {{ postingan.postingan_detail.caption }}
                                </p>
                            </div>
                            <!-- layout untuk gambar -->
                            <div
                                class="postingan-image"
                                v-else-if="postingan.type === 0"
                            >
                                <img
                                    :src="postingan.url_media"
                                    class="image__profile"
                                    alt="profile"
                                />
                                
                            </div>
                            <div class="container" v-else>
                                <video width="100%" :src="postingan.url_media" controls></video>
                            </div>
                    </div>
                </div>
                <div class="card-footer footer-postingan">
                    <div class="container">
                        <ul>
                            <li>
                                <button-like-component />
                                <p>
                                    <small>12 menyukai...</small>
                                </p>
                            </li>
                                <button-comment-component :post-id="postingan.id" />
                           
                            <li>
                                <button-share-component />
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
</template>
<script>
import ButtonAddPhoto from "../HelperComponent/ButtonAddPhoto.vue";
import FormAddFoto from "../HelperComponent/FormAddFoto.vue";
import FormAddStatus from "../HelperComponent/FormAddStatus.vue";
import FormAddVideo from "../HelperComponent/FormAddVideo.vue";
import ModalComponent from "../HelperComponent/ModalComponent.vue";
import SendMessagePostinganComponent from '../HelperComponent/SendMessagePostinganComponent.vue';
import ButtonOptionPostinganComponent from '../HelperComponent/ButtonOptionPostinganComponent.vue';
import ButtonLikeComponent from '../HelperComponent/ButtonLikeComponent.vue';
import ButtonCommentComponent from '../HelperComponent/ButtonCommentComponent.vue';
import ButtonShareComponent from '../HelperComponent/ButtonShareComponent.vue';
export default {
    // props: ["dataUser"],
    data() {
        return {
            isPreviewGambar: false,
            urlImage: "",
            resetPadding: { padding: "50px" },
            isPreviewVideo: false,
            urlVideo: "",
            // temans: {},
            dataUser: {},
            postingans: [],
            loading: true
        };
    },
    components: {
        ButtonAddPhoto,
        ModalComponent,
        FormAddStatus,
        FormAddVideo,
        FormAddFoto,
        SendMessagePostinganComponent,
        ButtonOptionPostinganComponent,
        ButtonLikeComponent,
        ButtonCommentComponent,
        ButtonShareComponent
    },
    mounted() {
        this.dataUser = JSON.parse(sessionStorage.getItem("__user"));
        console.log(this.dataUser);
        this.ambilPostinganTeman();
    },
    methods: {
        tampil() {
            console.log(this.$refs.modal.open());
            // this.$refs.modal.open();
        },
        previewGambar(preview) {
            if (preview.preview) {
                this.urlImage = "/" + preview.url;
                this.isPreviewGambar = true;
                this.resetPadding.padding = "0";
            } else {
                this.isPreviewGambar = false;
                this.resetPadding.padding = "50px";
                this.$children[0].tampil = false;
            }
        },
        previewVideo(preview) {
                if (preview.preview) {
                this.urlVideo = "/" + preview.url;
                this.isPreviewVideo = true;
                this.resetPadding.padding = "0";
            } else {
                this.isPreviewVideo = false;
                this.resetPadding.padding = "50px";
                this.$children[1].tampil = false;
                console.log(this.$children[1]);
            }
        },
        closeModalStatus(){
            this.$children[2].tampil = false;

        },
        ambilPostinganTeman(){
            axios.get('/api/postingan/teman', {
                headers: {
                    "API_TOKEN": this.dataUser.api_token
                },
                params: {
                    api_token: this.dataUser.api_token
                }
            }).then(response => {
                response.data.map(teman => {
                    if(teman.postingans.length !== 0){
                        this.postingans = teman.postingans;
                        this.loading = false;
                    }
                })
            }).catch((error => {
                console.log(error);
                this.loading = false;
            }))
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
        },
        halamanPesan(){
            this.$router.push({path: "/pesan", name: "pesan"});
        }
    }
};
</script>

<style scoped>
.__preview__gambar {
    text-align: center;
}
.__preview__gambar img.preview__gambar {
    width: 100%;
    max-height: 300px;
}


</style>
