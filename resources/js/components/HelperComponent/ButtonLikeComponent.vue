<template>
  <li>
    <i
      class="fa fa-heart-o fa-2x"
      aria-hidden="true"
      v-if="!isLike"
      v-on:click="sendLike"
    ></i>
    <i
      class="fa fa-heart fa-2x __isLike"
      aria-hidden="true"
      v-else
      v-on:click="removeLike"
    ></i>
    <p>
      <small>{{ jumlahLike }} menyukai...</small>
    </p>
  </li>
</template>
<script>
import APIHelper from "../../APIHelper.js";
export default {
  props: ["detail_", "likes"],
  data() {
    return {
      isLike: false,
      gw: JSON.parse(sessionStorage.getItem("__user")),
      jumlahLike: this.likes ? this.likes.length : 0,
      detail: { id: "" },
    };
  },

  mounted() {
    if (this.likes) {
      this.likes.map((item) => {
        if (item.user_id === this.gw.id) {
          this.isLike = true;
        }
      });
    }
  },
  watch: {
    detail_(data) {
      this.detail = data;
    },
    likes(data) {
      this.jumlahLike = data.length;
      this.likes = data;
      this.likes.map((item) => {
        if (item.user_id === this.gw.id) {
          this.isLike = true;
        }
      });
    },
  },
  methods: {
    sendLike() {
      axios
        .post(
          `/api/postingan/${
            this.detail_.id ? this.detail_.id : this.detail.id
          }/like`,
          {
            idGw: this.gw.id,
          },
          {
            headers: {
              API_KEY: this.gw.api_token,
            },
          }
        )
        .then((response) => {
          if (response.status === 200) {
            this.isLike = true;
            this.jumlahLike = this.jumlahLike + 1;

            this.$toast.open({
              duration: 3000,
              dismisable: true,
              message: response.data.pesan + " " + response.data.user,
              type: "success",
            });
          }
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    removeLike() {
      axios
        .post(
          `/api/postingan/${
            this.detail_.id ? this.detail_.id : this.detail.id
          }/dislike`,
          {
            idGw: this.gw.id,
          },
          {
            headers: {
              API_KEY: this.gw.api_token,
            },
          }
        )
        .then((response) => {
          if (response.status === 200) {
            this.isLike = false;
            this.jumlahLike = this.jumlahLike - 1;
            this.$toast.open({
              duration: 3000,
              dismisable: true,
              message: response.data.pesan + "😢 " + response.data.user.name,
              type: "warning",
            });
          }
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.__isLike {
  color: red;
}
</style>