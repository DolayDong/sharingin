<template>
  <div class="contact__list">
    <ul>
      <li
        v-for="(data, index) in datas"
        :key="data.teman.id"
        @click="contactDipilih(index, data)"
        :class="{ dipilih: index === dipilih }"
      >
        <div class="image__profile">
          <img :src="data.teman.data && data.teman.data.photo_profile" :alt="data.teman.email" />
          <!-- {{data.teman.data.photo_profile}} -->
        </div>
        <div class="data_teman">
          <p class="nama__teman__contact">{{ data.teman.name }}</p>
          <p class="email__teman__contact">{{ data.teman.email }}</p>
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  props: {
    temans: {
      type: Array,
      default: [],
    },
  },
  mounted() {
    console.log("contact component mounted");
    console.log(this.temans)
  },
  data() {
    return {
      dipilih: 0,
      datas: [{teman: {data: {photo_profile: ''}}}],
    };
  },
  watch: {
    immediate: true,
    deep: true,
    temans: async function(databaru, datalama) {
      console.log(datalama);
      this.datas = databaru;
    },
  },
  methods: {
    contactDipilih(index, teman) {
      this.dipilih = index;
      this.$emit("dipilih", teman);
    },
  },
};
</script>

<style scoped>
.contact__list {
  overflow: auto;
  padding: 10px;
  background-color: rgb(241, 236, 236);
  min-width: fit-content;
}
.contact__list ul li img {
  width: 70px;
  border-radius: 50%;
  border-radius: 1px solid white;
}
.contact__list ul li {
  border-bottom: 1px solid rgb(66, 66, 66);
  list-style-type: none;
  display: flex;
  margin: auto 10px;
  padding: 10px;
}

.contact__list ul li:hover {
  cursor: pointer;
}
.contact__list {
  flex: 2;
}

.data_teman {
  padding-top: 20px;
  padding-left: 10px;
}
p.nama__teman__contact {
  font-weight: bolder;
  font-size: 20px;
}

li.dipilih {
  background-color: white;
}
</style>