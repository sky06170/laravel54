const state = {
	count: 0
};

const getters = {
	count: (state) => state.count,
};

const mutations = {
	increment (state) {
		state.count++;
	},
	decrement (state) {
		if(state.count > 0) {
			state.count--;
		}
	}
};

const actions = {
	increment ({ commit, state }, object) {
		commit('increment');
	},
	decrement ({ commit, state }, object) {
		commit('decrement')
	}
};

export default {
	state,
	getters,
	mutations,
	actions,
}