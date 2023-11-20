<script>
    // validation for file xlsx type
    $('.base-form--save-temp-files').on('change', function() {
        var file = $(this).val();
        var ext = file.split('.').pop().toLowerCase();
        if (ext != "xlsx" && ext != "xls") {
            $(this).val('');
            alert('File harus berformat .xlsx');
        }
    });
</script>