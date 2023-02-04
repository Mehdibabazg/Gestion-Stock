<!-- Footer -->
    </div>
</div>
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2021 -</span><span> Made With <i class="fas fa-heart"></i> By MassarTech</span>
                </div>
            </div>
        </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/plugins/jquery-easing/jquery.easing.min.js"></script>

    <!-- Jquery-UI -->
    <script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>


    <!-- Custom scripts for all pages-->
    <script src="../assets/dist/js/sb-admin-2.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="../assets/plugins/sweetalert2/sweetalert2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/plugins/datatables/datetime.js"></script>

    <!-- daterangepicker -->
    <script src="../assets/plugins/moment/moment.min.js"></script>
    <script src="../assets/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Page level custom scripts -->
    <script src="../assets/dist/js/demo/datatables-demo.js"></script>
    <script>
function alert_success(script){
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });
    Toast.fire({
        icon: 'success',
        title: script
    })
}
function alert_error(script){
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500
    });
    Toast.fire({
        icon: 'warning',
        title: script
    })
}
$(document).ready(function() {
    console.log(window.location.pathname);
    var path = window.location.pathname;
    console.log(path.replace("gestion", "..").substring(1));
    $("#accordionSidebar a").each(function(index, element) {
        if ($(element).attr('href') == path.replace("gestion", "..").substring(1)) {
            if ($(element).hasClass('collapse-item') == true) {
                $(element).parent().parent().parent().addClass("active");
                $(element).parent().parent().addClass("show");
                $(element).addClass("active");
            } else {
                $(element).parent().addClass("active");
            }
        }
    });
});
$(document).ready(function() {
    $('.js-example-placeholder-single').select2({
        placeholder: "Séléctionner une Société",
        allowClear: true,
        dropdownParent: $('#transferer_devis')
    });
});
    var today = new Date();
    $('input[name="dates"]').daterangepicker({
        "endDate": today,
        "maxDate": today,
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "valider",
            "cancelLabel": "Annuler",
            "fromLabel": "Du",
            "toLabel": "Au",
            "customRangeLabel": "Custom",
            "daysOfWeek": ["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"],
            "monthNames": ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"],
            "firstDay": 1
        }
    });
    $(function() {
    $('input[type = text]').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});

    </script>
</body>

</html>