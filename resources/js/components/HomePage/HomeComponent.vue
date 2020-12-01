<template>
    <div class="app">
    <header-component />
    <router-view :data-user="dataUser"/>
    </div>
</template>
<script>
import HeaderComponent from './HeaderComponent.vue';

export default {
  components: { HeaderComponent },
  props: ["dataUser"],
    mounted() {
  
    }
};
</script>
