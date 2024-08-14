<template>
    <div class="modal fade" :id="id" tabindex="-1" :aria-labelledby="id + 'Label'" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" :id="id + 'Label'">{{ title }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="$emit('actionFrom')">
                    <div class="modal-body">
                        <slot></slot>
                    </div>
                    <div class="modal-footer">
                        <my-button class="w-100" type="submit">Сохранить</my-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import MyButton from "@/components/ui/MyButton.vue";

export default {
    name: "ModalComponent",
    components: {MyButton},
    props: {
        id: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        }
    }
}
</script>

<style scoped>

</style>
