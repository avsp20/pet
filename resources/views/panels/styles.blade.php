<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" href="{{ asset('public/vendors/css/vendors.min.css') }}" />
@yield('vendor-style')
@if(request()->route()->getName() != "user-register")
	<link rel="stylesheet" href="{{ asset('public/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
@endif
<link rel="stylesheet" href="{{ asset('public/vendors/css/forms/wizard/bs-stepper.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendors/css/pickers/pickadate/pickadate.css') }}">
<link rel="stylesheet" href="{{ asset('public/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" href="{{ asset('public/css/core.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/base/themes/dark-layout.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/base/themes/bordered-layout.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/base/themes/semi-dark-layout.css') }}" />

@php $configData = Helper::applClasses(); @endphp

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" href="{{ asset('public/css/base/core/menu/menu-types/vertical-menu.css') }}" />
@yield('page-style')
<link rel='stylesheet' href="{{ asset('public/vendors/css/extensions/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/base/plugins/forms/form-validation.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/base/plugins/forms/form-wizard.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/base/plugins/forms/pickers/form-pickadate.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/base/pages/app-todo.css') }}">
<!-- laravel style -->
{{--<link rel="stylesheet" href="{{ asset('public/css/overrides.css') }}" />--}}

<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" href="{{ asset('public/css/style.css') }}" />