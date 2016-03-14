@if ($show && $qdn->closure->status != 'Q.a. Verification')
<!-- ========================================== APPROVER MESSAGE MODAL ================================================ -->
<div class="modal" id="approver-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="approver-msg">Add Comment (optional):</h4>
			</div>
			<div class="modal-body">
				<textarea
				rows        = "10"
				class       = "form-control"
				name        = "ApproverMessage"
				id          = "approver-message"
				placeholder = "Input Message. . ."
				></textarea>
			</div>
			<div class="modal-footer">
				<button
				type         = "button"
				id           = "confirm-btn"
				class        = "btn btn-success"
				data-dismiss = "modal"
				>
				Confirm Action
				<i class="fa fa-paper-plane"></i>
				</button>
				<button
				type         = "button"
				id           = "cancel-btn"
				class        = "btn btn-default"
				data-dismiss = "modal"
				>
				Cancel
				<i class="fa fa-edit"></i>
				</button>
			</div>
		</div>
	</div>
</div>
@endif
@if (! $show && $qdn->closure->status == 'Q.a. Verification')
<div class="col-md-3">
	<div class="col-md-11 text-center"><strong>{{ $qdn->closure->production."&nbsp;" }}</strong></div>
	<div class="col-md-11 text-center underline-label">
		<strong>{{ Str::upper('production') }}</strong>
	</div>
</div>
<div class="col-md-3">
	<div class="col-md-11 text-center"><strong>{{ $qdn->closure->process_engineering."&nbsp;" }}</strong></div>
	<div class="col-md-11 text-center underline-label">
		<strong>{{ Str::upper('process') }}</strong>
	</div>
</div>
<div class="col-md-3">
	<div class="col-md-11 text-center"><strong>{{ $qdn->closure->quality_assurance."&nbsp;" }}</strong></div>
	<div class="col-md-11 text-center underline-label">
		<strong>{{ Str::upper('quality assurance') }}</strong>
	</div>
</div>
<div class="col-md-3">
	<div class="col-md-11 text-center"><strong>{{ $qdn->closure->other_department."&nbsp;" }}</strong></div>
	<div class="col-md-11 text-center underline-label">
		<strong>{{ Str::upper('others') }}</strong>
	</div>
</div>
@endif