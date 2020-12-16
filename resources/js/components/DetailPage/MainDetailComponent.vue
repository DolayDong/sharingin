<template>
  <div class="container cotent-detail">
    <div
      class="loading"
      style="width: 300px; height: 300px"
      v-show="loading"
    ></div>
    <div v-show="!loading" class="postingan-teman detail">
      <div class="card container-postingan">
        <div class="card-header header-postingan">
          <img :src="postingan.user.data.photo_profile" alt="profile" />
          <ul>
            <li>
              <h3>{{ postingan.user.name }}</h3>
            </li>
            <li>
              <p>
                <i class="fa fa-clock-o" aria-hidden="true">
                  {{ convertWaktu(postingan.diunggah) }}</i
                >
              </p>
            </li>
          </ul>
          <span>
            <i class="fa fa-envelope-o fa-lg" aria-hidden="true"></i>
          </span>
          <span><i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i></span>
        </div>
        <div class="card-content postingan">
          <div class="postingan-text">
            <!-- layout untuk text -->
            <div v-if="postingan.type === 1">
              <p>
                {{ postingan.postingan_detail.caption }}
              </p>
            </div>
            <!-- layout untuk gambar -->
            <div class="postingan-image" v-else-if="postingan.type === 0">
              <img
                :src="postingan.url_media"
                class="image__profile"
                alt="profile"
              />
              <p class="caption__" v-if="postingan.postingan_detail.caption">
                {{ postingan.postingan_detail.caption }}
              </p>
            </div>
            <div class="container" v-else>
              <video width="100%" :src="postingan.url_media" controls></video>
              <p class="caption__" v-if="postingan.postingan_detail.caption">
                {{ postingan.postingan_detail.caption }}
              </p>
            </div>
          </div>
        </div>
        <div class="card-footer footer-postingan">
          <div class="container">
            <ul>
              <button-like-component
                :detail_="postingan"
                :likes="postingan.likes"
              />
              <li>
                <i class="fa fa-share-square-o fa-2x" aria-hidden="true"></i>
                <p>
                  <small>bagikan</small>
                </p>
              </li>
            </ul>
          </div>
          <div class="container comment">
            <div v-if="komentars">
            <div
              class="card"
              v-for="komentar in komentars"
              v-bind:key="komentar.id"
            >

              <img
                :src="komentar.user.data.photo_profile"
                :alt="komentar.user.name"
                class="image__profile__comment"
              />
              <ul>
                <li>
                  <strong>{{ komentar.user.name }}</strong>
                </li>
                <li>
                  <p>
                    {{ komentar.body }}
                  </p>
                </li>
                <li>
                  <i class="fa fa-clock-o __waktu__comment" aria-hidden="true">
                    {{ convertWaktu(komentar.dibuat) }}</i
                  >
                </li>
              </ul>
            </div>
            </div>
            <form-commentar :post-id="postingan.id" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import FormCommentar from "../HelperComponent/FormComentar.vue";
import ButtonLikeComponent from "../HelperComponent/ButtonLikeComponent.vue";
export default {
  components: { FormCommentar, ButtonLikeComponent },
  data() {
    return {
      dataGw: JSON.parse(sessionStorage.getItem("__user")),
      postingan: {
        id: "",
        user: { data: "" },
        postingan_detail: { caption: "" },
      },
      loading: true,
      komentars: [{user: {data: {}}}],
    };
  },
  mounted() {
    this.getDetailPostingan();
    this.getKomentarPostingan();
  },
  methods: {
    getDetailPostingan() {
      axios
        .get(
          `/api/postingan/${this.$router.currentRoute.params.idPost}/detail`,
          {
            params: {
              api_token: this.dataGw.api_token,
            },
          }
        )
        .then((response) => {
          this.postingan = response.data;
          this.loading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getKomentarPostingan() {
      axios
        .get(
          `/api/postingan/${parseInt(
            this.$router.currentRoute.params.idPost
          )}/komentar`,
          {
            params: {
              api_token: this.dataGw.api_token,
            },
          }
        )
        .then((response) => {
          this.komentars = response.data;
          console.log(this.komentars);
        })
        .catch((error) => {
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
  },
};
</script>

<style scoped>
.caption__ {
}

.image__profile__comment {
}

.container.comment {
  border-top: 1px solid rgb(255, 133, 34);
  border-bottom: 1px solid rgb(255, 133, 34);
}

.container.comment .card {
  border-bottom: 1px solid rgb(143, 142, 142);
  display: flex;
}
.container.comment .card img {
  margin-right: 10px;
  border-radius: 50%;
  width: 70px;
  height: 70px;
}

.container.comment .card ul {
  text-align: start;
  text-align: justify;
  flex-direction: column;
}

.container.comment .card ul li p {
  padding-top: 7px;
}
</style>
