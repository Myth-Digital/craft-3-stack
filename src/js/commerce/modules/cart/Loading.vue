<template>
    <div class="isLoading" v-bind:class="{ active: isLoading }"><span class="loading-bar"></span></div>
</template>

<script>
export default {
    data() {
        return {
        }
    },
    computed: {
        isLoading() {
            return this.$store.state.cart.isLoading;
        }
    }
}
</script>

<style>

</style>
