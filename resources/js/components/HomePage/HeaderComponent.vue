<template>
  <header>
    <nav>
      <div class="container">
        <div class="logo">
          <h1><router-link to="/home">ShareAja</router-link></h1>
        </div>
        <div class="navigasi">
          <ul>
            <li v-on:click="navigasi('home')">
              <i class="fa fa-home fa-2x" aria-hidden="true"></i><br /><span
                class="badge badge-nav" v-if="jumlahupdatepost"
                ></span
              >
            </li>
            <li v-on:click="navigasi('pesan')">
              <i class="fa fa-envelope fa-2x" aria-hidden="true"><br /></i
              ><span v-if="jumlahpesan" class="badge badge-nav"></span>
            </li>
            <li v-on:click="navigasi('notifikasi')">
              <i class="fa fa-bell fa-2x" aria-hidden="true"></i><br /><span v-if="jumlahnotifikasi"
                class="badge badge-nav"
                >{{jumlahnotifikasi}}</span
              >
            </li>
            <li v-on:click="navigasi('cari')">
              <i class="fa fa-search fa-2x" aria-hidden="true"></i>
            </li>
            <li>
              <i
                class="fa fa-sign-out fa-2x"
                aria-hidden="true"
                v-on:click.prevent="logout"
              ></i>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>
<script>
export default {
  data(){
    return {
      jumlahnotifikasi: 0,
      mydata: JSON.parse(sessionStorage.getItem("__user")),
      jumlahupdatepost: null,
      jumlahpesan: null
    }
  },
  mounted() {
    this.getJumlahNotifikasi();
    this.$root.$on('updatejumlahnotifikasi', this.updatejumlahnotifikasi)
  },
  methods: {
    updatejumlahnotifikasi(data){
      this.jumlahnotifikasi = data;
    },
    navigasi(kemana) {
      if (kemana === "home") {
        if (this.$router.currentRoute.name !== "Home") {
          this.$router.push("/home");
        }
      } else if (kemana === "pesan") {
        if (this.$router.currentRoute.name !== "pesan") {
          this.$router.push({ name: "pesan", path: "/pesan" });
        }
      } else if (kemana === "notifikasi") {
        if (this.$router.currentRoute.name !== "notifikasi") {
          this.$router.push("/notifikasi");
        }
      } else {
        if (this.$router.currentRoute.name !== "users") {
          this.$router.push("/users");
        }
      }
    },
    logout() {
      sessionStorage.clear();
      return (window.location.href = "/logout");
    },

    getJumlahNotifikasi(){
      axios.get('/api/notifikasi/jumlah_', {
        params: {
          api_token: this.mydata.api_token
        }
      }).then(response => {
        this.jumlahnotifikasi = response.data.length;
      })
    }
  },
};
</script>
