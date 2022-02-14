import Vue from 'vue';
import Vuex from 'vuex';

import auth from './modules/auth';

// Commerce
import cart from '../commerce/store/modules/cart';
import paymentSources from '../commerce/store/modules/payment-sources';
import standingData from '../commerce/store/modules/standing-data';
import catalogue from '../commerce/store/modules/catalogue';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        cart,
        paymentSources,
        standingData,
        catalogue
    }
});
