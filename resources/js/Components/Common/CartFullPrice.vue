<script setup>

import {ref} from "vue";

const props = defineProps({
    full: Object
})

const sumOld = () => {
    let fullSum = 0;
    for (let i = 0; i < props.full.length; i++) {
        fullSum +=
            (props.full[i]?.product?.oldprice
                ?? props.full[i]?.product?.price
                ?? 0) * props.full[i].quantity;
    }
    return fullSum.toFixed(2)
}
const sum = () => {
    let fullSum = 0;
    for (let i = 0; i < props.full.length; i++) {
        fullSum +=
            (props.full[i]?.product?.price
                ?? props.full[i]?.product?.oldprice
                ?? 0) * props.full[i].quantity;
    }
    return fullSum.toFixed(2)
}

const getDiscount = () => {

    return (100 - (sum() / sumOld() * 100)).toFixed(2)
}

</script>

<template>
    <section class="price-block">
        <div>
            Сумма:
        </div>

        <div class="price">
            {{
                Intl.NumberFormat('ru-RU', {minimumFractionDigits: 2}).format(sumOld())
            }} ₽
        </div>

        <template
            v-if="getDiscount()"
        >
            <div>
                Скидка:
            </div>

            <div class="discount">
                {{ getDiscount() }} %
            </div>
        </template>

        <div>
            Сумма к оплате:
        </div>

        <div class="basic">
            {{
                Intl.NumberFormat('ru-RU', {minimumFractionDigits: 2}).format(sum())
            }} ₽
        </div>

        <div class="button">
            <button class="btn-basket mx-auto">
                К оформлению
            </button>
        </div>

    </section>
</template>

<style scoped>

</style>
