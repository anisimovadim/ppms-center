<script>


import ZeroBlock from "./shared/ZeroBlock.vue";
import MainPanel from "@/components/layouts/MainPanel.vue";
import NavbarComponent from "@/components/layouts/NavbarComponent.vue";

export default {
    name: "MainComponent",
    components: {NavbarComponent, MainPanel, ZeroBlock},
}
</script>

<template>
    <div class="main">
        <navbar-component></navbar-component>
        <router-view></router-view>
    </div>
</template>

<style scoped>
</style>
