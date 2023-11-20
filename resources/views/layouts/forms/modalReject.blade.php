<div class="modal fade modal-loading" id="modalReject"
	data-keyboard="false"
	data-backdrop="static"
	aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered">
		<div class="modal-content">
			<form action="{{ rut($routes.'.reject', $record->id) }}" method="POST" autocomplete="off">
				@csrf
				@method('POST')
				<div class="modal-header">
					<h4 class="modal-title">Reject Data</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body text-left">
					<div class="form-group">
						<label>{{ __('Catatan') }}</label>
						<div class="parent-group">
							<textarea name="note" class="form-control" placeholder="{{ __('Catatan') }}"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger base-form--submit-modal"
						data-swal-confirm="true"
						data-swal-title="{{ __('base.confirm.reject.title') }}"
						data-swal-text="{{ __('base.confirm.reject.text') }}"
						data-swal-ok="{{ __('base.confirm.reject.ok') }}"
						data-swal-cancel="{{ __('base.confirm.reject.cancel') }}">
						<i class="fa fa-times mr-1"></i>
						{{ __('Reject') }}
					</button>
				</div>
			</form>
			<div class="modal-loader pt-6" style="display: none;">
				<span class="spinner spinner-primary"></span>
			</div>
		</div>
	</div>
</div>
