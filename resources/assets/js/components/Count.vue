<template>
	<div>
		<p>count:{{ count }}</p>
		<button @click="incrementBtn()">+</button>
		<button @click="decrementBtn()">-</button>
	</div>
</template>

<script>
	import { mapGetters } from 'vuex';

	export default {
		computed: {
			...mapGetters([
				'count'
			]),
		},
		methods: {
			incrementBtn () {
				this.$store.dispatch('increment', [])
			},
			decrementBtn () {
				this.$store.dispatch('decrement', [])
			}
		}
	}
</script>