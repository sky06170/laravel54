<template>
	<draggable v-model="myArray" :options="{group:'people'}" @start="drag=true" @end="drag=false">
	   <div class="item" v-for="element in myArray" :key="element.id">
	   	{{element.name}}
	   </div>
	</draggable>
</template>

<script>
	import draggable from 'vuedraggable'

	export default {
		data () {
			return {
				myArray: [
					{id: 1, name: '名稱1'},
					{id: 2, name: '名稱2'},
					{id: 3, name: '名稱3'},
					{id: 4, name: '名稱4'},
					{id: 5, name: '名稱5'},
					{id: 6, name: '名稱6'},
				],
			}
		},
        components: {
            draggable,
        },
    }
</script>

<style lang="scss">
	.item {
		width:200px;
		line-height:50px;
		padding:20px;
		border:2px blue solid;
		margin-right:10px;
		float:left;
	}
</style>