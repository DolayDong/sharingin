<template>
  <div class="__form__comment">
    <form v-on:submit.prevent="kirimKomentar($event)">
      <textarea name="body" id="commentar" cols="40" rows="3" v-model="komentar"></textarea>
      <button type="submit">
        <i class="fa fa-paper-plane-o fa-lg" aria-hidden="true"></i>
      </button>
    </form>
  </div>
</template>
<script>
export default {
  props: ["postId"],
  data() {
    return {
      dataGw: JSON.parse(sessionStorage.getItem("__user")),
      komentar: null
    };
  },
  methods: {
    kirimKomentar(event) {
      const data = new FormData(event.target);
      data.append("user_id", this.dataGw.id);
      axios
        .post(`/api/postingan/${this.postId}/komentari`, data, {
          headers: {
            Authorization: "Bearer " + this.dataGw.api_token,
          },
        })
        .then((response) => {
          this.$parent.$data.komentars = [
            ...this.$parent.$data.komentars,
            { ...response.data },
          ];
          this.komentar = null;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.__form__comment {
  margin-top: 5px;
}
.__form__comment button {
  width: 5%;
  height: 4%;
  padding: 10px;
  margin: 0 auto;
  position: absolute;
  background-color: #fcba03;
  margin: auto 7px;
  border-radius: 5px;
}

.__form__comment textarea {
  width: 80%;
  border: 2px solid #fcba03;
  font-family: "Kalam";
  font-size: 18px;
}
</style>