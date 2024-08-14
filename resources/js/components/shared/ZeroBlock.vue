<script>
import ResizeBlock from "../ui/ResizeBlock.vue";
import MainPanel from "@/components/layouts/MainPanel.vue";
import ModalComponent from "@/components/ui/ModalComponent.vue";
import LoaderComponent from "@/components/ui/LoaderComponent.vue";
import api from "@/api.js";

export default {
    name: "ZeroBlock",
    components: {LoaderComponent, ModalComponent, MainPanel, ResizeBlock},
    data() {
        return {
            items: [
                {
                    element: {type: 'img', value: '/images/netfoto.png', value2: ''},
                    media_queries: [
                        {
                            title: 'desktop',
                            style: {
                                top: 50,
                                left: 100,
                                width: 200,
                                size:'',
                                classes: []
                            }
                        },
                        {
                            title: 'tablet',
                            style: {
                                top: 10,
                                left: 100,
                                width: 200,
                                size:'',
                                classes: []
                            }
                        },
                        {
                            title: 'mobile',
                            style: {
                                top: 10,
                                left: 50,
                                width: 100,
                                size:'',
                                classes: []
                            }
                        },

                    ]
                },
                {
                    element: {type: 'txt', value: 'Этот текст можно поменять!'},
                    media_queries: [
                        {
                            title: 'desktop',
                            style: {
                                top: 50,
                                left: 100,
                                width: 300,
                                size:15,
                                classes: ['text-left']
                            }
                        },
                        {
                            title: 'tablet',
                            style: {
                                top: 10,
                                left: 100,
                                width: 200,
                                size:10,
                                classes: ['text-left']
                            }
                        },
                        {
                            title: 'mobile',
                            style: {
                                top: 10,
                                left: 50,
                                width: 100,
                                size:10,
                                classes: ['text-left']
                            }
                        },

                    ]
                },
            ],
            indexDrag: '',
            indexScale: '',
            currentWidth: 0,
            currentHeight: 0,
            selectItem: -1,
            listWidthHeight: [],
            initialX: 0,
            initialY: 0,
            handle: '',
            value: '',
            selectedDevice: 'desktop',
            titleBlock: '',
            loader:false,
            saveMessage:'',
            notAuthScreen:false
        }
    },
    created() {
        document.title = 'Конструктор новости';
        if (window.innerWidth<987){
            this.notAuthScreen=true;
            setTimeout(()=>{
                this.$router.push('/');
            },2000)
        }
    },
    methods: {
        startDrag(index, event) {

            if (!event.target.classList.contains('circle')) {
                const item = this.items[index];
                this.target = event.currentTarget
                item.isDragging = true;
                this.indexDrag = index;
                this.currentWidth = this.target.offsetWidth;
                this.currentHeight = this.target.offsetHeight;
                this.selectItem = index;
                item.mouseOffsetX = event.clientX - item.media_queries.find(el => el.title === this.selectedDevice).style.left;
                item.mouseOffsetY = event.clientY - item.media_queries.find(el => el.title === this.selectedDevice).style.top;
            }
        },
        stopDrag() {
            if (this.indexDrag !== '') {
                this.items[this.indexDrag].isDragging = false;
                this.indexDrag = '';
            }
            if (this.indexScale !== '') {
                this.items[this.indexScale].isResize = false;
                this.indexScale = '';
            }
        },
        moveItem(event) {
            if (this.indexDrag !== '' && !this.items[this.indexDrag].editText) {
                if (this.items[this.indexDrag].isDragging) {
                    const item = this.items[this.indexDrag];
                    const offsetX = event.clientX - item.mouseOffsetX;
                    const offsetY = event.clientY - item.mouseOffsetY;
                    const maxX = event.currentTarget.offsetWidth - this.currentWidth;
                    const maxY = event.currentTarget.offsetHeight - this.currentHeight;
                    const x = Math.min(Math.max(0, offsetX), maxX);
                    const y = Math.min(Math.max(0, offsetY), maxY);
                    let style = item.media_queries.find(el => el.title === this.selectedDevice).style;
                    style.left = x;
                    style.top = y;
                }
            }
            if (this.indexScale !== '') {
                const deltaX = event.clientX - this.initialX;
                const item = this.items[this.indexScale];
                let style = item.media_queries.find(el => el.title === this.selectedDevice).style;
                if (this.handle.includes('n')) {
                    if (this.handle.includes('e')) {
                        if (item.element.type === 'img') {
                            style.top -= deltaX;
                        }
                        style.width += deltaX;
                    } else {
                        if (item.element.type === 'img') {
                            style.top += deltaX;
                        }
                        style.left += deltaX;
                        style.width -= deltaX;
                    }
                } else if (this.handle.includes('s')) {
                    if (this.handle.includes('e')) {
                        style.width += deltaX;
                    } else {
                        style.left += deltaX;
                        style.width -= deltaX;
                    }
                }
                if (item.element.type==='txt' && item.editText){
                    this.changeText(this.indexScale);
                }
                this.currentWidth = this.target.offsetWidth;
                this.currentHeight = this.target.offsetHeight;
                this.initialX = event.clientX;
                this.initialY = event.clientY;
            }
        },
        onBlockResizedStart(event, index, position) {
            this.items[index].isDragging = false;
            this.items[index].isResize = true;
            this.indexScale = index;
            this.initialX = event.clientX;
            this.initialY = event.clientY;
            this.handle = position;
        },
        onStopScale() {
            if (this.indexScale !== '') {
                this.items[this.indexScale].isResize = false;
                this.indexScale = ''
            }

        },
        createElement(type, value) {
            const obj = {
                element: {type, value,},
                media_queries: [
                    {
                        title: 'desktop',
                        style: {
                            top: 50,
                            left: 100,
                            width: 200,
                            size:15,
                            classes: [type==='txt' && 'text-left']
                        }
                    },
                    {
                        title: 'tablet',
                        style: {
                            top: 10,
                            left: 100,
                            width: 200,
                            size:10,
                            classes: [type==='txt' && 'text-left']
                        }
                    },
                    {
                        title: 'mobile',
                        style: {
                            top: 10,
                            left: 50,
                            width: 100,
                            size:10,
                            classes: [type==='txt' && 'text-left']
                        }
                    },

                ]

            }
            return obj
        },
        addElement(type) {
            let elem
            if (type === 'img') {
                elem = this.createElement(type, '/images/netfoto.png');
            } else {
                elem = this.createElement(type, 'Тестовый текст');
            }
            this.items.push(elem)
        },
        fileReader(event) {
            if (this.items[this.selectItem].element.type === 'img') {
                const file = event.target.files[0];
                this.items[this.selectItem].element.value2 = file;
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.value = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            }
        },
        changeElement() {
            this.items[this.selectItem].element.value = this.value;
            this.value = '';
        },
        stylesItem(item) {
            if (item && item.media_queries && item.media_queries.length > 0) {
                const style = item.media_queries.find(el => el.title === this.selectedDevice)?.style;
                if (style) {
                    return {
                        top: style.top + 'px',
                        left: style.left + 'px',
                        width: style.width + 'px',
                        fontSize: style.size + 'px'
                    };
                }
            }
            return {};
        },
        stylesBox() {
            if (this.selectedDevice === 'desktop') {
                return {maxWidth: '950px', height: '550px'}
            } else if (this.selectedDevice === 'tablet') {
                return {maxWidth: '750px', height: '400px'}
            } else {
                return {maxWidth: '300px', height: '250px'}
            }
        },
        onSelectDevice(value) {
            this.selectedDevice = value;
        },
        saveBlock() {
            this.loader=true;
            api.post('/api/auth/create/new', {items:this.items})
                .then(res=>{
                    this.loader=false;
                    this.saveMessage=res.data.message;
                })
                .catch(err=>{
                    this.loader=false;
                    this.saveMessage=err.response.data.error;
                })
        },
        changeText(index){
            const textarea = this.$refs[`text${+index}`][0];
            if (textarea){
                textarea.style.height = 'auto';
                textarea.style.height = `${textarea.scrollHeight}px`;
                this.items[index].heightText = textarea.scrollHeight
            }
        },
        editText(item, event){
            if (this.selectItem !==-1 && event.target.classList[0]==='border-resize' && item.element.type==='txt'){
                item.editText=true;
                item.heightText = this.currentHeight
            }
        },
        stopSelect(){
            if (this.selectItem !==-1){
                this.items[this.selectItem].editText=false;
                this.selectItem=-1;
            }
        },
        setTextStyle(value){
            const item = this.items[this.selectItem];
            item.media_queries.forEach(elem=>{
                const classIndex = elem.style.classes.indexOf(value);
                if (classIndex > -1) {
                    elem.style.classes.splice(classIndex, 1);
                } else {
                    elem.style.classes.push(value);
                }
            })
        },
        setAlignText(value){
            const item = this.items[this.selectItem];
            item.media_queries.forEach(elem=>{
                const textAlignIndex = elem.style.classes.findIndex(element=>element.startsWith('text'))
                if (textAlignIndex> -1){
                    elem.style.classes.splice(textAlignIndex, 1);
                }
                elem.style.classes.push(value);
            })
            console.log(value)
        }
    },
    computed:{
        inputType() {
            return this.items[this.selectItem].element.type === 'img' ? 'file' : 'text';
        }
    }
}
</script>

<template>
    <div class="container mt-5" v-if="notAuthScreen">
        <h2>Чтобы перейти в конструктор новостей, необходимо перейти в компьютерную версию сайта!</h2>
    </div>
    <div class="main-block" v-else>
        <main-panel
            @addElement="addElement"
            @onSelectDevice="onSelectDevice"
            :selectItem="selectItem"
            :selectDevice="selectedDevice"
            :typeItem="items[selectItem]?.element.type"

        ></main-panel>
        <div class="box"
             @mousemove="moveItem($event)"
             @mouseup="stopDrag"
             :style="stylesBox()"
             @click="stopSelect"
        >
            <resize-block
                @click.stop
                @mousedown="startDrag(index, $event)"
                draggable="false"
                class="item" v-for="(item, index) in items"
                :style="stylesItem(item)"
                :class="item.media_queries.find(el=>el.title===selectedDevice).style.classes"
                :select="selectItem" :index="index" :listWidthHeight="{width: currentWidth, height:currentHeight}"
                :type-element="item.element.type"
                :classes="item.media_queries.find(el=>el.title===selectedDevice).style.classes"
                v-model:size-element="item.media_queries.find(el=>el.title===selectedDevice).style.size"
                :key="index"
                :ref="`item_${index}`"
                @dblclick="editText(item, $event, index)"
                @startResize="onBlockResizedStart"
                @stopScale="onStopScale"
                @set-text-style="setTextStyle"
                @set-align-text="setAlignText"
            >
                <img draggable="false" :src="item.element.value" alt="" v-if="item.element.type==='img'">
                <textarea :id="`item${index}`" :ref="`text${index}`" class="text" v-if="item.element.type==='txt' && item.editText" v-model="item.element.value"
                          @input="changeText(index)"
                          :style="{height:item.heightText + 'px'}"
                >
                </textarea>
                <div class="text" draggable="false" v-if="item.element.type==='txt' && !item.editText">{{item.element.value}}</div>
            </resize-block>
        </div>
        <modal-component :title="'Сохранение блока'" :id="'saveModal'" @actionFrom="saveBlock">
            <loader-component v-if="loader"></loader-component>
            <div v-else>
                <label for="title" class="form-label">Введите название блока</label>
                <input type="text" class="form-control" id="title" v-model="titleBlock">
            </div>
            <div class="message">
                {{saveMessage}}
            </div>
        </modal-component>
        <modal-component key="modal" :title="'Изменить блок'" :id="'editBlockModal'" v-if="selectItem >= 0" @actionFrom="changeElement">
            <label for="value" class="form-label">Загрузить изображение</label>
            <input type="file" class="form-control" id="value" @change="fileReader($event)">
        </modal-component>
    </div>
</template>

<style scoped>
.main-block{
    max-width: 1200px;
    margin: auto;
    margin-top: 50px;
    margin-bottom: 50px;
    background-color: #eff2f4;
}
.box{
    margin: auto;
    height: 600px;
    position: relative;
    overflow: hidden;
    background-color: white;
    box-shadow: 0px 0px 15px 8px rgba(0,0,0,0.1);
}
.item{
    position: absolute;
    -webkit-user-select: none;
}
img{
    width: 100%;
}
.text{
    width: 100%;
    border: none;
    word-break: break-all;
    resize: none;
    overflow: hidden;
    height: max-content;
    outline: none;
}
.text{
    word-break: break-word;
}
textarea{
    position: relative;
    background-color: #e4edf3;
    z-index: 99;
}
</style>
