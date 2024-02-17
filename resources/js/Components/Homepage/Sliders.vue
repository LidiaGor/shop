<script setup>
import {getBannersPath} from "@/Composables/GetPaths.js";

const props = defineProps({
    horizontal: Object,
    double: Object
})

</script>

<template>
    <div class="wrapper">
        <section class="adv">
            <div class="adv-main" v-if="props.horizontal?.image">
                <img :src="getBannersPath(props.horizontal?.image)" :alt="props.horizontal?.description">
            </div>
            <div v-for="banner in props.double">
                <img :src="getBannersPath(banner.image)" :alt="banner.description">
            </div>
        </section>
    </div>
</template>
