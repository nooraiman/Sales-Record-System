        <footer class="main-footer">
            <strong>Copyright &copy; 2020 <a href="#">SRS Teams</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>
    </div>
    <!-- /.wrapper -->

    <!-- jQuery -->
    <script src="<?php echo BASE; ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo BASE; ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo BASE; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- OverlayScrollbars -->
    <script src="<?php echo BASE; ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo BASE; ?>assets/js/adminlte.js"></script>
    <!-- DataTables -->
    <script src="<?php echo BASE; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo BASE; ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo BASE; ?>assets/plugins/select2/js/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="<?php echo BASE; ?>assets/plugins/moment/moment.min.js"></script>
    <script src="<?php echo BASE; ?>assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- Sidebbar Menu -->
    <script>
    /** add active class and stay opened when selected */
    var url = window.location;

    // for sidebar menu entirely but not cover treeview
    $('ul.nav-sidebar a').filter(function() {
        return this.href == url;
    }).addClass('active');

    // for treeview
    $('ul.nav-treeview a').filter(function() {
        return this.href == url;
    }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
    </script>