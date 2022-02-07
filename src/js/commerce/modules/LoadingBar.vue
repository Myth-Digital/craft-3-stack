<template>
    <circle-spinner v-if="isLoading"></circle-spinner>
</template>

<script>

export default {
    components: {
      'circle-spinner' : Circle
    },    
    props: {
        isLoading: Boolean
    }
}
</script>

<style>

</style>
