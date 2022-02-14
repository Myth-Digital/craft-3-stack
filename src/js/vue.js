import Vue from 'vue';
import store from './store';
import http from './http';

// Plugins
import CurrencyBadge from 'vue-currency-symbol';
import VueCurrencyFilter from 'vue-currency-filter';
import stringToFloat from './commerce/filters/string-to-float';

// Shared
import Loading from './commerce/modules/cart/Loading';

// Checkout
import Steps from './commerce/modules/checkout/Steps';
import Account from './commerce/modules/checkout/Account';
import Delivery from './commerce/modules/checkout/Delivery';
import Payment from './commerce/modules/checkout/Payment';
import Summary from './commerce/modules/checkout/Summary';
import CheckoutLoading from './commerce/modules/checkout/components/Loading';
import OneClickPay from './commerce/modules/checkout/components/OneClickPay';
import NewCard from './commerce/modules/checkout/components/NewCard';

// Cart
import AddToCart from './commerce/modules/cart/AddToCart';
import CouponCode from './commerce/modules/cart/CouponCode';
import CartIcon from './commerce/modules/cart/CartIcon';
import CartPane from './commerce/modules/cart/CartPane';
import CartMain from './commerce/modules/cart/CartMain';

// Product
import CardAddToCart from './commerce/modules/product/CardAddToCart';

// Search
import SearchVeil from './commerce/modules/search/SearchVeil';
import SearchInput from './commerce/modules/search/SearchInput';

// Catalogue
import CatalogueShell from './commerce/modules/catalogue/CatalogueShell';
import CatalogueFilters from './commerce/modules/catalogue/CatalogueFilters';
import CatalogueSorting from './commerce/modules/catalogue/CatalogueSorting';
import CatalogueProductCard from './commerce/modules/catalogue/CatalogueProductCard';
import CatalogueGrid from './commerce/modules/catalogue/CatalogueGrid';

// Components
import InputButton from './commerce/modules/checkout/components/form/Button';
import InputField from './commerce/modules/checkout/components/form/Input';
import SelectField from './commerce/modules/checkout/components/form/Select';

// Mixins
import CartErrors from './commerce/mixins/cart-error';
import ArrayHelpers from './commerce/mixins/array-helpers';

// Polyfill the Standard Library functions
require('core-js');

Vue.use(CurrencyBadge);
Vue.use(VueCurrencyFilter,{
    thousandsSeparator: ',',
    fractionCount: 2,
    fractionSeparator: '.',
    symbolPosition: 'front',
    symbolSpacing: false
});

Vue.filter('string-to-float', stringToFloat);

store.dispatch('cart/init');

Vue.component('loading', Loading);
Vue.component('c-button', InputButton);
Vue.component('c-input', InputField);
Vue.component('c-select', SelectField);
Vue.component('checkout-loading', CheckoutLoading);
Vue.component('checkout-oneclickpay', OneClickPay);
Vue.component('checkout-steps', Steps);
Vue.component('checkout-account', Account);
Vue.component('checkout-delivery', Delivery);
Vue.component('checkout-payment', Payment);
Vue.component('checkout-summary', Summary);
Vue.component('add-to-cart', AddToCart);
Vue.component('card-add-to-cart', CardAddToCart);
Vue.component('cart-icon', CartIcon);
Vue.component('coupon-code', CouponCode);
Vue.component('cart-pane', CartPane);
Vue.component('cart-main', CartMain);
Vue.component('account-new-card', NewCard);
Vue.component('search-veil', SearchVeil);
Vue.component('search-input', SearchInput);

// Catalogue Components
Vue.component('catalogue-shell', CatalogueShell);
Vue.component('catalogue-filters', CatalogueFilters);
Vue.component('catalogue-sorting', CatalogueSorting);
Vue.component('catalogue-product-card', CatalogueProductCard);
Vue.component('catalogue-grid', CatalogueGrid);

Vue.mixin(CartErrors);
Vue.mixin(ArrayHelpers);

window.Vue = Vue;

const app = new Vue({
	el: '#app',
	store
});