<template>
<div>
     <button class="add-teman __btn__add__teman" v-on:click.prevent.stop="addTeman" v-if="!isFriend">
        <i class="fa fa-user-plus" aria-hidden="true"></i>
    </button>
    <button class="add-teman __btn__add__teman" v-else v-on:click.prevent="hapusTeman">
        <i class="fa fa-user-times __remove__teman" aria-hidden="true"></i>
    </button>
</div>
  
</template>
<script>
export default {
    props: ["userId", "myData", "berteman"],
    data(){
        return {
            isFriend: this.berteman,
        }
    },
    mounted(){
        if(this.isFriend === null){
            this.isFriend = false;
        } 
   
    },
    methods: {
        addTeman(){
            console.log(this.isFriend);
            const data = {
                userId: this.userId,
                myId: this.myData.id
            }
            console.log(this.userId);

            axios.post(`/api/user/${this.userId}/addTeman`, data, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector("meta[name=csrf-token]").getAttribute("content"),
                    'Authorization': 'Bearer ' + this.myData.api_token
                }
            }).then(response => {
                if(response.status === 200){
                    this.$toast.open({
                        message: response.data.teman + " Sekarang berteman dengan anda",
                        type: 'success',
                        duration: 5000,
                        dismisable: true
                    });
                    this.isFriend = true;
                }
                console.log(response);
            }).catch((error)  => {
                
            })
        },
        hapusTeman(){
            console.log(this.isFriend);
            const data = {
                userId: this.userId,
                myId: this.myData.id
            }
            console.log(this.userId);

            axios.post(`/api/user/${this.userId}/hapusTeman`, data, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector("meta[name=csrf-token]").getAttribute("content"),
                    'Authorization': 'Bearer ' + this.myData.api_token
                }
            }).then(response => {
                if(response.status === 200){
                    this.$toast.open({
                        message: response.data.pesan + " " + response.data.teman.name,
                        type: 'warning',
                        duration: 5000,
                        dismisable: true
                    });
                    this.isFriend = false;
                }
                console.log(response);
            }).catch((error)  => {
                
            })
        }
    }
    
}
</script>

<style scoped>
    i.__remove__teman {
        color: red;
    }
</style>