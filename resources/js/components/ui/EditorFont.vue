<template>
    <div class="editor-font">
        <div class="d-flex align-items-center gap-2">
            <div class="icon" data-bs-toggle="dropdown" aria-expanded="false">
                <img v-if="classes.includes('text-left')" draggable="false" :src="'/images/text-left.svg'" alt="">
                <img class="white" v-if="classes.includes('text-center')" draggable="false" :src="'/images/text-center.svg'" alt="">
                <img class="white" v-if="classes.includes('text-right')" draggable="false" :src="'/images/text-right.svg'" alt="">
            </div>
            <ul class="dropdown-menu">
                <li class="d-flex dropdown-item justify-content-between">
                    <div class="text-align" :class="classes.includes('text-left') && 'select'" @click="$emit('set-align-text', 'text-left')"><img class="black" draggable="false" :src="'/images/text-left.svg'" alt=""></div>
                    <div class="text-align" :class="classes.includes('text-center') && 'select'" @click="$emit('set-align-text', 'text-center')"><img draggable="false" :src="'/images/text-center.svg'" alt=""></div>
                    <div class="text-align" :class="classes.includes('text-right') && 'select'" @click="$emit('set-align-text', 'text-right')"><img draggable="false" :src="'/images/text-right.svg'" alt=""></div>
                </li>
            </ul>
            <div class="size">
                <slot></slot>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <div class="icon" @click="$emit('set-text-style', 'bolder-text')">
                <img :src="'/images/type-bold.svg'" alt="">
            </div>
            <div class="icon" @click="$emit('set-text-style', 'italic-text')">
                <img :src="'/images/type-italic.svg'" alt="">
            </div>
        </div>
    </div>
</template>

<script>
import MyInput from "@/components/ui/MyInput.vue";

export default {
    name: "EditorFont",
    components: {MyInput},
    props:{
        classes:{
            type:Array
        }
    }
}
</script>

<style scoped>
.editor-font{
    position: absolute;
    width: 200px;
    height: 40px;
    background-color: #3C87AF;
    top: -50px;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.icon{
    width: 25px;
    height: 25px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
.icon img{
    height: 100%;
}
.dropdown-item img.black{
    filter: invert(100%) sepia(100%) saturate(100%) hue-rotate(100deg) brightness(100%) contrast(100%);
}
.white{
    filter: invert(100%) sepia(100%) saturate(100%) hue-rotate(100deg) brightness(100%) contrast(100%);
}
.text-align{
    cursor: pointer;
    width: 20px;
}
.select{
    background-color: rgba(60, 135, 175, 0.24);
}
.text-align img{
    width: 100%;
}
.dropdown-item:hover{
    background: none;
}
</style>
