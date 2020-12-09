<template>
  <div class="container__pesan__text" ref="pesan">
    <ul v-if="teman">
      <li
        v-for="pesan in pesans"
        :class="`pesan ${pesan.user_id === teman.teman_id ? 'dari' : 'ke'}`"
        :key="pesan.id"
      >
        <div class="text__pesan">
          {{ pesan.text }}
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  props: {
    teman: {
      type: Object,
    },
    pesans: {
      type: Array,
      required: true,
    },
  },
  methods: {
    scrollinCuy() {
      setTimeout(() => {
        this.$refs.pesan.scrollTop =
          this.$refs.pesan.scrollHeight - this.$refs.pesan.clientHeight;
      }, 150);
    },
  },
  watch: {
    teman(teman) {
      this.scrollinCuy();
    },
    pesans(pesans) {
      this.scrollinCuy();
    },
  },
};
</script>

<style scoped>
.container__pesan__text {
  height: 78%;
  background-color: aliceblue;
  overflow: scroll;
}

.pesan.dari {
  background-color: rgb(255, 115, 0);
  margin: 10px 10px;
  color: white;
  border-radius: 10px 0 10px 10px;
  float: right;
  width: 70%;
}
.pesan.ke {
  border: 2px solid rgb(255, 115, 0);
  margin: 10px 10px;
  color: rgb(255, 115, 0);
  border-radius: 10px 10px 10px 0;
  width: 70%;
  float: left;
}
.text__pesan {
  padding: 10px;
}
</style>