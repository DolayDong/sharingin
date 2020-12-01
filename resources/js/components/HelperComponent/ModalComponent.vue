<template>

<div>
    <button class="tombol" @click="tampil = !tampil"><i class="fa fa-plus" aria-hidden="true"><slot name="__judul"/></i></button>

    <!-- The Modal -->
    <div id="myModal" class="modal__comp__" v-show="tampil">
        <!-- Modal content -->
        <div class="modal__cont__">
            <div class="__modal__header">
                <span class="__tutup_modal" v-on:click="closeModal">&times;</span>
                <slot name="__title" />
            </div>
            <div class="__body__modal">
                <slot name="__body"/>
            </div>
            <div class="__modal__footer">
                <slot name="__footer"/>
            </div>
        </div>
</div>
    </div>
</template>
<script>
export default {
    mounted(){
            console.log(this.$children.captionProperti);

    },
    data(){
        return {
            tampil: false
        }
    },
    methods: {
        open(){
            this.tampil = true;
        },
        closeModal(){
            this.tampil = !this.tampil
            this.$children.forEach(children => {
                children.$el.querySelector("form").reset();
            })
            this.$children[0].captionProperti = undefined;
            this.$children[0].sebelumMilihVideo = undefined;
            this.$el.querySelector("img").src = '';
            this.$el.querySelector("video").src = '';
            this.$parent.isPreviewGambar = false;
            this.$parent.isPreviewVideo = false;

            
        }
    }
};
</script>
<style scoped>
.modal__comp__ {
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.3);
}

.modal__cont__ {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    width: 50%;
    border-radius: 15px 15px 0 0;
    border: 1px solid #888;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    -webkit-animation-name: __animasiatas;
    -webkit-animation-duration: 0.7s;
    animation-name: __animasiatas;
    animation-duration: 0.7s;
}

@-webkit-keyframes __animasiatas {
    from {
        transition: all 0.5s;
        opacity: 0;
    }
    to {
        transform: matrix(2);
        opacity: 1;
    }
}

@keyframes __animasiatas {
    from {
        opacity: 0;
    }
    to {
        transform: matrix(2);
        opacity: 1;
    }
}

.__tutup_modal {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.__tutup_modal:hover,
.__tutup_modal:focus {
    color: red;
    text-decoration: none;
    cursor: pointer;
}

.__modal__header {
    border-radius: 15px 15px 0 0;
    padding: 2px 16px;
    background-color: rgba(233, 142, 38, 0.7);
    color: white;
}

.__body__modal {
    padding: 2px 16px;
}

.__modal__footer {
    padding: 2px 16px;
    background-color: rgb(233, 142, 38);
    color: rgba(255, 255, 255, 0.5);
}
</style>
