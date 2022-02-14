export default {
  namespaced: true,
  state: {
    searchRequest: {
      brandCategory: [],
      childCategory: [],
      filterCategory: [],
      limit: 10,
      offset: 0,
      query: null,
      rootCategory: null,
      sort: null
    },
    searchResults: null,
  },
  mutations: { 
    SET_SEARCH_REQUEST(state, payload)
    {
      state.searchRequest = payload;
    },
    SET_SEARCH_RESULTS(state, payload)
    {
      state.searchResults = payload;
    }
  },
  actions: {
    initCatalogue({commit}, {initialSearchRequest, initialSearchResults}) {

      commit('SET_SEARCH_REQUEST', initialSearchRequest);
      commit('SET_SEARCH_RESULTS', initialSearchResults);

      return Promise.resolve();
    },
    searchProducts({commit, state}, newSearchRequest) {

      let endpointUrl = `/api/product/search`;

      if (newSearchRequest.rootCategory) {
        endpointUrl = `${endpointUrl}/${newSearchRequest.rootCategory}`;
      }

      endpointUrl = `${endpointUrl}?`;

      if (newSearchRequest.childCategory && newSearchRequest.childCategory.length > 0) {
        newSearchRequest.childCategory.forEach(childCategory => {
          endpointUrl = `${endpointUrl}childCategory[]=${childCategory}&`;
        });
      }

      if (newSearchRequest.filterCategory && newSearchRequest.filterCategory.length > 0) {
        newSearchRequest.filterCategory.forEach(filterCategory => {
          endpointUrl = `${endpointUrl}filterCategory[]=${filterCategory}&`;
        });
      }

      if (newSearchRequest.brandCategory && newSearchRequest.brandCategory.length > 0) {
        newSearchRequest.brandCategory.forEach(brandCategory => {
          endpointUrl = `${endpointUrl}brandCategory[]=${brandCategory}&`;
        });
      }

      return axios.get(endpointUrl)
        .then((res) => {
          commit('SET_SEARCH_RESULTS', res.data);
          commit('SET_SEARCH_REQUEST', newSearchRequest);
          return res.data;
        });

    },          
  }
};