<template>

<div v-if="searchMetadata">

    <nav class="left-nav">
        <div class="left-nav__categories">
            <a v-if="searchMetadata.rootCategoryTree.parentSlug" @click="backToParent(searchMetadata.rootCategoryTree.parentSlug)" href="#" class="block"> Back to {{ searchMetadata.rootCategoryTree.parentName }} </a>
            <a v-for="childCategory in searchMetadata.rootCategoryTree.childCategories" :key="childCategory.categoryId" href="#" @click="selectChildCategory(childCategory)" class="block font-bold">{{ childCategory.name }}</a>
        </div>
    </nav>

    <nav class="left-nav mt-5">
        <div class="left-nav__title py-2 border-t border-gray-400">Shop by Brand</div>
        <div class="left-nav__filters">
            <button class="filter-item__item block" v-for="category in searchMetadata.brandCategories" :key="category.categoryId" aria-label="Filter for X">
                <input @change="applyFilters()" v-model="filterSearchRequest.brandCategory" :value="category.slug" type="checkbox" />
                <span class="filter-item__item-label">{{ category.name }}</span>
            </button>
        </div>
    </nav>

    <nav class="left-nav mt-5" v-for="(variantFilterGroup, index) in searchMetadata.variantCategories" :key="index">
        <div class="left-nav__title py-2 border-t border-gray-400">Shop by {{ variantFilterGroup.name }}</div>
        <div class="left-nav__filters">
            <button class="filter-item__item block" v-for="category in variantFilterGroup.variantCategories" :key="category.categoryId" aria-label="Filter for X">
                <input @change="applyFilters()" v-model="filterSearchRequest.filterCategory" :value="category.slug" type="checkbox" />
                <span class="filter-item__item-label">{{ category.name }}</span>
            </button>
        </div>
    </nav>

</div>

</template>

<script>
export default {
    data() {
        return {
            filterSearchRequest: null
        }
    },
    created() {
        this.filterSearchRequest = this.searchRequest;
    },
    computed: {
        searchMetadata() {
            let searchResults = this.$store.state.catalogue.searchResults;
            if (!searchResults) return null;
            return searchResults.metadata;
        },
        searchRequest() {
            return this.$store.state.catalogue.searchRequest;
        }
    },
    watch: {
        searchRequest(newSearchRequest, oldSearchRequest) {
            this.filterSearchRequest = newSearchRequest;
        },
    },
    methods: {
        backToParent(parentSlug) {
            // Set the new root.
            this.filterSearchRequest.rootCategory = parentSlug;
            this.$store.dispatch('catalogue/searchProducts', this.filterSearchRequest);
        },
        selectChildCategory(selectedChild) {
            // Set the new root.
            this.filterSearchRequest.rootCategory = selectedChild.slug;
            this.$store.dispatch('catalogue/searchProducts', this.filterSearchRequest);
        },
        applyFilters() {
            this.$store.dispatch('catalogue/searchProducts', this.filterSearchRequest);

        }
    }

}
</script>

<style>

</style>