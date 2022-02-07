<template>
	<div class="fixed ease-out duration-300 h-full flex justify-end z-50" :class="isOpen ? 'right-0' : '-right-full'">
		<span @click="closeCart()"></span>
		<aside class="flex flex-col justify-between w-96 bg-white sm:border-l sm:border-gray-300 translate-x-1" :class="{ 'translate-x-0' : isOpen }">

			<div class="flex justify-between items-center p-4 border-b border-gray-300">
				<span class="text-sm font-bold flex align-center" @click="closeCart()">
					<span>Close</span>
				</span>
				<span class="text-xs">
					{{ totalLineItems }} item{{ totalLineItems > 1 ? 's' : '' }}
				</span>
			</div>
			<div v-if="cartErrors">
				<p v-for="(errArr,idx) in cartErrors" :key="idx">
					<span v-for="(err,jdx) in errArr" :key="jdx">
						{{err}}
					</span>
				</p>
				<p v-if="cartErrors['lineItems'] && cartErrors['lineItems'][0]">
					<span>
						{{cartErrors['lineItems'][0]}}
					</span>
				</p>
			</div>

			<div class="h-full bg-gray-100 flex items-center" v-if="totalLineItems <= 0">
				<span class="w-full text-center">Your cart is empty.</span>
			</div>

			<div class="h-full bg-gray-100 p-4 overflow-y-scroll" v-if="totalLineItems > 0">
				<div class="w-full mb-4 p-5 bg-white rounded-md border border-gray-200" v-for="(lineItem, key) in cartLineItems" :key="key">
					<div v-if="!isLoading" class="grid grid-cols-4 justify-between gap-2">
						<figure class="block">
							<img :src="`/api/product/${lineItem.snapshot.productId}/thumb/`" class="w-full h-auto" :alt="lineItem.snapshot.title" />
						</figure>
						<div class="col-span-2">
							<div class="block font-bold mb-2">{{ lineItem.snapshot.title }}</div>
							<div class="flex">
								<span class="p-2 border border-gray-200" @click="lineItem.qty > 1 ? updateQty(lineItem, -1) : removeLineItem(lineItem.id)">–</span>
								<span class="p-2">{{ lineItem.qty }}</span>
								<span class="p-2 border border-gray-200" @click="updateQty(lineItem, 1)">+</span>
							</div>
							<span class="block text-xs cursor-pointer" @click="removeLineItem(lineItem.id)">Remove</span>
						</div>
						<div class="font-bold text-base"><span v-html="currencySymbol(cart.currency)"></span>{{ lineItem.subtotal | currency }}</div>
					</div>
				</div>
			</div>

			<div class="border-t border-gray-300">
				<div class="pt-4 px-4 flex justify-between">
					<span class="font-bold">Subtotal</span>
					<span><i v-html="currencySymbol(cart.currency)"></i>{{ cart.itemSubtotal | currency }}</span>
				</div>
				<div class="p-4 flex justify-between">
					<div v-if="cart.isEmpty" class="disabled"></div>
					<a :href="checkoutPath" class="btn btn-secondary btn-solid rounded-md w-full">Checkout Securely</a>
				</div>
			</div>
		</aside>
	</div>
</template>

<script>
export default {
	props: {
		checkoutPath: String
	},
	data() {
		return {
			isLoading: false
		}
	},
	created() {
		this.$store.dispatch('cart/init');
	},
	computed: {
		cart() {
			return this.$store.state.cart.cart;
		},
		cartErrors() {
			return this.$store.state.cart.cartErrors;
		},
		totalLineItems() {
			if (!this.cart || !this.cart.lineItems) return 0;
			return this.cart.lineItems.length;
		},
		cartLineItems() {
			const lineItems = this.$store.state.cart.cart.lineItems;
			const lineItemsArray = Object.keys(lineItems).map((key) => lineItems[key]);
			return lineItemsArray;
		},
		isOpen() {
			return this.$store.state.cart.cartOpen;
		}
	},
	methods: {
		updateQty(lineItem, relativeQty) {
			this.isLoading = true;
			const lineItemId = lineItem.id;
			const newQty = lineItem.qty + relativeQty;

			// Construct the update payload
			const lineItems = {
				[lineItemId] : {
					qty: newQty
				}
			};

			const updatedLineItems = { lineItems }

			this.$store.dispatch('cart/updateCart', updatedLineItems)
				.then(res => {
					this.isLoading = false;
				});
		},
		removeLineItem(lineItemId) {
			this.isLoading = true;
			this.$store.dispatch('cart/removeFromCart', lineItemId)
				.then(res => {
					this.isLoading = false;
				});
		},
		closeCart() {
			this.$store.dispatch('cart/clearCartErrors');
			this.$store.dispatch('cart/hideCartPane');
		}
	}
}
</script>