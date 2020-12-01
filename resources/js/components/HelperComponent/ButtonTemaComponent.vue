<template>
    <div class="__fab container">
        <i class="fa fa-lightbulb-o fa-3x __icon__tema light" aria-hidden="true" v-show="isLight" v-on:click="light"></i>
        <i class="fa fa-adjust fa-3x __icon__tema dark" aria-hidden="true" v-show="isDark" v-on:click="dark"></i>
    </div>
</template>
<script>
export default {
    data(){
        return{
            isLight: false,
            isDark: true,
            darkTema: {
                color: 'black',
            }
        }
    },
    mounted(){
        console.log("tema mounted");
        console.log(this.$parent);
    },
    methods: {
        light(event){
            console.log(event);
            this.isDark = !this.isDark;
            
            this.isLight = !this.isLight;
        },
        dark(event){

            if(!sessionStorage.getItem("dark")){
            this.isDark = !this.isDark;
            this.isLight = !this.isLight;
            document.body.style.backgroundColor = 'rgb(95, 55, 17)';
            if(document.body.querySelector("#app").querySelectorAll("p") !== null ){
                document.body.querySelector("#app").querySelectorAll("p").forEach(element => {
                   if(element !== null){
                       element.style.color = "#fcba03";
                   }
                })
            }

            if(document.querySelector(".postingan-text p") !== null){
                document.querySelector(".postingan-text p").style.color = "#fcba03";
            }
            if(document.querySelector(".container.cotent-home") !== null){
                document.querySelector(".container.cotent-home").querySelectorAll("i").forEach(element => {
                    element.style.color = "#fcba03";
                })
            }

            if(document.querySelector(".header-postingan h3") !== null){
                document.querySelector(".header-postingan h3").style.color = "#fcba03";

            }

            if(document.querySelector(".form-cari input[type=text]") !== null){
                document.querySelector(".form-cari input[type=text]").classList.add("dark__tema");

            }
            sessionStorage.setItem("dark", true);
            if(sessionStorage.getItem("light")){
                sessionStorage.removeItem("light");
            }
            }
            
        }
    }
}
</script>

<style>
    .__fab {
    position: fixed;
    left: 10px;
    bottom: 10px;
    max-width: 70px;
    max-height: 70px;
    background-color: #666;
    border-radius: 50%;
    box-shadow: -2px 2px 6px rgba(0, 0, 0, .4);
    border: 1px solid;
    border-color: rgba(0,0,0,.3);
    }
    .__icon__tema {
    position: relative;
    left: -20%;
    }
    .light {
        color: white;
        }
    .dark {
        color: rgb(95, 55, 17);
    }
</style>