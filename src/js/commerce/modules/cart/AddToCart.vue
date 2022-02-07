<template>
    <div>
        <div class="sm:flex mt-5">
            <div class="flex justify-between sm:mr-4">
                <span @click="removeOneQty()" class="border border-gray-200 p-4 mr-2 cursor-pointer text-xl leading-none">–</span>
                <span class="flex-1 sm:flex-none cart-quantity"><input v-model="quantity" type="number" min="0" class="appearance-none border border-gray-200 p-4 w-full sm:w-16 text-center" /></span>
                <span  @click="addOneQty()" class="border border-gray-200 p-4 ml-2 cursor-pointer text-xl leading-none">+</span>
            </div>
            <button type="submit" class="btn btn-primary btn-dark btn-solid w-full mt-4 sm:w-auto sm:mt-0" @click="addToCart()">
                Add to basket
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        product: {
            type: Object,
            quantity: 1,
            default: {}
        },        
    },
    data() {
        return {
            isLoading: false,
            quantity: 1
        }
    },
    mounted() {
        this.$nextTick(() =>{
            this.isLoading = false;
        });
    },
    computed: {
        cart() {
            return this.$store.state.cart.cart;
        }
    },
    methods: {
        removeOneQty() {
            if(this.quantity > 1) {
                this.quantity = this.quantity - 1;
            }
        },
        addOneQty() {
            this.quantity = this.quantity + 1;
        },
        addToCart() {
            this.$store.dispatch('cart/isIsLoading');

            this.$store.dispatch('cart/addToCartWithQty', {purchasableId: this.product.defaultVariantId, qty: this.quantity })
                .then(res => { 
                    this.$store.dispatch('cart/showCartPane');
                    this.$store.dispatch('cart/isNotLoading');
                });
        }
    }
}
</script>

<style>

</style>
