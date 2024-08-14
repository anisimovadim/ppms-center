<template>
<div class="burger" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
    <div></div>
    <div></div>
    <div></div>
</div>
</template>

<script>
export default {
    name: "BurgerButton"
}
</script>

<style scoped>
.burger{
    width: 33px;
    height: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
    position: absolute;
    right: 20px;
}
.burger div{
    width: 100%;
    height: 4px;
    background-color: white;
}
</style>
