<template>
  <div>
    <button class="tombol" v-if="!isFriend" 
        v-on:click.prevent="addTeman"
    >
      <i
        class="fa fa-user-plus fa-2x"
        aria-hidden="true"
      ></i>
    </button>
    <button class="tombol" v-else>
      <i
        class="fa fa-user-plus fa-2x hapus__teman"
        aria-hidden="true"
        v-on:click.prevent="hapusTeman"
      ></i>
    </button>
  </div>
</template>
<script>
export default {
  props: {
    berteman: {
      type: Boolean,
    },
    userId: {
      type: Number,
    },
  },
  mounted() {
    if (this.isFriend === null) {
      this.isFriend = false;
    }
  },
  data() {
    return {
      myData: JSON.parse(sessionStorage.getItem("__user")),
      isFriend: this.berteman,
    };
  },
  methods: {
    addTeman() {
      console.log(this.isFriend);
      const data = {
        userId: this.userId,
        myId: this.myData.id,
      };
      console.log(this.userId);

      axios
        .post(`/api/user/${this.userId}/addTeman`, data, {
          headers: {
            "X-CSRF-TOKEN": document
              .querySelector("meta[name=csrf-token]")
              .getAttribute("content"),
            Authorization: "Bearer " + this.myData.api_token,
          },
        })
        .then((response) => {
          if (response.status === 200) {
            this.$toast.open({
              message: response.data.teman + " Sekarang berteman dengan anda",
              type: "success",
              duration: 5000,
              dismisable: true,
            });
            this.isFriend = true;
          }
          console.log(response);
        })
        .catch((error) => {});
    },
  },
};
</script>

<style scoped>
.hapus__teman {
  color: red;
}
</style>