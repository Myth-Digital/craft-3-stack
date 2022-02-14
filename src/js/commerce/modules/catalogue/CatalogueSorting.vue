<template>

    <div>

        <div class="flex justify-between px-10 py-5 items-center">
            <h2 class="text-2xl font-bold">{{ searchMetadata.rootCategoryTree.name }}</h2>
            <div class="flex space-x-4">
                <div>
                    <button x-on:click="hideFilters = !hideFilters"><span x-text="hideFilters == true ? 'Show Filters' : 'Hide Filters'"></span></button>
                </div>
                <div class="relative" x-data="{ open: false }">
                    <button x-on:click="open = !open">Sort by</button>
                    <ul x-show="open" class="absolute z-20 top-full right-0 text-right w-60 bg-white p-4 space-y-1">
                        <li><a href="#">Featured</a></li>
                        <li><a href="#">Newest</a></li>
                        <li><a href="#">Price: High-Low</a></li>
                        <li><a href="#">Price: Low-High</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
export default {
    computed: {
        searchMetadata() {
            let searchResults = this.$store.state.catalogue.searchResults;
            if (!searchResults) return null;
            return searchResults.metadata;
        },
        searchRequest() {
            return this.$store.state.catalogue.searchRequest;
        }
    }
}
</script>

<style>

</style>