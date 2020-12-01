<template>
    <li v-on:click.prevent="detailHalamanPost">
        <i class="fa fa-comments-o fa-2x" aria-hidden="true"></i>
        <p>
            <small>12 berkomentar...</small>
        </p>
    </li>
</template>
<script>
export default {
    props: ["postId"],
    methods: {
        detailHalamanPost(){
            return this.$router.push({path: "/detail/", name: "DetailPost", params: {idPost: this.postId} });
        }
    }
};
</script>
