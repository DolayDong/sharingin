<template>
    <div class="container cotent-home">
        <profile-card :data-user="dataUser"/>
        <postingan-component :data-user="dataUser" />
        <users-sugestion :data-user="dataUser"/>
    </div>
</template>
<script>
import PostinganComponent from "./PostinganComponent.vue";
import ProfileCard from "./ProfileCard.vue";
import UsersSugestion from "./UsersSugestion.vue";

export default {
    components: { PostinganComponent, ProfileCard, UsersSugestion },
    props: ["dataUser"],
    mounted() {
    }
};
</script>
