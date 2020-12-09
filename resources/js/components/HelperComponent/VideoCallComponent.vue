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
            <video class="video__gw" ref="video__gw"></video>
            <video
              class="video__teman"
              ref="video__teman"
              :muted="muted"
            ></video>
          </div>
        </div>
        <div class="__modal__footer">Footer Modal</div>
      </div>
    </div>
  </div>
</template>

<script>
import MediaHandler from "../../MediaHandler.js";
const APP_KEY = "4c08e21f32b2ed3689f9";

export default {
  props: {
    teman: {
      type: Object,
      default: null,
    },
  },
  mounted() {
    this.dataGw.stream = null;
    this.setupPusher();
  },
  data() {
    return {
      tampil: false,
      tersedia: false,
      dataGw: JSON.parse(sessionStorage.getItem("__user")),
      idTeman: null,
      stream: null,
      muted: true,
      peers: { userId: {} },
    };
  },
  watch: {
    teman(data) {
      this.teman = data;
    },
  },
  methods: {
    vc() {
      console.log(this.mintaAkses());
      this.mintaAkses().then((stream) => {
        this.stream = stream;
        this.tersedia = true;
        try {
          this.$refs.video__gw.srcObject = stream;
        } catch (error) {
          this.$refs.video__gw.src = URL.createObjectURL(stream);
        }
        this.$refs.video__gw.play();
        this.tampil = !this.tampil;
        this.vcallKe(this.teman);
      }).catch(error => {
        console.log(error);
      });
    },
    vcallKe(teman) {
      this.peers[teman.teman_id] = this.startPeer(teman.teman_id);
    },
    terimaPanggilan() {
      let terima = false;
    },
    mintaAkses() {
      return new Promise((resolve, reject) => {
        navigator.mediaDevices.getUserMedia({
          audio: true,
          video: true
        }).then(strem => {
          resolve(strem);
        })
          .catch((error) => {
            throw new Error(
              `Harap mengaktifkan ijin untuk akses media anda:  Error : ${error}`
            );
          });
      });
    },
    setupPusher() {
      this.pusher = new Pusher(APP_KEY, {
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

      this.channel = this.pusher.subscribe("presence-video-channel");
      this.channel.bind(`client-signal-${this.dataGw.id}`, (signal) => {
        let peer = this.peers[signal.userId];

        let panggilanMasuk = confirm(`${signal.name} memanggil`);


        // jika ga ada peer, berarti tersedia
        if (peer === undefined) {
          if(panggilanMasuk){
            
            this.idTeman = signal.userId;
            this.tampil = !this.tampil;
  
            peer = this.startPeer(signal.userId, false);
          }
        }
        peer.signal(signal.data);
      });
    },
    startPeer(user, initiator = true) {
      const peer = new Peer({
        initiator,
        stream: this.stream,
        trickle: false,
      });

      peer.on("signal", (data) => {
        this.channel.trigger(`client-signal-${user.id}`, {
          type: "signal",
          userId: this.dataGw.id,
          data: data,
          name: user.name
        });
      });

      peer.on("stream", (stream) => {
        if ("srcObject" in this.$refs.video__teman) {
          this.$refs.video__teman.srcObject = stream;
        } else {
          alert("gada src object");
          this.$refs.video__teman.src = window.URL.createObjectURL(stream); // for older browsers
        }
        this.$refs.video__teman.play();
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
</style>