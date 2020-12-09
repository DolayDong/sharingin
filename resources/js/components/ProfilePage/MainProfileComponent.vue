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
          <h1>{{ dataProfile.name }}</h1>
          <h3 v-if="dataProfile.data.pekerjaan">
            {{ dataProfile.data.pekerjaan }}
          </h3>
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
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Harum,
            mollitia fugiat reprehenderit sequi, dignissimos quas tenetur non
            maxime deleniti obcaecati doloremque voluptate ipsum, minima quod
            rerum veniam provident exercitationem recusandae? Tidak Boleh
            Terlalu panjang
          </small>
          <small v-else> 巴科特·拉赫·阿什 </small>
        </div>
        <div class="card-footer">
          <a href="#"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
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
            <!-- section add foto -->
            <modal-component>
              <template v-slot:__judul> Foto </template>
              <template v-slot:__title>
                <h2>Add Photo</h2>
              </template>
              <template v-slot:__body>
                <div class="container">
                  <div class="__preview__gambar" :style="resetPadding">
                    <img
                      :src="urlImage"
                      alt=""
                      v-show="isPreviewGambar"
                      class="preview__gambar"
                    />
                    <h2 v-show="!isPreviewGambar">Preview Gambar</h2>
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
              <template v-slot:__judul> Video </template>
              <template v-slot:__title>
                <h2>Add Video</h2>
              </template>
              <template v-slot:__body>
                <div class="container">
                  <div class="__preview__gambar" :style="resetPadding">
                    <video
                      width="500"
                      height="250"
                      controls
                      :src="urlVideo"
                      v-show="isPreviewVideo"
                      class="preview__gambar"
                    />
                    <h2 v-show="!isPreviewGambar">Preview Gambar</h2>
                  </div>
                </div>
              </template>
              <template v-slot:__footer>
                <form-add-video v-on:previewVideo="previewVideo" />
              </template>
            </modal-component>
            <!-- akhir section add video -->
          </li>
          <li>
          <!-- section add status -->
          <modal-component>
            <template v-slot:__judul> Status </template>
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
        <img
          src="/storage/nophoto.jpg"
          v-show="nopohoto"
          style="text-align: center"
        />
        <div
          class="loading"
          v-show="loading"
          style="width: 200px; height: 200px"
        ></div>

        <div
          class="card container-postingan"
          v-for="post in dataProfile.postingans"
          v-bind:key="post.id"
        >
          <div class="card-header header-postingan">
            <img :src="dataProfile.data.photo_profile" alt="profile" />
            <ul>
              <li>
                <h3>{{ dataProfile.name }}</h3>
                <!-- {{ post }} -->
              </li>
              <li>
                <p>
                  <i class="fa fa-clock-o" aria-hidden="true">
                    {{ convertWaktu(parseInt(post.diunggah)) }}</i
                  >
                </p>
              </li>
            </ul>
            <span
              ><i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i
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
              <div class="postingan-image" v-else-if="post.type === 0">
                <img
                  :src="post.url_media"
                  class="image__profile"
                  alt="profile"
                />
                <p>
                {{ post.postingan_detail.caption }}
              </p>
              </div>
              <div class="container" v-else>
                <video width="100%" :src="post.url_media" controls></video>
                <p>
                {{ post.postingan_detail.caption }}
              </p>
              </div>
            </div>
          </div>
          <div class="card-footer footer-postingan">
            <div class="container">
              <ul>
                <button-like-component :detail_="post" :likes="post.likes" />
                <button-comment-component
                  :post-id="post.id"
                  :jumlah-comment="post.comments.length"
                />
                <li>
                  <i class="fa fa-share-square-o fa-2x" aria-hidden="true"></i>
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
import ButtonLikeComponent from "../HelperComponent/ButtonLikeComponent.vue";
import ButtonCommentComponent from "../HelperComponent/ButtonCommentComponent.vue";
import ModalComponent from "../HelperComponent/ModalComponent.vue";
export default {
  components: { ButtonLikeComponent, ButtonCommentComponent },
  // props: ["dataUser"],
  data() {
    return {
      dataProfile: { data: { photo_profile: "" } },
      baseApp: window.BASE_APP,
      nopohoto: false,
      loading: true,
      dataku: JSON.parse(sessionStorage.getItem("__user")),
      resetPadding: { padding: "50px" },
      isPreviewVideo: false,
      isPreviewGambar: false,
      urlImage: "",
      urlVideo: "",

    };
  },
  mounted() {
    this.getDataProfile();
  },
  methods: {
    getDataProfile() {
      axios
        .get("/api" + this.$router.currentRoute.path, {
          params: { api_token: this.dataku.api_token },
        })
        .then((response) => {
          if (response.status === 200) {
            this.loading = false;
            this.dataProfile = response.data;
            console.log(this.dataProfile);
            if (this.dataProfile.postingans.length === 0) {
              this.nopohoto = true;
            }
          }
        })
        .catch(function (error) {
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
    closeModalStatus() {
      this.$children[2].tampil = false;
    },
        halamanPesan() {
      this.$router.push({ path: "/pesan", name: "pesan" });
    },

  },
};
</script>

<style scoped>
.__preview__gambar img.preview__gambar {
  width: 100%;
  max-height: 300px;
}
</style>
