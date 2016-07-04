{{-- vuejs resource is at vue-report.js --}}
<div id="app">
	<form-section
	        title="CONTAINMENT ACTION/S:"
	        :actions.sync="containmentAction"
	        :names="cnNames"
	>
	</form-section>

	<form-section
	        title="CORRECTIVE ACTION/S TAKEN:"
	        :actions.sync="correctiveAction"
	        :names="caNames"
	>
	</form-section>

	<form-section
	        title="PREVENTIVE ACTION/S TAKEN:"
	        :actions.sync="preventiveAction"
	        :names="paNames"
	>
	</form-section>

</div>