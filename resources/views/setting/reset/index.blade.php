@extends('layouts.app')

@section('title', __($title))

@section('content')

@section('content-header')
    @include('layouts.base.subheader')
@show

@section('content-body')
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-refresh-arrow text-primary"></i>
                    </span>
                    <h3 class="card-label">
                        Reset Data
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h6>Kosongkan Data Transaksi</h6>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-8 mb-2">
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped bg-primary" id="progress-reset" role="progressbar"
                                style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                    </div>
                    <form action="{{ rut('setting.reset') }}" method="POST" id="form-reset" autocomplete="off">
                        @csrf
                        <input type="hidden" name="type" id="type" value="reset_transaction">
                    </form>
                    <div class="col-lg-4">
                        <button type="button" data-type="btn-process" id="btn-reset" data-id="reset"
                            class="btn btn-primary"><i class="flaticon2-settings mr-1"></i>Proses</button>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-6">
                        <h6>Fresh Install</h6>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-8 mb-2">
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped bg-primary" id="progress-migrate"
                                role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                                aria-valuemax="100">0%</div>
                        </div>
                    </div>
                    <form action="{{ rut('setting.reset') }}" method="POST" id="form-migrate" autocomplete="off">
                        @csrf
                        <input type="hidden" name="type" id="type" value="migrate_fresh">
                    </form>
                    <div class="col-lg-4">
                        <button type="button" data-type="btn-process" id="btn-migrate" data-id="migrate"
                            class="btn btn-primary"><i class="flaticon2-settings mr-1"></i>Proses</button>
                    </div>
                </div>
            </div>
        </div>
    @show
    <script>
        $('[data-type=btn-process]').click(function() {
            var id = $(this).data('id');
            var form = $(`#form-${ id }`);
            var destination = form.attr('action');

            if (id.length < 1) {
                $.gritter.add({
                    title: 'Failed!',
                    text: 'Data is invalid!',
                    image: BaseUtil.getUrl('assets/media/ui/cross.png'),
                    sticky: false,
                    time: '3000'
                });

                return false;
            }

            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Aksi ini akan menghapus semua data transaksi yang ada",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $('#btn-migrate').prop('disabled', true);
                    $('#btn-reset').prop('disabled', true);

                    $(`#progress-${id}`).attr('aria-valuenow', 0)
                        .css('width', 0 + '%').text(0 +
                            '%');

                    $.ajax({
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(e) {
                                if (e.lengthComputable) {
                                    var percent = Math.round((e.loaded / e.total) *
                                        100);
                                    $(`#progress-${id}`).attr('aria-valuenow', percent)
                                        .css('width', percent + '%').text(percent +
                                            '%');
                                }
                            });

                            return xhr;
                        },
                        method: "POST",
                        data: new FormData(form[0]),
                        url: destination,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.code == 200) {
                                $.gritter.add({
                                    title: 'Success!',
                                    text: response.message,
                                    image: BaseUtil.getUrl('assets/media/ui/check.png'),
                                    sticky: false,
                                    time: '3000'
                                });
                            } else {
                                $(`#progress-${id}`).attr('aria-valuenow', 0)
                                    .css('width', 0 + '%').text(0 +
                                        '%');

                                $.gritter.add({
                                    title: 'Failed!',
                                    text: response.message,
                                    image: BaseUtil.getUrl('assets/media/ui/cross.png'),
                                    sticky: false,
                                    time: '3000'
                                });
                            }

                            $('#btn-migrate').prop('disabled', false);
                            $('#btn-reset').prop('disabled', false);
                        },
                        error: function(err) {
                            $('#btn-migrate').prop('disabled', false);
                            $('#btn-reset').prop('disabled', false);

                            $.gritter.add({
                                title: 'Failed!',
                                text: 'Something went wrong, please try again later!',
                                image: BaseUtil.getUrl('assets/media/ui/cross.png'),
                                sticky: false,
                                time: '3000'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
