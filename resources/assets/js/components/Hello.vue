<template>
	<div>
		<h1>{{ msg1 }}</h1>
		<p class="hello">Hi {{ name || '匿名者' }}</p>
		<p>{{ msg2 }}</p>
	</div>
</template>

<script>
    export default {
        props: ['name'],
        data () {
            return {
            	msg1: 'Hello!',
                msg2: 'This is a Laravel with Vue Demo.'
            }
        }
    }
</script>

<style>
.hello {
    font-size: 2em;
    color: green;
}
</style>
