<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Sliders from "@/Components/Homepage/Sliders.vue";
import SpecialOffers from "@/Components/Homepage/SpecialOffers.vue";

const props = defineProps({
    banners_horizontal: Object,
    banners_double: Object
})

</script>

<template>
    <GuestLayout>
        <div class="wrapper">
            <Sliders
                :horizontal="props.banners_horizontal"
                :double="props.banners_double"
            />
            <SpecialOffers/>
        </div>
    </GuestLayout>
</template>

