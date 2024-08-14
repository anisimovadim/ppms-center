<template>

        <div class="item" :style="getStyle()" :class="style.classes">
            <span v-if="element.type==='txt'">{{element.value}}</span>
            <img v-if="element.type==='img'" :src="element.value" alt="">
        </div>

</template>

<script>
export default {
    name: "BlockNew",
    props:{
        style:{
            type:Object,
            required:true
        },
        element:{
            type:Object,
            required:true
        }
    },
    methods:{
        getStyle(){
            return{
                top: this.style.top + 'px',
                left: this.style.left + 'px',
                width: this.style.width + 'px',
                fontSize: this.style.size + 'px',
            }
        }
    }

}
</script>

<style scoped>
.item{
    position: absolute;
}
img{
    width: 100%;
}
</style>
