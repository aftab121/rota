<footer class="footer text-right">
	© 2017. ROTA. All rights reserved. 
</footer>
<!-- jQuery  -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/detect.js') }}"></script>
<script src="{{ asset('js/fastclick.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('js/waves.js') }}"></script>
<script src="{{ asset('js/wow.min.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>

<script src="{{ asset('plugins/peity/jquery.peity.min.js') }}"></script>

<!-- jQuery  -->
<script src="{{ asset('plugins/waypoints/lib/jquery.waypoints.js') }}"></script>
<script src="{{ asset('plugins/counterup/jquery.counterup.min.js') }}"></script>


<script src="{{ asset('plugins/raphael/raphael-min.js') }}"></script>

<script src="{{ asset('plugins/jquery-knob/jquery.knob.js') }}"></script>


<!--data table-->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/responsive.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.scroller.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.colVis.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.fixedColumns.min.js') }}"></script>
<script src="{{ asset('pages/datatables.init.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
	 $('body').on('click','.emp-name input',function(){
			if($(this).is(":checked")) {
				$(this).parent().addClass("checked");
			} else {
				$(this).parent().removeClass("checked");
			}
		});
    });


$(function() {
		$('#toggle-one').bootstrapToggle();
	})
</script>

<!--bootstrap switch-->
<script src="{{ asset('plugins/switch/bootstrap-toggle.min.js') }}"></script>


<!--data table-->
<script src="{{ asset('plugins/moment/moment.js') }}"></script>


<script src="{{ asset('js/jquery.core.js') }}"></script>
<script src="{{ asset('js/jquery.app.js') }}"></script>
<!-- Date and time picker  --> 
<script src="{{ asset('plugins/timepicker/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('pages/jquery.form-pickers.init.js') }}"></script>
<!-- End Date and time picker  --> 
        