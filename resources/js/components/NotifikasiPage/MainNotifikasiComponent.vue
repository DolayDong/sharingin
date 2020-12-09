<template>
  <div class="container cotent-notifikasi">
    <div class="no-notip" v-if="notifications.length === 0">
      <img src="/images/notip/no-notip.png" />
    </div>
    <div
      v-else
      class="container"
      v-for="notifikasi in notifications"
      v-bind:key="notifikasi.id"
    >
      <div
        class="card"
        v-on:click.prevent="detailPostingan(notifikasi.postingan_id)"
      >
        <div :class="`card-header notifikasi-container ${notifikasi.dibaca === 0 ? 'belum_dibaca'  : null }`">
          <img
            :src="notifikasi.user.data.photo_profile"
            alt="profile"
            class="photo-profile"
          />
          <ul>
            <li>
              <p v-if="notifikasi.type === 0">
                {{ notifikasi.user.name }} menyukai postingan anda:
                {{ notifikasi.postingan.postingan_detail.caption }}
              </p>
              <p v-else-if="notifikasi.type === 1">
                <span v-if="notifikasi.dari === gw.id">
                  Anda berkomentar pada postingan anda sendiri
                </span>
                <span v-else>
                  <strong>{{ notifikasi.user.name }}</strong> berkomentar pada
                  postingan anda
                  {{ notifikasi.postingan.postingan_detail.caption }}
                </span>
              </p>
            </li>
            <li>
              <i class="fa fa-clock-o" aria-hidden="true">
                {{ convertWaktu(notifikasi.dibuat_pada) }}</i
              >
            </li>
          </ul>
          <div v-if="notifikasi.postingan.type === 0">
            <img
              :src="notifikasi.postingan.url_media"
              alt="profile"
              class="media-disukai"
            />
          </div>
          <div class="media-disukai" v-if="notifikasi.postingan.type === 2">
            <video
              :src="notifikasi.postingan.url_media"
              class="video__notif"
              width="100%"
              height="100%"
            ></video>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      gw: JSON.parse(sessionStorage.getItem("__user")),
      notifications: "",
      jumlahnotifikasi: null
    };
  },
  mounted() {
    this.getDataNotifikasi();
    this.getJumlahNotifikasi();
  },
  methods: {
    getDataNotifikasi() {
      axios
        .get(`/api/user/${this.gw.id}/notifikasi`, {
          headers: {
            API_TOKEN: this.gw.api_token,
          },
          params: {
            api_token: this.gw.api_token,
          },
        })
        .then((response) => {
          this.notifications = response.data.notifications;
          console.log(this.notifications);
        })
        .catch((error) => {
          console.log(error.response);
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
    detailPostingan(id) {
        this.$root.$emit('updatejumlahnotifikasi', this.jumlahnotifikasi);

      axios.post('/api/notifikasi/update_notifikasi/' + id, {}, {
        headers: {
          Authorization: 'Bearer ' + this.gw.api_token,
          API_TOKEN: this.gw.api_token
        }
      }).then(response => {
        if(response.status === 200){
          return this.$router.push({ name: "DetailPost", params: { idPost: id } });
        }
      }).catch(error => {
        alert("gagal update notifikasi")
      });
    },
    getJumlahNotifikasi(){
      axios.get('/api/notifikasi/jumlah_', {
        params: {
          api_token: this.gw.api_token
        }
      }).then(response => {
        this.jumlahnotifikasi = response.data.length;
      })
    }
  },
  
};
</script>

<style scoped>
.belum_dibaca {
  background-color: rgb(206, 206, 206);

}
</style>
