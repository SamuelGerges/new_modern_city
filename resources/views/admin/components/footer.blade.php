    <footer class="main-footer">
        <strong>Copyright &copy; 2021-2022 <a href="{{ route('admin.home') }}">Error 404 Team</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->






<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>


<!-- daterangepicker -->
<script src="{{asset('admin/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

    <!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.js')}}"></script>


</body>
</html>
