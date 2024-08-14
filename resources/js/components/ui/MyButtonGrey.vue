<template>
    <button><slot></slot></button>
</template>

<script>
export default {
    name: "MyButtonGrey"
}
</script>

<style scoped>
button{
    width: 180px;
    height: 40px;
    background-color: #FFFFFF;
    border: none;
    font-size: 13px;
    transition: .3s;
}
button:hover{
    background-color: #e3e3e3;
    transition: .3s;
}
@media screen and (max-width: 766px){
    button{
        width: 80px;
        height: 20px;
        font-size: 8px;
    }
}
</style>
