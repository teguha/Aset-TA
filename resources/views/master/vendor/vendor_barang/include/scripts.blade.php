<script>
    $(document).ready(function() {
        $(".modal-dialog").removeClass("modal-md");
        $(".modal-dialog").addClass("modal-lg");
        $(".modal-dialog").attr("data-module-name", "vendor");
        $('#ref_province_id').on('change', function() {

            $('#ref_city_id').select2('destroy');
            let options = `<option disabled selected value=''>Pilih Salah Satu</option>`;
            $('#ref_city_id').html(options);
            $('#ref_city_id').select2();

            $.ajax({
                type: 'POST',
                url: '{{ url('/ajax/province/selectCity') }}',
                headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    province_id: $(this).val()
                },
                success: function(response, state, xhr) {
                    let options =
                        `<option disabled selected value=''>Pilih Salah Satu</option>`;

                    for (let item of response.results) {
                        options += `<option value='${item.id}'>${item.text}</option>`;
                    }
                    $('#ref_city_id').select2('destroy');
                    $('#ref_city_id').html(options);
                    $('#ref_city_id').select2();
                },
                error: function(a, b, c) {
                    console.log(a, b, c);
                }
            });
        })
    });
</script>
