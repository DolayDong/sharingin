<template>
  <div class="container__pesan">
    <div class="header__pesan">
      <ul>
        <li class="nama__teman">
          <h1>
            {{
              teman
                ? teman.teman.name
                : "Klik 1 ae rek sopo rty bales wkwk 🤡🤡"
            }}
          </h1>
        </li>
        <call-component :teman="teman" />
        <video-call-component :teman="teman" />
      </ul>
    </div>
    <PesanBodyComponent :pesans="pesans" :teman="teman" />
    <PesanFooterComponent @kirim="kirimPesan" />
  </div>
</template>
<script>
import PesanFooterComponent from "./PesanFooterComponent.vue";
import PesanBodyComponent from "./PesanBodyComponent.vue";
import VideoCallComponent from "../HelperComponent/VideoCallComponent.vue";
import CallComponent from '../HelperComponent/CallComponent.vue';
export default {
  components: { PesanBodyComponent, PesanFooterComponent, VideoCallComponent, CallComponent },
  data() {
    return {
            dataGw: JSON.parse(sessionStorage.getItem("__user")),
    };
  },
  props: {
    pesans: {
      type: Array,
      default: [],
    },
    teman: {
      type: Object,
      default: null,
    },
  },
  mounted() {
  },
  methods: {
    kirimPesan(text) {
      if (!this.teman) {
        return;
      }

      axios
        .post(
          "/api/pesan/kirim",
          {
            user_id: this.dataGw.id,
            pesan: text,
            teman_id: this.teman.teman_id,
          },
          {
            headers: {
              Authorization: "Bearer " + this.dataGw.api_token,
            },
          }
        )
        .then((response) => {
          this.$emit("baru", response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.container__pesan {
  overflow: auto;
  flex: 5;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.header__pesan h1 {
  font-size: 21px;
}
.header__pesan {
  background-color: aliceblue;
  padding: 2px;
  padding-left: 5px;
  border-radius: 2px;
}
.header__pesan ul {
  display: flex;
}
.header__pesan ul li {
  list-style-type: none;
  align-self: center;
}
.vc__icon {
  margin-right: 20px;
  color: #fc4803a8;
  padding: 2px;
}

.vc__icon:hover,
.call__icon:hover {
  background-color: #f1801573;
  border-radius: 3px;
  color: #fafafad3;
}

.call__icon {
  color: #fc4803a8;
  margin-right: 20px;
  padding: 2px;
}

.nama__teman {
  flex: 10;
}
</style>