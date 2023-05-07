<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- DataTable -->
<script src="{{ asset('plugins/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('plugins/DataTables/datatables.moment.min.js')}}"></script>
<!-- sweetalert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('js/app.min.js') }}"></script>
<script>
     @if(Session::has('alert-type'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        var content = "{{ Session::get('message', 'info') }}";
        var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
        });
        switch(type){
            case 'info':
                Toast.fire({
                icon: 'info',
                title: content
                })
                break;
            case 'warning':
                Toast.fire({
                icon: 'warning',
                title: content
                })
                break;
            case 'success':
                Toast.fire({
                icon: 'success',
                title: content

                })
                break;
            case 'error':
                Toast.fire({
                icon: 'error',
                title: content
                })
                break;
        }
    @endif
    </script>