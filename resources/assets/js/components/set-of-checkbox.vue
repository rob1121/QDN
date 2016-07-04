<template>
	<div class="content">
		<div class="radios">
			<label v-for="radio in radios" class="radio-label">
				<input type="radio" name="radios" v-model="radio_value" :value="radio">
				{{ radio | capitalize }}
			</label>
		</div>
	</div>
</template>

<style lang="sass">

	.radios {
		width: 100%;
		display: flex;
		justify-content: space-between;
		padding-bottom: 10px;

		.radio-label {
			font-weight: normal
		}
	}

	input:focus {
		outline: none !important;
	}
</style>

<script >
	export default {
		props: ['radios', 'radio_value']
	}
</script>