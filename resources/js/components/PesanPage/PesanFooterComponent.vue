<template>
  <div class="container__form">
    <textarea
      v-model="pesan"
      @keydown.prevent.enter="kirimPesan"
      placeholder="ketikkan pesan anda..."
    ></textarea>
  </div>
</template>
<script>
export default {
  data() {
    return {
      pesan: "",
    };
  },
  methods: {
    kirimPesan() {
      if (this.pesan === "") {
        return;
      }

      this.$emit("kirim", this.pesan);
      this.pesan = "";
    },
  },
};
</script>

<style scoped>
.container__form textarea {
  resize: none;
  width: 97%;
  height: 50px;
  border-radius: 5px;
  padding: 2px;
  outline: none;
  font-size: 15px;
}
</style>