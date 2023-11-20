<div class="modal fade modal-loading" id="modalApproval"
	data-keyboard="false"
	data-backdrop="static"
	aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered">
		<div class="modal-content">
			<form action="{{ rut($routes.'.approve', $record->id) }}" method="POST" autocomplete="off">
				@csrf
				@method('POST')
				<div class="modal-header">
					<h4 class="modal-title">Approval Data</h4>
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
					<button type="submit" class="btn btn-primary base-form--submit-modal"
						data-swal-confirm="true"
						data-swal-title="{{ __('base.confirm.approve.title') }}"
						data-swal-text="{{ __('base.confirm.approve.text') }}"
						data-swal-ok="{{ __('base.confirm.approve.ok') }}"
						data-swal-cancel="{{ __('base.confirm.approve.cancel') }}">
						<i class="fa fa-check mr-1"></i>
						{{ __('Approval') }}
					</button>
				</div>
			</form>
			<div class="modal-loader pt-6" style="display: none;">
				<span class="spinner spinner-primary"></span>
			</div>
		</div>
	</div>
</div>
