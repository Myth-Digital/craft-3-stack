import Vue from 'vue';
import Vuex from 'vuex';

import auth from './modules/auth';

// Commerce
import cart from '../commerce/store/modules/cart';
import paymentSources from '../commerce/store/modules/payment-sources';
import standingData from '../commerce/store/modules/standing-data';
import products from '../commerce/store/modules/products';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        cart,
        paymentSources,
        standingData,
        products
    }
});
