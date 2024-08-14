<template>
    <button><slot></slot></button>
</template>

<script>
export default {
    name: "MyButton"
}
</script>

<style scoped>
button{
    width: 180px;
    height: 40px;
    background-color: #3C87AF;
    color: white;
    border: none;
    font-size: 13px;
    transition: .3s;
}
button:hover{
    background-color: #7CC8F1;
    transition: .3s;
}
@media screen and (max-width: 766px){
    button{
        max-width: 100px;
        font-size: 7px;
        height: 30px;
    }
}
</style>
