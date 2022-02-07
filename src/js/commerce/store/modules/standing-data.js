export default {
  namespaced: true,
  state: {
    countries: {},
    states: [],
    addresses: [],
    stores: []
  },
  mutations: {
    SET_COUNTRIES(state, payload) {
      state.countries = payload;
    },
    SET_STATES(state, payload) {
      state.states = payload;
    },    
    SET_ADDRESSES(state, payload) {
      state.addresses = payload;
    },
    SET_STORES(state, payload) {
      state.stores = payload;
    },        
  },
  actions: {
    getCountries({commit}) {
      return axios.get(`/api/countries`)
        .then((res) => {
          commit('SET_COUNTRIES', res.data);
          return res.data;
        });      
    },
    getStates({commit}) {
      return axios.get(`/api/states`)
        .then((res) => {
          commit('SET_STATES', res.data);
          return res.data;
        });      
    },
    getAddresses({commit}) {
      return axios.get(`/api/addresses`)
        .then((res) => {
          commit('SET_ADDRESSES', res.data);
          return res.data;
        });      
    },
    getStores({commit}) {
      return axios.get(`/api/stores`)
        .then((res) => {
          commit('SET_STORES', res.data);
          return res.data;
        });      
    },    
    getCategoryGroup({}, groupHandle) {
      return axios.get(`/api/categories/${groupHandle}`)
        .then((res) => {
          return res.data;
        });       
    },
    getCategoryGroupScoped({}, {groupHandle,scope}) {
      return axios.get(`/api/categories/${groupHandle}?scope=${scope}`)
        .then((res) => {
          return res.data;
        });       
    },    
    getCategory({}, {groupHandle, category}) {
      return axios.get(`/api/categories/${groupHandle}/${category}`)
        .then((res) => {
          return res.data;
        });
    },
    lookupPostcode({}, postcode) {
      return axios.get(`/api/addresses/lookup?postcode=${postcode}`)
        .then((res) => {
          return res.data;
        });
    }        
  }
};