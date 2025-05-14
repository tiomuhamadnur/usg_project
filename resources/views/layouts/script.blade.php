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
            text: "{{ session('notify') }}"
        }).then(() => {
            if (window.history.replaceState) {
                window.history.replaceState(null, '', window.location.href);
            }
        });
    @elseif (session('notifyerror'))
        Swal.fire({
            icon: "error",
            title: "Ooopss!",
            text: "{{ session('notifyerror') }}"
        }).then(() => {
            if (window.history.replaceState) {
                window.history.replaceState(null, '', window.location.href);
            }
        });
    @elseif ($errors->any())
        @php
            $messageError = implode("\n", $errors->all());
        @endphp
        Swal.fire({
            icon: "error",
            title: "Ooopss!",
            text: "{{ $messageError }}"
        }).then(() => {
            if (window.history.replaceState) {
                window.history.replaceState(null, '', window.location.href);
            }
        });
    @endif
</script>
