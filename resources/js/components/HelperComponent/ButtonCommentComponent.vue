<template>
    <li v-on:click.prevent="detailHalamanPost">
        <i class="fa fa-comments-o fa-2x" aria-hidden="true"></i>
        <p>
            <small>{{jumlahComment}} berkomentar...</small>
        </p>
    </li>
</template>
<script>
export default {
    props: {
        postId: {
            type: Number,
            default: null
        },
        jumlahComment: {
            type: Number,
            default: null
        }
    },
    methods: {
        detailHalamanPost(){
            return this.$router.push({path: "/detail/", name: "DetailPost", params: {idPost: this.postId} });
        }
    }
};
</script>
