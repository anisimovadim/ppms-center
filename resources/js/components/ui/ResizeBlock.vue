<template>
    <label :for="`item${index}`">
        <div class="block"
             @mousemove="resize"
             @mouseup="stopResize">
            <editor-font v-if="select === index && typeElement==='txt'" :classes="classes" @set-text-style="setStyleText" @set-align-text="setAlignText">
                <input type="number" :value="sizeElement" @input="updateSizeElement" class="form-control">
            </editor-font>
            <div class="border-resize" v-if="select===index"></div>
            <slot></slot>
            <div class="size-info" v-if="select===index">{{listWidthHeight.width}} x {{listWidthHeight.height}}</div>
        </div>
        <div
            v-if="select === index"
            v-for="(position, handle) in handles"
            :key="handle"
            :class="['circle', position]"
            @mousedown="startResize($event,index, position)"
        ></div>
    </label>
</template>

<script>
import EditorFont from "@/components/ui/EditorFont.vue";
import MyInput from "@/components/ui/MyInput.vue";

export default {
    name: "ResizeBlock",
    components: {MyInput, EditorFont},
    props:{
        select:{
            type:Number || '',
            required:true,
        },
        index:{
            type:Number,
            required:true,
        },
        listWidthHeight:{
            type:Object,
            required:true
        },
        typeElement:{
            type:String,
            required:true
        },
        sizeElement:{
            type:[Number, String],
            required: true
        },
        classes:{
            type:Array
        }
    },
    data(){
        return{
            resizingHandle: null,
            handles: ["nw", "ne", "sw", "se"],
            initialX: 0,
            initialY: 0,
        }
    },
    methods:{
        startResize(event,index, position) {
            this.resizingHandle = position;
            this.initialX = event.clientX;
            this.initialY = event.clientY;
            this.$emit('startResize', event, index, position);
        },
        resize(event) {
            if (this.resizingHandle) {
                const deltaX = event.clientX - this.initialX;
                const deltaY = event.clientY - this.initialY;
                this.initialX = event.clientX;
                this.initialY = event.clientY;
                this.$emit('resize', deltaX, deltaY);
            }
        },
        stopResize() {
            if (this.resizingHandle) {
                this.resizingHandle = null;
                this.$emit('stopResize');
            }
        },
        updateSizeElement(event) {
            this.$emit('update:size-element', event.target.value);
        },
        setStyleText(value){
            this.$emit('set-text-style', value)
        },
        setAlignText(value){
            this.$emit('set-align-text', value)
        }
    }
}
</script>

<style scoped>
.circle {
    position: absolute;
    width: 7px;
    height: 7px;
    outline:  #3C87AF 2px solid;
    /*border:;*/
    background-color: white;
    z-index: 999;
}
.nw {
    top: -3px;
    left: -3px;
    cursor: nw-resize;
}
.ne{
    top: -3px;
    right: -3px;
    cursor: ne-resize;
}
.sw{
    bottom: -3px; left: -3px; cursor: sw-resize;
}
.se{
    bottom: -3px;
    right: -3px;
    cursor: se-resize;
}
.border-resize{
    position: absolute;
    /*border: rgba(8, 148, 53, 0.55) 2px solid;*/
    outline:  #3C87AF 2px solid;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    transition: all .5s;
    z-index: 0;
}
.size-info{
    position: absolute;
    width: 100px;
    left: 50%;
    font-size: 13px;
    background-color: #3C87AF;
    text-align: center;
    bottom: -25px;
    border-radius: 5px;
    transform: translate(-50%);
    color: white;
}
.form-control{
    border-radius: 0;
}
input{
    width: 70px;
    padding: 5px;
    height: 20px;
}

</style>
