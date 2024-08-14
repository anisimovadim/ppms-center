<template>
    <div class="container">
        <div class="page">
            <div class="head">
                <h2>Наши сотрудники</h2>
                <my-button @click="setAction('add')" v-if="getAccessToken" data-bs-toggle="modal"
                           :data-bs-target="`#${actionObj.id}`">+ Добавить сотрудника
                </my-button>
            </div>
            <div class="list">
                <div class="block-items">
                    <div class="item" v-for="teacher in teachers">
                        <div class="image">
                            <img :src="teacher.image" alt="">
                        </div>
                        <div class="info">
                            <p>{{ teacher.lastName }} {{ teacher.name }} {{ teacher.patronymic }}</p>
                            <span class="special-span"
                                  v-for="(specialize_employer, index) in teacher.specialize_employers">{{
                                    index !== 0 ? ', ' : ''
                                }}{{ specialize_employer.specialize.title }}</span>
                        </div>
                        <div class="edit-btn" v-if="getAccessToken" @click="setAction('edit', teacher.id)"
                             data-bs-toggle="modal"
                             :data-bs-target="`#${actionObj.id}`">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path
                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd"
                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                        </div>
                        <div class="delete-btn" @click="deleteTeacher(teacher.id)" v-if="getAccessToken">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal-component :id="actionObj.id" :title="actionObj.title" @actionFrom="initActionTeacher(actionObj.id)">
            <div>
                <div class="alert alert-ppms" v-if="message">{{ message }}</div>
                <div class="special-bloc">
                    <h3>Выберите должности:</h3>
                    <div class="specials">
                        <div class="special" v-for="special in specializes">
                            <input :id="special.id" type="checkbox" class="form-check-input" :value="special.id"
                                   v-model="selectSpecials">
                            <label :for="special.id" class="form-label form-check-label ms-2">{{ special.title }}</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3" v-for="input in createTeacher">
                    <label :for="input.id" class="form-label">{{ input.label }}</label>
                    <my-input @change="fileReader($event, input)" :id="input.id" v-model:value="input.value"
                              :type="input.type"></my-input>
                </div>
                <div class="review">
                    <img :src="createTeacher[3].review" alt="">
                </div>
            </div>
        </modal-component>
    </div>
</template>

<script>
import MyButton from "@/components/ui/MyButton.vue";
import ModalComponent from "@/components/ui/ModalComponent.vue";
import MyInput from "@/components/ui/MyInput.vue";
import api from "@/api.js";
import MyButtonGrey from "@/components/ui/MyButtonGrey.vue";

export default {
    name: "EmployesPahe",
    components: {MyButtonGrey, MyInput, ModalComponent, MyButton},
    data() {
        return {
            teachers: [],
            createTeacher: [
                {label: 'Имя преподавателя', value: '', id: 'name', type: 'text'},
                {label: 'Фамилия преподавателя', value: '', id: 'lastName', type: 'text'},
                {label: 'Отчество преподавателя', value: '', id: 'patronymic', type: 'text'},
                {label: 'Фотография', value: '', id: 'image', review: '', type: 'file', file: ''},
            ],
            specializes: [],
            selectSpecials: [],
            message: '',
            actionObj: {
                title: 'Добавить специалиста',
                id: 'createTeacher',
                teacher_id: ''
            }
        }
    },
    created() {
        document.title = 'Наши сотрудники'
    },
    mounted() {
        this.getSpecial();
        this.getTeachers();
    },
    methods: {
        setAction(action, teacher_id) {
            if (this.actionObj.id !== 'createTeacher'){
                this.createTeacher = [
                    {label: 'Имя преподавателя', value: '', id: 'name', type: 'text'},
                    {label: 'Фамилия преподавателя', value: '', id: 'lastName', type: 'text'},
                    {label: 'Отчество преподавателя', value: '', id: 'patronymic', type: 'text'},
                    {label: 'Фотография', value: '', id: 'image', review: '', type: 'file', file: ''},
                ];
                this.selectSpecials=[];
            }
            if (action === 'add') {
                this.actionObj.title = 'Добавить специалиста';
                this.actionObj.id = 'createTeacher';
                this.actionObj.teacher_id = '';
            } else if (action === 'edit') {
                this.actionObj.title = 'Редактировать специалиста';
                this.actionObj.id = 'editTeacher';
                this.actionObj.teacher_id = teacher_id;
                const teacher = this.teachers.find(el => el.id === this.actionObj.teacher_id);
                this.createTeacher.find(el => el.id === 'name').value = teacher.name;
                this.createTeacher.find(el => el.id === 'lastName').value = teacher.lastName;
                this.createTeacher.find(el => el.id === 'patronymic').value = teacher.patronymic;
                this.createTeacher.find(el => el.id === 'image').review = teacher.image;
                this.selectSpecials=teacher.specialize_employers.map(el=>el.specialize_id);
            }
            console.log(this.actionObj)
        },
        addTeacher() {
            if (this.selectSpecials.length > 0) {
                let teacher = this.createTeacher.reduce((acc, el) => {
                    acc[el.id] = el.type === 'text' ? el.value : el.file;
                    return acc
                }, {});
                console.log(teacher);
                teacher.name = teacher.name.slice(0,1)+'. '
                teacher.patronymic = teacher.patronymic.slice(0,1)+'. '
                api.post('/api/auth/create/teacher', {data: teacher, selectSpecials: this.selectSpecials}, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    }
                })
                    .then(res => {
                        this.createTeacher = [
                            {label: 'Имя преподавателя', value: '', id: 'name', type: 'text'},
                            {label: 'Фамилия преподавателя', value: '', id: 'lastName', type: 'text'},
                            {label: 'Отчество преподавателя', value: '', id: 'patronymic', type: 'text'},
                            {label: 'Фотография', value: '', id: 'image', review: '', type: 'file', file: ''},
                        ];
                        this.selectSpecials = [];
                        this.getTeachers();
                    })
            } else {
                this.message = 'У специалиста должна быть хотя бы одна должность!'
                setTimeout(() => {
                    this.message = ''
                }, 2000)
            }
        },
        editTeacher() {
            const teacher = this.createTeacher.reduce((acc, el) => {
                acc[el.id] = el.type === 'text' ? el.value : el.file;
                return acc
            }, {});
            api.post('/api/auth/edit/teacher',{data: teacher, selectSpecials: this.selectSpecials, teacher_id:this.actionObj.teacher_id},{
                headers: {
                    "Content-Type": "multipart/form-data",
                }
            })
                .then(res=>{
                    this.getTeachers();
                })
        },
        deleteTeacher(teacher_id){
            api.post(`/api/auth/delete/teacher/${teacher_id}`)
                .then(res=>{
                    this.getTeachers();
                })
        },
        initActionTeacher(id) {
            if (id === 'createTeacher') {
                this.addTeacher()
            } else {
                this.editTeacher()
            }
        },
        getSpecial() {
            api.get('/api/specialization')
                .then(res => {
                    this.specializes = res.data
                })
        },
        getTeachers() {
            api.get('/api/teachers')
                .then(res => {
                    this.teachers = res.data
                })
        },
        fileReader(event, input) {
            if (input.id === 'image') {
                const file = event.target.files[0];
                input.file = file;
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        input.review = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            }
            console.log(input)
        }
    },
    computed: {
        getAccessToken() {
            return this.$store.getters.getAccessToken;
        }
    }

}
</script>

<style scoped>
.page {
    margin-top: 50px;
}

.block-items {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
}

h2 {
    text-align: center;
}

h3 {
    font-size: 17px;
    text-align: left;
    margin-bottom: 20px;
}

.head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.head h2 {
    flex-grow: 1;
    text-align: center;
}

button {
    margin-left: auto;
}

.review {
    width: 100%;
}

img {
    width: 100%;
}

.form-control {
    border-radius: 0;
}

.list {
    width: 100%;
    margin: auto;
}

.item {
    max-width: 20%;
    margin: 20px;
    position: relative;
}

.item .image {
    width: auto;

}

.info {
    position: absolute;
    bottom: 0;
    background: #3c87af;
    width: 100%;
    padding: 10px;
    color: #efefef;
    opacity: 0;
    transition: .5s;
}

.edit-btn {
    position: absolute;
    top: 0;
    right: 0;
    background-color: #3c87af;
    padding: 5px;
    cursor: pointer;
    opacity: 0;
    transition: .5s;
}
.delete-btn{
    position: absolute;
    top: 0;
    left: 0;
    background-color: #0c4c6f;
    padding: 5px;
    opacity: 0;
    transition: .5s;
    cursor: pointer;
}
.delete-btn svg{
    filter: invert(90%);
}
.edit-btn svg {
    filter: invert(100%);
}

.item:hover .info {
    opacity: 1;
    transition: .5s;
}

.item:hover .delete-btn{
    opacity: 1;
    transition: .5s;
}
.item:hover .edit-btn{
    opacity: 1;
    transition: .5s;
}
.item .image img {
    height: auto;
}

.specials {
    display: grid;
    grid-template-columns: 1fr 1fr;
    font-size: 13px;
    margin-top: 10px;
    margin-bottom: 25px;
    white-space: nowrap;
}

.special-span {
    font-weight: 600;
}

.specials label {
    font-size: 13px;
}

@media screen and (max-width: 570px) {
    .item {
        max-width: 35%;
        margin: 20px;
        position: relative;
    }
}

@media screen and (max-width: 490px) {
    .specials {
        grid-template-columns: 1fr;
        white-space: pre-wrap;
    }
}
</style>
