import Vuex from 'vuex';
import Count from './modules/count';
import Article from './modules/article';

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
  	Count,
  	Article
  }
});

export default store;