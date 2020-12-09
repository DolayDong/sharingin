<template>
  <div class="container__chat">
    <pesan-component :teman="contactDipilih" :pesans="pesans" @baru="addPesan" />
    <contact-component :temans="temans" @dipilih="mulaiObrolan" />
  </div>
</template>
<script>
import PesanComponent from "../PesanPage/PesanComponent.vue";
import ContactComponent from "../PesanPage/ContactComponent.vue";
export default {
  name: "pesan",
  components: { PesanComponent, ContactComponent },
  data() {
    return {
      contactDipilih: null,
      pesans: [],
      temans: [{teman: {data: {photo_profile: ''}}}],
      dataGw: JSON.parse(sessionStorage.getItem("__user")),
    };
  },
  mounted() {
    Echo.private(`pesan.ke.${this.dataGw.id}`).listen("PesanBaru", (e) => {
      this.handlePesanMasuk(e.pesan);
      console.log(e);
    })
  },
  beforeMount() {
    axios
      .get(`/api/temans`, {
        params: {
          api_token: this.dataGw.api_token,
        },
      })
      .then((response) => {
        this.temans = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  methods: {
    mulaiObrolan(teman) {
      console.log(teman);
      axios
        .get(`/api/pesan/${teman.teman.id}`, {
          params: {
            api_token: this.dataGw.api_token,
          },
        })
        .then((response) => {
          this.pesans = response.data;
          this.contactDipilih = teman;
        });
    },
    addPesan(text) {
      this.pesans.push(text);
    },
    handlePesanMasuk(pesan) {
      if (
        this.contactDipilih &&
        pesan.teman_id == this.contactDipilih.user_id
      ) {
        this.addPesan(pesan);
      }
    },
  },
};
</script>

<style scoped>
.container__chat {
  padding: 20px;
  position: fixed;
  width: 100%;
  top: 75px;
  display: flex;
  background-color: rgba(252, 149, 15, 0.6);
  max-height: 600px;
}
</style>