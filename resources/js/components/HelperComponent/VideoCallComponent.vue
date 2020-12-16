<template>
  <div class="container">
    <li class="vc__icon" v-show="teman" @click="vc">
      <i class="fa fa-video-camera fa-2x" aria-hidden="true"></i>
    </li>
    <!-- The Modal -->
    <div id="myModal" class="modal__comp__" v-show="tampil">
      <!-- Modal content -->
      <div class="modal__cont__">
        <div class="__body__modal">
          <div class="container__video">
            <video class="video__gw" ref="video__gw" autoplay></video>
            <video class="video__teman" ref="video__teman" autoplay></video>
          </div>
        </div>
        <div class="__modal__footer">
          <div class="container__button__vc">
            <button>
              <h3
                v-show="pemanggil"
                class="tolak__vcall"
                v-on:click.prevent="batalCall"
              >
                <i class="fa fa-video-camera fa-2x" aria-hidden="true"> Tolak</i>
              </h3>
            </button>
             <h3
                v-show="!pemanggil"
                class="tolak__vcall"
                v-on:click.prevent="batalCall"
              >
                <i class="fa fa-video-camera fa-2x" aria-hidden="true"> Akhiri</i>
              </h3>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const APP_KEY = "4c08e21f32b2ed3689f9";
import Peer from "simple-peer";

export default {
  props: {
    teman: {
      type: Object,
      default: null,
    },
  },
  mounted() {
    // this.stream = null;
    // this.temanStream.stream = null;
    // this.setupPusher();
    this.setupVc();
  },
  data() {
    return {
      tampil: false,
      tersedia: false,
      dataGw: JSON.parse(sessionStorage.getItem("__user")),
      idTeman: null,
      muted: true,
      peers: { userId: {} },
      pemanggil: false,
      streamTeman: undefined,
      stream: null,
      channel: null,
    };
  },
  watch: {
    teman(data) {
      this.teman = data;
    },
    streamTeman(data) {
      this.streamTeman = data;
    },
  },
  async mediaRemote() {
    const streamMedia = await this.mintaAkses();
    console.log(streamMedia);
  },
  methods: {
    batalCall: function () {
      this.stream.getTracks().forEach((track) => {
        track.stop();
        this.stream.removeTrack(track);
        this.tampil = false;
      });
    },
    vc() {
      this.mintaAkses()
        .then((stream) => {
          this.stream = stream;

          this.tersedia = true;
          try {
            this.$refs.video__gw.srcObject = stream;
          } catch (error) {
            this.$refs.video__gw.src = URL.createObjectURL(stream);
          }
          this.$refs.video__gw.play();
          this.tampil = !this.tampil;
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.vcallKe(this.teman.teman_id, this.dataGw.name);
        });
    },
    vcallKe(userId, nama) {
      this.pemanggil = true;
      this.peers[userId] = this.mulaiPanggilan(userId, true, nama);
    },
    mintaAkses: async () => {
      return await new Promise((resolve, reject) => {
        navigator.mediaDevices
          .getUserMedia({
            audio: true,
            video: true,
          })
          .then((strem) => {
            resolve(strem);
          })
          .catch((error) => {
            throw new Error(
              `Harap mengaktifkan ijin untuk akses media anda:  Error : ${error}`
            );
          });
      });
    },
    setupVc() {
      const pusher = this.setupPusher();
      this.channel = pusher.subscribe("presence-video-channel");
      this.channel.bind(`client-signal-${this.dataGw.id}`, async (signal) => {
        var peer = this.peers[signal.userId];

        if (peer === undefined) {
          let panggilanMasuk = confirm(`${signal.nama} memanggil`);

          if (panggilanMasuk) {
            const media = async() => {
              return await navigator.mediaDevices
                .getUserMedia({ video: true, audio: true })
                .then((stream) => {
                  this.stream = stream
                  console.log(this)
                  if ("srcObject" in this.$refs.video__gw) {
                    this.$refs.video__gw.srcObject = stream;
                  } else {
                    this.$refs.video__gw.src = window.URL.createObjectURL(
                      stream
                    ); // for older browsers
                  }

                });
            };

            const data = await media()
            peer = this.mulaiPanggilan(signal.userId, false);
              
            this.tampil = !this.tampil;
            // this.pemanggil = !pemanggil;

          
          }
        }
      peer.signal(signal.data);
      });
    },
    setupPusher() {
      return new Pusher(APP_KEY, {
        authEndpoint: "/pusher/auth",
        cluster: "ap4",
        auth: {
          params: this.dataGw.id,
          headers: {
            "X-CSRF-TOKEN": document
              .querySelector("meta[name=csrf-token]")
              .getAttribute("content"),
          },
        },
      });
    },
    mulaiPanggilan(userId, initiator = true, nama) {
      const peer = new Peer({
        initiator,
        stream: this.stream,
        trickle: false,
      });
      console.log(peer);

      peer.on("stream", (stream) => {
        console.log("stream_________________________********************* 😊");
        if ("srcObject" in this.$refs.video__teman) {
          this.$refs.video__teman.srcObject = stream;
        } else {
          this.$refs.video__teman.src = window.URL.createObjectURL(stream); // for older browsers
        }
        // this.$refs.video__teman.play();
        window.alert("on stream");
      });
      peer.on("signal", (data) => {
        console.log(data);
        // memberi sinyal bahwa ada panggilan masuk
        this.channel.trigger(`client-signal-${userId}`, {
          type: "signal",
          userId: this.dataGw.id,
          nama: nama,
          data: data,
        });
      });

      peer.on("connect", () => {
        alert("connect");
      });

      peer.on("close", () => {
        let peer = this.peers[userId];

        if (peer !== undefined) {
          peer.destroy();
        }
        this.peers[userId] = undefined;
      });

      return peer;
    },
  },
};
</script>

<style scoped>
.modal__comp__ {
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0, 0, 0);
  background-color: rgba(0, 0, 0, 0.3);
}

.modal__cont__ {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  width: 50%;
  border-radius: 15px 15px 0 0;
  border: 1px solid #888;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  -webkit-animation-name: __animasiatas;
  -webkit-animation-duration: 0.7s;
  animation-name: __animasiatas;
  animation-duration: 0.7s;
}

@-webkit-keyframes __animasiatas {
  from {
    transition: all 0.5s;
    opacity: 0;
  }
  to {
    transform: matrix(2);
    opacity: 1;
  }
}

@keyframes __animasiatas {
  from {
    opacity: 0;
  }
  to {
    transform: matrix(2);
    opacity: 1;
  }
}

.__tutup_modal {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.__tutup_modal:hover,
.__tutup_modal:focus {
  color: red;
  text-decoration: none;
  cursor: pointer;
}

.__modal__header {
  border-radius: 15px 15px 0 0;
  padding: 2px 16px;
  background-color: rgba(233, 142, 38, 0.7);
  color: white;
}

.__body__modal {
  padding: 2px 16px;
}

.__modal__footer {
  padding: 2px 16px;
  background-color: rgb(233, 142, 38);
  color: rgba(255, 255, 255, 0.5);
}

video.video__gw {
  width: 20%;
  position: relative;
  bottom: -300px;
  z-index: 4;
  left: 10px;
  border: 1px solid rgb(233, 142, 38);
}
video.video__teman {
  width: 100%;
}

.vc__icon {
  color: #fc4803a8;
  list-style: none;
}

.tolak__vcall {
  border-radius: 5px;
    color: white;
    width: 60px;
    border: 1px solid white;
    background-color: rgba(255, 0, 0, 0.8);
}
</style>