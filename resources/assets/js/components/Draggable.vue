<template>
	<draggable v-model="myArray" :options="{group:'item'}" @start="drag=true" @end="true">
	    <div class="draggable-item" v-for="(element,index) in myArray" :key="element.id">
		   	<input type="hidden" name="ids[]" v-model="element.id">
		   	<input type="text" name="titles[]" v-model="element.title">
		   	<input type="text" name="links[]" v-model="element.link">
		   	<button @click="removeItem(index)">Delete</button>
	    </div>
	    <button slot="footer" @click="increment">Add</button>
	</draggable>
</template>

<script>
	import draggable from 'vuedraggable'

	export default {
		data () {
			return {
				myArray: [
					{id: 1, title: '名稱1', link: '連結1', status: 'edit'},
					{id: 2, title: '名稱2', link: '連結2', status: 'edit'},
					{id: 3, title: '名稱3', link: '連結3', status: 'edit'},
					{id: 4, title: '名稱4', link: '連結4', status: 'edit'},
					{id: 5, title: '名稱5', link: '連結5', status: 'edit'},
					{id: 6, title: '名稱6', link: '連結6', status: 'edit'},
				],
			}
		},
        components: {
            draggable,
        },
        methods: {
        	increment () {
        		this.myArray.push({id: null, title: '', link: '', status: 'add'});
        		console.log(this.myArray);
        	},
        	removeItem (index) {
        		this.myArray.splice(index,1);
        	}
        }
    }
</script>

<style lang="scss">
	.draggable-item {
		width:200px;
		line-height:50px;
		padding:20px;
		border:2px blue solid;
		margin-right:10px;
		float:left;
		cursor: move;
	}
</style>