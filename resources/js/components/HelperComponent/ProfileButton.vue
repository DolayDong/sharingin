<template>
    <button class="tombol" v-on:click.prevent="profile">
        <h3>lihat profile</h3>
    </button>
</template>
<script>
export default {
    props: ["name"],
    methods: {
        profile(){
            this.$router.push("/user/" + this.name);
        }
    }
    
};
</script>
