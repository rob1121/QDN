<div class="section-box">
	<div class="section-header">
		CAUSE OF DEFECTS / FAILURE:
	</div>

	<div class="section-cod">
		<form-check-box :radio_value.sync="cod_value"
			:radios="cod_radios"
		>
		</form-check-box>
		<textarea class="description" placeholder="Input details"></textarea>
	</div>
</div>