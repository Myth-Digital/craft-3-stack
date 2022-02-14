<template>
    <div>
        <slot></slot>
    </div>
</template>

<script>
export default {

    props: {
        initialRequest: {
            type: Object,
            quantity: 1,
            default: {}
        },
        initialResults: {
            type: Object,
            quantity: 1,
            default: {}
        }
    },
    created() {
        this.$store.dispatch('catalogue/initCatalogue', {
            initialSearchRequest: this.initialRequest, 
            initialSearchResults: this.initialResults
        });
    }

}
</script>

<style>

</style>