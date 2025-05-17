<script>
    $(document).ready(function() {
        $('#deleteModal').on('show.bs.modal', function(e) {
            var url = $(e.relatedTarget).data('url');

            document.getElementById("deleteForm").action = url;
        });

        $('#exportModal').on('show.bs.modal', function(e) {
            var url = $(e.relatedTarget).data('url');

            document.getElementById("exportForm").action = url;
        });

        function exportExcel() {
            $('#datatable-excel').click();
            console.log('klik');
        }
    })
</script>

<script>
    @if (session('notify'))
        Swal.fire({
            title: "Yeheeey!",
            icon: "success",
            text: @json(session('notify'))
        }).then(() => {
            if (window.history.replaceState) {
                window.history.replaceState(null, '', window.location.href);
            }
        });
    @elseif (session('notifyerror'))
        Swal.fire({
            icon: "error",
            title: "Ooopss!",
            text: @json(session('notifyerror'))
        }).then(() => {
            if (window.history.replaceState) {
                window.history.replaceState(null, '', window.location.href);
            }
        });
    @elseif ($errors->any())
        @php
            $errorsList = $errors->all();
            $messageError = collect($errorsList)
                ->map(function ($msg, $index) use ($errorsList) {
                    return count($errorsList) > 1
                        ? ($index + 1) . '. ' . e($msg)
                        : e($msg);
                })
                ->implode('<br>');
        @endphp
        Swal.fire({
            icon: "error",
            title: "Ooopss!",
            html: @json($messageError) // pakai html, bukan text
        }).then(() => {
            if (window.history.replaceState) {
                window.history.replaceState(null, '', window.location.href);
            }
        });
    @endif
</script>

