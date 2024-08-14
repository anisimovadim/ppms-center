<template>
    <div class="panel d-flex position-relative">
        <plus-btn data-bs-toggle="dropdown" aria-expanded="false"></plus-btn>
        <div class="d-flex gap-4 flex-grow-1 justify-content-center align-items-center">
            <div @click="$emit('onSelectDevice', 'mobile')" class="device" :class="selectDevice==='mobile' && 'select'">
                <img :src="'/images/mobile.svg'" alt="">
            </div>
            <div @click="$emit('onSelectDevice', 'tablet')" class="device" :class="selectDevice==='tablet' && 'select'">
                <img :src="'/images/table.svg'" alt="">
            </div>
            <div @click="$emit('onSelectDevice', 'desktop')" class="device" :class="selectDevice==='desktop' && 'select'">
                <img :src="'/images/desktop.svg'" alt="">
            </div>
        </div>
        <div class="d-flex gap-2" style="position: absolute; right: 50px;">
            <my-button-grey data-bs-toggle="modal" data-bs-target="#editBlockModal" v-if="selectItem>=0 && typeItem==='img'">Изменить</my-button-grey>
            <my-button data-bs-toggle="modal" data-bs-target="#saveModal">Сохранить</my-button>
        </div>
        <ul class="dropdown-menu">
            <li @click="$emit('addElement', 'img')"><p class="dropdown-item">Добавить изображение</p></li>
            <li @click="$emit('addElement', 'txt')"><p class="dropdown-item">Добавить текст</p></li>
        </ul>

    </div>
</template>

<script>
import MyButton from "@/components/ui/MyButton.vue";
import PlusBtn from "@/components/ui/PlusBtn.vue";
import MyButtonGrey from "@/components/ui/MyButtonGrey.vue";

export default {
    name: "MainPanel",
    components: {MyButtonGrey, PlusBtn, MyButton},
    props:{
        selectItem:{
            type: Number,
            required:true
        },
        selectDevice:{
            type: String,
            required: true
        },
        typeItem:{
            type: String,
        }
    }
}
</script>

<style scoped>
.panel{
    background-color: #F1F4F5;
    height: 74px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 50px;
    border-bottom: 10px solid #3C87AF;
}
p{
    cursor: pointer;
}
button{
    max-width: 100px;
}
.device{
    cursor: pointer;
    padding: 10px;
    border-radius: 5px;
}
.select{
    background: rgba(60, 135, 175, 0.16);
}
</style>
