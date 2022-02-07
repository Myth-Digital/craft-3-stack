export default {
  namespaced: true,
  state: {
    isLoading: false,
    cart: {
      totalLineItems: 0,
      currency: 'GBP'
    },
    cartErrors: null,
    cartOpen: false,
    searchOpen: false,
    currentCheckoutState: {},
    cartWorkflow: [
      {
        label: 'Account',
        name: 'account',
        guestCheckout: true,
        completed: false
      },
      {
        label: 'Delivery',
        name: 'delivery',
        guestCheckout: false,
        completed: false
      },
      {
        label: 'Payment',
        name: 'payment',
        guestCheckout: false,
        completed: false
      }
    ],
    globalSet: null,
    isOneClickPay: false
  },
  mutations: {
    SET_CART(state, payload) {
      state.cart = payload;
    },
    SET_CART_ERRORS(state, payload) {
      state.cartErrors = payload;
    },
    SET_SEARCH_OPEN_STATE(state, payload) {
      state.searchOpen = payload;
    },
    SET_CART_OPEN_STATE(state, payload) {
      state.cartOpen = payload;
    },
    SET_LOADING_STATE(state, payload) {
      state.isLoading = payload;
    },
    SET_CHECKOUT_STATE(state, payload) {
      state.currentCheckoutState = payload;
    },
    SET_IS_ONECLICKPAY(state, payload) {
      state.isOneClickPay = payload;
    },
    SET_GLOBAL_SET(state, payload) {
      state.globalSet = payload;
    },
    SET_CART_WORKFLOW(state, payload) {
      state.cartWorkflow = payload;
    }, 
  },
  actions: {
    init({commit}) {
      return axios.get(`/api/cart`)
        .then((res) => {
          commit('SET_CART', res.data.cart);
          return res.data.cart;
        });
    },
    isIsLoading({commit}) {
      commit('SET_LOADING_STATE', true);
    },
    isNotLoading({commit}) {
      commit('SET_LOADING_STATE', false);
    },
    setIsOneClickPay({commit}, flag) {
      commit('SET_IS_ONECLICKPAY', flag);
    },
    showCartPane({commit}) {
      commit('SET_CART_OPEN_STATE', true);
    },
    showSearchVeil({commit}) {
      commit('SET_SEARCH_OPEN_STATE', true);
    },
    clearCartErrors({commit}) {
      commit('SET_CART_ERRORS', null);
    },
    hideSearchVeil({commit}) {
      commit('SET_SEARCH_OPEN_STATE', false);
    }, 
    hideCartPane({commit}) {
      commit('SET_CART_OPEN_STATE', false);
    },    
    setCustomCartError({commit, state}, {error, field}) {
      let cart = state.cart;
      if (!cart.errors) cart.errors = {};
      cart.errors[field] = [error];
      commit('SET_CART', cart);
    },
    addToCart({commit, state}, purchasableId) {
      let payload = {
        purchasableId: purchasableId
      }
      return axios.post(`/api/cart/update`, payload)
        .then((res) => {
          if (!res.data.success) {
            commit('SET_CART_ERRORS', res.data.errors);
            return state.cart;
          }
          else {
            commit('SET_CART_ERRORS', null);
          }
          commit('SET_CART', res.data.cart);
          return res.data.cart;
        });
    },
    addToCartWithQty({commit, state}, {purchasableId, options, qty}) {
      let payload = {
        purchasableId: purchasableId,
        qty: qty
      };
      if(options) {
        payload.options = options
      }
      return axios.post(`/api/cart/update`, payload)
        .then((res) => {
          if (!res.data.success) {
            commit('SET_CART_ERRORS', res.data.errors);
            return state.cart;
          }
          else {
            commit('SET_CART_ERRORS', null);
          }
          commit('SET_CART', res.data.cart);
          return res.data.cart;
        });      
    },
    removeFromCart({commit}, id) {
      let lineItems = {
				[id] : {
					qty: 0
				}
			}
			let payload = { lineItems }

      return axios.post(`/api/cart/update`, payload)
        .then((res) => {
          commit('SET_CART', res.data.cart);
          return res.data.cart;
        });      
    },
    updateCart({commit, state}, payload) {
      return axios.post(`/api/cart/update`, payload)
      .then((res) => {
        if (!res.data.success) {
          commit('SET_CART_ERRORS', res.data.errors);
          return state.cart;
        }
        else {
          commit('SET_CART_ERRORS', null);
        }
        commit('SET_CART', res.data.cart);
        return res.data.cart;
      });   
    },
    applyCouponCode({commit}, couponCode) {
      let payload = {
        couponCode: couponCode
      }
      return axios.post(`/api/cart/update`, payload)
        .then((res) => {
          commit('SET_CART', res.data.cart);

          return res.data.cart;
        });      
    },
    setGatewayId({commit}, gatewayId) {
      let payload = {
        gatewayId: gatewayId
      }
      return axios.post(`/api/cart/update`, payload)
        .then((res) => {
          commit('SET_CART', res.data.cart);
          return res.data.cart;
        });      
    },   
    setPaymentSourceId({commit}, paymentSourceId) {
      let payload = {
        paymentSourceId: paymentSourceId
      }
      return axios.post(`/api/cart/update`, payload)
        .then((res) => {
          commit('SET_CART', res.data.cart);
          return res.data.cart;
        });      
    },
    getGlobalSet({commit}, setId) {
      return axios.get(`/api/globals/${setId}`)
        .then((res) => {
          commit('SET_GLOBAL_SET', res.data);
          return res.data;
        }); 
    },
    submitOrder({commit}, payload) {
      return axios.post(`/api/pay`, payload)
        .then((res) => {
          return res.data;
        });      
    },
    setCheckoutState({commit}, checkoutState) {
      commit('SET_CHECKOUT_STATE', checkoutState);
    }    
  }
};