<template>
	<div>
		<p>文章ID : {{ id }}</p>
		<p>標題 : {{ title }}</p>
	</div>
</template>

<script>
	export default {
		data () {
			return {
				id: this.$route.params.id,
				title: ''
			}
		},
		created: function() {
			this.loadData();
		},
		methods: {
			loadData() {
				let articleId = this.id;
				this.title = '標題' + articleId;
			}
		}
	}
</script>