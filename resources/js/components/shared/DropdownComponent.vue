<template>
    <ul class="dropdown-menu" v-if="links.length>0">
        <li v-for="(link, index) in links" :key="index">
            <router-link :to="link.url" class="dropdown-item" href="#">{{ link.title }}</router-link>
        </li>
    </ul>
</template>

<script>
export default {
    name: "DropdownComponent",
    props:{
        links:{
            type:Array,
            default: []
        }
    }
}
</script>

<style scoped>

</style>
