<template>
    <div class="container">
        <form id="__form_post__video" enctype="multipart/form-data" v-on:submit.prevent="postVideo">
            <ul>
                <li v-show="sebelumMilihVideo">
                    <input type="hidden" name="__type" value="video">

                    <input
                    v-on:keyup="validasiText"
                    autocomplete="off"
                        v-model="captionVideo"
                        name="caption-video"
                        id="caption-video"
                        placeholder="ketikkan pisuhan anda disini.."
                        class="caption__video"
                    />
                </li>
                <li v-show="sebelumMilihVideo">
                    <emoji-component v-on:addEmoji="insertInput"/>
                </li>
                <li>
                    <label for="video-post">
                        <i
                            class="fa fa-video-camera fa-2x __icon_pilih_video"
                            aria-hidden="true"
                        ></i>
                    </label>
                    <input
                        accept=".mp4, .mpeg"
                        type="file"
                        name="video-post"
                        id="video-post"
                        class="video__post"
                        v-on:change="validasiVideo($event)"
                    />
                </li>
                <li v-show="sebelumMilihVideo">
                    <button class="__btn_kirim_post__video" :disabled="disabledAddVideo">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    </button>
                </li>
            </ul>
        </form>
                    <div class="loading" v-show="loading"></div>

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
            sebelumMilihVideo: false,
            loading: false,
            captionVideo: '',
            tmpVideo: undefined,
            disabledAddVideo: true,
            form: undefined
        }
    },
    methods: {
        validasiVideo(event){
            this.loading = true;
            const form = document.querySelector("#__form_post__video");
            this.form = form;
            let data = new FormData(form);
            data.append("video", "true");

            axios.post("/api/validasi_file_",data, {
                headers: {
                    "Content-Type": "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
                }
            }).then(response => {
                this.loading = false;
                 if(response.status === 200){
                     this.sebelumMilihVideo = true;
                    this.$emit("previewVideo", {preview: true, url: response.data.url});
                    this.tmpVideo = response.data.url;
                    console.log(this.tmpVideo);
                }
            }).catch(function(error) {
                    if(error.response.status === 400){
                    alert("harap mp4 / mpeg file image saja!");
                    document.querySelector("#__form_post__video").reset();
                }
            })
        },
        insertInput(emoji){
            this.captionVideo += String.fromCodePoint(emoji);
        },
        validasiText(){
            if(this.captionVideo.trim() === ''){
                this.disabledAddVideo = true;
            } else {
                this.disabledAddVideo = false;
            }
        },
        postVideo(){
            const data = new FormData(this.form);
            data.append("temp_video", this.tmpVideo);
            data.append("user_id", JSON.parse(this.$parent.$parent.$parent.dataUser).id);
            axios.post("/api/post_image_", data, {
                headers: {
                    "Content-Type": "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2)
                }
            }).then((response) => {
                this.form.reset();
                this.$emit("previewVideo", {preview: false, url: undefined});


            }).catch(function(error){
                console.log(error.response);
            })
        }
    }
};
</script>

<style scoped>
#__form_post__video ul {
    display: flex;
    align-items: center;
    justify-content: space-around;
}
#__form_post__video .video__post {
    display: none;
}
#__form_post__video .__icon_pilih_video {
    padding: 5px;
}
#__form_post__video ul li:last-child button.__btn_kirim_post__video {
    padding: 50% 100%;
    color: #ffc116;
    border: 1px solid #ffc116;
    border-radius: 5px;
}
#__form_post__video .caption__video {
    width: 500px;
    height: 20px;
    padding: 7px;
    outline: none;
    font-size: 16px;
}

#__form_post__gambar ul li:last-child button.__btn_kirim_post__video:hover {
    background-color: #ffc116;
    color: #ff8c08d3;
    cursor: pointer;
    border: 1px solid white;
}
</style>
