<template>
    <div class="container">
        <form id="__form_post__gambar" enctype="multipart/form-data">
            <ul>
                <li v-show="captionProperti">
                    <input type="hidden" name="__type" value="foto">
                    <input
                        name="caption-gambar"
                        id="caption-gambar"
                        placeholder="sharingin aja ke temen dekat sekarang..."
                        class="caption__foto"
                        v-model="captionText"
                        autocomplete="off"
                        v-on:keyup="validasiText"
                    />
                </li>
                <li v-show="captionProperti">
                    <emoji-component v-on:addEmoji="insertInput"/>
                </li>
                <li>
                    <label for="gambar-post">
                        <i
                            class="fa fa-picture-o fa-2x __icon__add_foto"
                            aria-hidden="true"
                        ></i>
                    </label>
                    <input
                    accept=".jpg, .jpeg, .png"
                        type="file"
                        name="gambar-post"
                        id="gambar-post"
                        class="image__post"
                        v-on:change="imageProcess($event)"
                    />
                </li>
                <li v-show="captionProperti">
                    <button class="__btn_kirim_post" :disabled="disabledBtnAddFoto" v-on:click.prevent="postFoto">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    </button>
                </li>
            </ul>
        </form>
    </div>
</template>
<script>
import EmojiComponent from './EmojiComponent.vue';
export default {
  components: { EmojiComponent },
  mounted(){
  },
    data(){
        return {
            tmpImage: undefined,
            captionText: '',
            captionProperti: false,
            disabledBtnAddFoto: true,
            form: undefined
        }
    },
    methods: {
        imageProcess(event){
            this.form = document.querySelector("#__form_post__gambar");

            this.captionProperti = true;
            const file = event.target.files[0];
            const dataForm = new FormData(this.form);
            dataForm.append("gambar", "true");
            axios.post("/api/validasi_file_",dataForm, {
                headers: {
                    "Content-Type": "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
                    }
            }).then((response) => {
                if(response.status === 200){
                    this.$emit("previewGambar", {preview: true, url: response.data.url});
                    this.tmpImage = response.data.url;
                }
            }).catch(function(error){
                if(error.response.status === 400){
                    alert("harap memilih file image saja!");
                    document.querySelector("#__form_post__gambar").reset();
                }
            })
        },
        insertInput(emoji){
            this.captionText += String.fromCodePoint(emoji);
        },
        postFoto(){
            const data = new FormData(this.form);
            data.append("temp_image", this.tmpImage);
            data.append("user_id", JSON.parse(this.$parent.$parent.$parent.dataUser).id);
            axios.post("/api/post_image_", data, {
                headers: {
                    "Content-Type": "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
                }
            }).then((response) => {
                this.form.reset();
                this.$emit("previewGambar", {preview: false, url: undefined});
                this.$emit("openModal", false);


            }).catch(function(error){
                console.log(error.response);
            })

        },
        validasiText(){
            if(this.captionText.trim() === ''){
                this.disabledBtnAddFoto = true;
            } else {
                this.disabledBtnAddFoto = false;
            }
        }
    }
};
</script>

<style scoped>
#__form_post__gambar ul {
    display: flex;
    align-items: center;
    justify-content: space-around;
}

#__form_post__gambar ul li .caption__foto {
    width: 400px;
    height: 20px;
    padding: 7px;
    outline: none;
    font-size: 16px;
}

#__form_post__gambar ul li .image__post {
    display: none;
}

.__icon__add_foto {
    padding: 5px;
}

#__form_post__gambar ul li:last-child button.__btn_kirim_post {
    padding: 50% 100%;
    color: #ffc116;
    border: 1px solid #ffc116;
    border-radius: 5px;
}

#__form_post__gambar ul li:last-child button.__btn_kirim_post:hover {
    background-color: #ffc116;
    color: #ff8c08d3;
    cursor: pointer;
    border: 1px solid white;

}
</style>
