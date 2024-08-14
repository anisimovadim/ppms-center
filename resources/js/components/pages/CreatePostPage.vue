<template>
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5">
            <h2>Создание поста</h2>
            <my-button data-bs-toggle="modal" data-bs-target="#previewModal">Предпросмотр поста</my-button>
        </div>
        <div class="alert" :class="message && 'alert-ppms'">
            {{ message }}
        </div>
        <form @submit.prevent="savePost" style="max-width: 700px; margin: auto">
            <div class="mb-3 w-100" v-for="(object, index) in objects" :key="object.uniqueId">
                <label :for="index" class="form-label">{{ object.label }}</label>
                <div class="block-item d-flex align-items-center gap-2 w-100 flex-nowrap">
                    <textarea :class="valid[`${index}.value`] && 'is-invalid'" class="form-control"
                              v-if="object.id === 'text'" v-model="object.value"></textarea>
                    <input :class="valid[`${index}.value`] && 'is-invalid'" v-else :type="object.type"
                           class="form-control flex-grow-1 w-100" :id="index"
                           v-model="object.value" @change="fileReader($event, index)">
                    <div class="icon" @click="delElement(index)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-trash3" viewBox="0 0 16 16">
                            <path
                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                    </div>
                </div>
                <div v-if="valid && valid[`${index}.value`]" class="text-danger mt-2">{{
                        valid[`${index}.value`][0]
                    }}
                </div>
            </div>
            <div class="plus text-center">
                <plus-btn type="button" data-bs-toggle="dropdown" aria-expanded="false"></plus-btn>
                <ul class="dropdown-menu">
                    <li @click="addElement('text', 'title')"><p class="dropdown-item">Добавить заголовок</p></li>
                    <li @click="addElement('text', 'text')"><p class="dropdown-item">Добавить текст</p></li>
                    <li @click="addElement('text', 'link')"><p class="dropdown-item">Добавить ссылку</p></li>
                    <li @click="addElement('file', 'image')"><p class="dropdown-item">Добавить изображение</p></li>
                    <li @click="addElement('file', 'video')"><p class="dropdown-item">Добавить видео</p></li>
                    <li @click="addElement('file', 'file')"><p class="dropdown-item">Добавить файл</p></li>
                </ul>
            </div>
            <div class="btn-block d-flex justify-content-center">
                <my-button class="w-100 mt-5">
                    <p v-if="!isLoad">Сохранить</p>
                    <loader-component v-else></loader-component>
                </my-button>
            </div>
        </form>
    </div>
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="previewModalLabel">Предпросмотр поста</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <post-component :mode="'preview'" :objects="formatterData"></post-component>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Назад</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MyInput from "@/components/ui/MyInput.vue";
import MyButton from "@/components/ui/MyButton.vue";
import PlusBtn from "@/components/ui/PlusBtn.vue";
import DropdownComponent from "@/components/shared/DropdownComponent.vue";
import PostComponent from "@/components/shared/PostComponent.vue";
import api from "@/api.js";
import index from "vuex";
import LoaderComponent from "@/components/ui/LoaderComponent.vue";
import BlockNew from "@/components/ui/BlockNew.vue";

export default {
    name: "CreatePostPage",
    components: {BlockNew, LoaderComponent, PostComponent, DropdownComponent, PlusBtn, MyButton, MyInput},
    data() {
        return {
            param: '',
            objects: [
                {type: 'text', label: 'Заголовок', value: '', id: 'title', uniqueId: 0}
            ],
            fileReaders: {},
            message: '',
            valid: {},
            isLoad: false,
            action:'created'
        };
    },
    mounted() {
        this.setTitle();
    },
    beforeUnmount() {
        Object.values(this.fileReaders).forEach(reader => {
            reader.abort();
        });
    },
    methods: {
        setTitle() {
            document.title = `Создание поста`;
            this.initializeElements();
        },
        setLabel(id) {
            switch (id) {
                case 'image':
                    return 'Выберите изображение';
                case 'text':
                    return 'Напишите текст';
                case 'title':
                    return 'Заголовок';
                case 'video':
                    return 'Выберите видео';
                case 'link':
                    return 'Вставьте ссылку';
            }
        },
        getTypeObj(obj) {
            switch (obj.type) {
                case 'title':
                case 'text':
                case 'link':
                    return 'text';
                case 'image':
                case 'video':
                case 'file':
                    return 'file';
            }
        },
        async initializeElements() {
            if (this.$route.params.post_id) {
                document.title = `Редактирование поста`;
                this.action = 'edited'
                console.log('sdfsdf')
                try {
                    const res = await api.get(`/api/auth/post/${this.$route.params.post_id}`);
                    this.objects = []
                    for (let i = 0; i < res.data.post_objects.length; i++) {
                        let type_obj = this.getTypeObj(res.data.post_objects[i])
                        this.objects.push({
                            type: type_obj,
                            label: this.setLabel(res.data.post_objects[i].type),
                            value: type_obj === 'text'?res.data.post_objects[i].value:'',
                            id: res.data.post_objects[i].type,
                            id2: res.data.post_objects[i].id,
                            uniqueId: res.data.post_objects[i].id,
                            review: type_obj === 'file'?`${res.data.post_objects[i].value}`:''
                        })
                    }
                }
                catch (error){

                }
            }
        },
        addElement(type, id) {
            this.objects.push(
                {type, label: this.setLabel(id), value: '', id, uniqueId: Date.now()}
            );
            console.log(this.objects)
        },
        delElement(index) {
            const uniqueId = this.objects[index].uniqueId;
            if (this.fileReaders[uniqueId]) {
                this.fileReaders[uniqueId].abort();
                delete this.fileReaders[uniqueId];
            }
            this.objects.splice(index, 1);
        },
        fileReader(event, index) {
            if (this.objects[index].type === 'file') {
                const file = event.target.files[0];
                this.objects[index].value2 = file;
                if (file) {
                    const reader = new FileReader();
                    const uniqueId = this.objects[index].uniqueId;

                    this.fileReaders[uniqueId] = reader;

                    reader.onerror = (error) => {
                        console.error("File reading error:", error);
                    };

                    reader.onload = (e) => {
                        this.$nextTick(() => {
                            this.objects[index].review = e.target.result;
                        });
                    };

                    if (event.target.files.length === 0) {
                        return;
                    }

                    reader.readAsDataURL(file);
                }
            }
        },
        savePost() {
            this.isLoad = true;
            let route = '';
            if (this.action==='created'){
                route=`/api/auth/create/post/${this.$route.params.id}`
            }else{
                route=`/api/auth/edit/post/${this.$route.params.post_id}`
            }
            const data = this.objects.map(el => {
                return {type: el.id, value: el.type === 'file' ? (this.action==='edited'?el.review:el.value2) : el.value, id: el.id2}
            })
            api.post(route, {data}, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
                .then(res => {
                    this.message = res.data
                    this.isLoad = false;
                    setTimeout(() => {
                        this.message = ''
                    }, 2000)
                })
                .catch(er => {
                    this.isLoad = false;
                    if (er.response.status === 422) {
                        this.valid = er.response.data
                        setTimeout(() => {
                            this.valid = {}
                        }, 2000)
                    } else {
                        this.message = er.response.data
                        setTimeout(() => {
                            this.message = ''
                        }, 2000)
                    }
                })
        }
    },
    computed: {
        index() {
            return index
        },
        formatterData() {
            return this.objects.map(el => {
                return {type: el.id, value: el.type === 'file' ? el.review : el.value};
            });
        }
    }
};
</script>

<style scoped>
input{
    width: 100%;
}
.block-item {
    width: 100%;
}
form {
    max-width: 600px;
    margin: 50px auto auto;
}
.form-control {
    border-radius: 0;
}

.icon {
    cursor: pointer;
}

.modal-dialog {
    max-width: 80%;
}

.alert {
    max-width: 700px;
    margin: 20px auto;
}

</style>
