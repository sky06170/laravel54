<template>
	<div>
		<p>計數器:{{ count }}</p>
		<button @click="increment()">+</button>
		<button @click="decrement()">-</button>
		<input type="number" v-model="count">
	</div>
</template>

<script>
	export default {
		data () {
			return {
				count: 0
			}
		},
		methods: {
			increment() {
				return this.count++;
			},
			decrement() {
				if(this.count == 0) {
					return 0;
				}
				return this.count--;
			}
		}
	}
</script>