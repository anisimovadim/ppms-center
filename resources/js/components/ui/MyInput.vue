<template>
    <input type="text" class="form-control" :placeholder="placeholder" :value="value" @input="updateValue($event.target.value)">
</template>

<script>
export default {
    name: "MyInput",
    props:{
        placeholder:{
            type:String,
            // required:true
        },
        value:{
            type:[Number, String],
            default: ()=>'',
            required: true
        }
    },
    methods:{
        updateValue(value){
            this.$emit('update:value', value);
        }
    }
}
</script>

<style scoped>
.form-control{
    border-radius: 0;
    font-size: 15px;
}

</style>
