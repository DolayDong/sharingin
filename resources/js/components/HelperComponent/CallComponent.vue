<template>
<div class="container">
        <li class="vc__icon" v-show="teman" @click="call">
      <i class="fa fa-phone fa-2x" aria-hidden="true"></i>
    </li>
    <!-- The Modal -->
    <div id="myModal" class="modal__comp__" v-show="tampil">
      <!-- Modal content -->
      <div class="modal__cont__">
        <div class="__body__modal">
          <div class="container__video">
            <audio class="audio__gw" ref="audio__gw"></audio>
            <audio
              class="audio__teman"
              ref="audio__teman"
            ></audio>
          </div>
        </div>
        <div class="__modal__footer">
          <div class="container__button__call">
           footer
          </div>
        </div>
      </div>
    </div>
</div>
    
</template>
<script>
export default {
    props: {
        teman: {
            type: Object,
            default: null
        }
    },
    data(){
        return {
            tampil: false
        }
    },
    methods: {
        call(){

        }
    }
    
}
</script>
<style scoped>
.vc__icon {
    list-style: none;
    color: #fc4803a8;
}
</style>