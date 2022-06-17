<!-- BEGIN: Vendor JS-->
<script src="{{ asset('public/vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{asset('public/vendors/js/ui/jquery.sticky.js') }}"></script>
@yield('vendor-script')
@if(request()->route()->getName() != "user-register")
	<script src="{{ asset('public/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('public/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
	<script src="{{ asset('public/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('public/vendors/js/tables/datatable/responsive.bootstrap5.js') }}"></script>
@endif
<script src="{{ asset('public/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
<script src="{{ asset('public/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('public/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('public/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('public/js/scripts/extensions/ext-component-sweet-alerts.js') }}"></script>
@if(request()->route()->getName() != "user-register")
	<script src="{{ asset('public/js/scripts/forms/form-wizard.js') }}"></script>
@endif
<script src="{{ asset('public/js/scripts/forms/pickers/form-pickers.js') }}"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset('public/js/core/app-menu.js') }}"></script>
<script src="{{ asset('public/js/core/app.js') }}"></script>

<!-- custome scripts file for user -->
<script src="{{ asset('public/js/core/scripts.js') }}"></script>

{{--@if($configData['blankPage'] === false)
<script src="{{ asset('public/js/scripts/customizer.js') }}"></script>
@endif--}}
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
