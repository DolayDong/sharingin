<template>
  <div class="container">
    <form id="form-add-status" v-on:submit.prevent="addStatus">
      <div class="container">
        <ul>
          <li>
            <input type="hidden" name="__type" value="status" />

            <textarea
              v-on:keyup="validasiText"
              name="status"
              id="status"
              rows="5"
              class="text__status"
              placeholder="ketikkan apa yang ingin anda katakan..."
              v-model="status"
            ></textarea>
          </li>
        </ul>
      </div>
      <div class="container">
        <ul>
          <li>
            <button class="tombol__add__status" :disabled="disabled">
              <i class="fa fa-paper-plane fa-lg" aria-hidden="true"></i>
            </button>
          </li>
          <li>
            <emoji-component v-on:addEmoji="insertEmoji" />
          </li>
        </ul>
      </div>
    </form>
  </div>
</template>
<script>
import EmojiComponent from "./EmojiComponent.vue";
export default {
  components: { EmojiComponent },
  data() {
    return {
      status: "",
      disabled: true,
      dataGw: JSON.parse(sessionStorage.getItem("__user")),
    };
  },
  methods: {
    insertEmoji(emoji) {
      this.status += String.fromCodePoint(emoji);
    },
    addStatus() {
      const form = document.querySelector("#form-add-status");
      let formData = new FormData(form);
      formData.append("user_id", this.dataGw.id);

      axios
        .post("/api/post_image_", formData, {
          headers: {
            Authorization: "Bearer " + this.dataGw.api_token,
          },
        })
        .then((response) => {
          form.reset();
          this.$emit("closeModalStatus", true);
        })
        .catch(function (error) {});
    },
    validasiText() {
      if (this.status.trim() !== "") {
        this.disabled = false;
      } else {
        this.disabled = true;
      }
    },
  },
};
</script>

<style scoped>
#form-add-status .container ul {
  display: flex;
  align-items: center;
}

.text__status {
  width: 600px;
  padding: 7px;
  outline: none;
  font-size: 17px;
  border: 1px solid #ffc116;
  border-radius: 5px;
}

.tombol__add__status {
  padding: 7px;
  color: #ffc116;
  border: 1px solid #ffc116;
  border-radius: 2px;
  width: 570px;
}
</style>
