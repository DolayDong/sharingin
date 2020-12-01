<template>
    <div>
        <strong v-on:click.prevent="showEmoji = !showEmoji" class="__emoji"
            >&#128512;</strong
        >

        <div class="popup__emoji" v-show="showEmoji">
            <div class="content__emoji">
                <span class="__emoji__item" v-for="emoji in emojis" v-bind:key="emoji" v-on:click="addToInput(emoji)">{{String.fromCodePoint(emoji)}}</span>
                <span class="__close_emoji" v-on:click="showEmoji = !showEmoji">X</span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {},
    data() {
        return {
            emojiitem: '',
            showEmoji: false,
            emojis : [
                0x1F600, 0x1F601, 0x1F602,
                0x1F603, 0x1F604, 0x1F605,
                0x1F606, 0x1F607, 0x1F608, 
                0x1F609, 0x1F60A, 0x1F60B, 
                0x1F60C, 0x1F60D, 0x1F60E, 
                0x1F60F, 0x1F610, 0x1F611, 
                0x1F612, 0x1F613, 0x1F614, 
                0x1F615, 0x1F616, 0x1F617, 
                0x1F618, 0x1F619, 0x1F61A, 
                0x1F61B, 0x1F61C, 0x1F61D, 
                0x1F61E, 0x1F61F, 0x1F620,
                0x1F621, 0x1F622, 0x1F623, 
                0x1F624, 0x1F625, 0x1F626, 
                0x1F627, 0x1F628, 0x1F629, 
                0x1F62A, 0x1F62B, 0x1F62C, 
                0x1F62D, 0x1F62E, 0x1F62F, 
                0x1F630, 0x1F631, 0x1F632, 
                0x1F633, 0x1F634, 0x1F635, 
                0x1F636, 0x1F637, 0x1F641, 
                0x1F642, 0x1F643, 0x1F644, 
                0x1F910, 0x1F911, 0x1F912, 
                0x1F913, 0x1F914, 0x1F915, 
                0x1F920, 0x1F921, 0x1F922, 
                0x1F923, 0x1F924, 0x1F925, 
                0x1F927, 0x1F928, 0x1F929, 
                0x1F92A, 0x1F92B, 0x1F92C, 
                0x1F92D, 0x1F92E, 0x1F92F,	 
                0x1F9D0	 
                ]
        };
    },
    methods: {
        addToInput(emoji){
           this.$emit('addEmoji', emoji);
        }
    }
};
</script>

<style scoped>
.__emoji {
    font-size: 24px;
    cursor: pointer;
    padding-left: 5px;
}
.__emoji__item {
    font-size: 24px;
    border: 1px solid white;
    text-align: center;
    margin: 2px auto;

}
.__emoji__item:hover {
    cursor: pointer;
    border: 1px solid rgb(73, 73, 73);
}
.content__emoji {
    background-color: rgb(211, 211, 211);
    box-shadow: -1px 1px 2px black;
    padding: 10px;
}

.popup__emoji {
    position: absolute;
    width: 100%;
    background-color: white;
    left: 1px;
    max-height: 200px;
    border-radius: 5px;
    border: 1px solid rgb(122, 122, 122);
    display: flex;
    flex-wrap: wrap;
}

.__close_emoji {
    padding-right: 5px;
    padding-left: 5px;
    position: absolute;
    right: 4px;
    bottom: -10px;
    color: red;
    font-size: 18px;
    font-weight: bolder;
}

.__close_emoji:hover {
    border: 1px solid red;
    color: rgb(240, 240, 240);
    cursor: pointer;
}
</style>
