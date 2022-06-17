@php
$configData = Helper::applClasses();
@endphp
<div
class="main-menu menu-fixed {{ $configData['theme'] === 'dark' || $configData['theme'] === 'semi-dark' ? 'menu-dark' : 'menu-light' }} menu-accordion menu-shadow"
data-scroll-to-active="true">
<div class="navbar-header">
  <ul class="nav navbar-nav flex-row">
    <li class="nav-item me-auto">
      <a class="" href="{{ url('/') }}">
        <span class="brand-logo">
          <img src="{{ asset('public/images/main-logo.png') }}" class="">
        </span>
      </a>
    </li>
    <li class="nav-item nav-toggle">
      <a class="nav-link modern-nav-toggle pe-0" data-toggle="collapse">
        <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
        <i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc"
        data-ticon="disc"></i>
      </a>
    </li>
  </ul>
</div>
<div class="shadow-bottom"></div>
<div class="main-menu-content">
  <ul class="navigation navigation-main mt-1" id="main-menu-navigation" data-menu="menu-navigation">
    <li class="nav-item {{ (request()->route()->getName() == 'dashboard' || request()->route()->getName() == 'user-dashboard') ? "active" : "" }}">
      <a href="@if(Auth::user()->user_role->role_id != 3){{ route('dashboard') }}@else{{ route('user-dashboard') }}@endif" class="d-flex align-items-center" target="_self">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        <span class="menu-title text-truncate">Dashboard</span>
      </a>
    </li>
    @if(Auth::user()->user_role->role_id != 3)
      <li class="navigation-header">
        <span>Pages</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
      </li>
      <li class="nav-item has-sub">
        <a href="javascript:void(0)" class="d-flex align-items-center" target="_self">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          <span class="menu-title text-truncate">Customer</span>
        </a>
        <ul class="menu-content">
          <li class="{{ (request()->route()->getName() == 'customers.index') ? "active" : "" }}"">
            <a href="{{ route('customers.index') }}" class="d-flex align-items-center" target="_self">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
              <span class="menu-item text-truncate">List</span>
            </a>
          </li>
          <li class="{{ (request()->route()->getName() == 'customers.create') ? "active" : "" }}"">
            <a href="{{ route('customers.create') }}" class="d-flex align-items-center" target="_self">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
              <span class="menu-item text-truncate">Add</span>
            </a>
          </li>
        </ul>
      </li>
      @if(Auth::user()->user_role->role_id == 1 || Auth::user()->user_role->role_id == 4)
        <li class="nav-item has-sub">
          <a href="javascript:void(0)" class="d-flex align-items-center" target="_self">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
            <span class="menu-title text-truncate">Business</span>
          </a>
          <ul class="menu-content">
            <li class="{{ (request()->route()->getName() == 'businesses.index') ? "active" : "" }}"">
              <a href="{{ route('businesses.index') }}" class="d-flex align-items-center" target="_self">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                <span class="menu-item text-truncate">List</span>
              </a>
            </li>
            <li class="{{ (request()->route()->getName() == 'businesses.create') ? "active" : "" }}"">
              <a href="{{ route('businesses.create') }}" class="d-flex align-items-center" target="_self">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span class="menu-item text-truncate">Add</span>
              </a>
            </li>
          </ul>
        </li>
      @endif
      @if(Auth::user()->user_role->role_id == 1 || Auth::user()->user_role->role_id == 4)
        <li class="{{ (request()->route()->getName() == 'pet-processing') ? "active" : "" }}"">
          <a href="{{ route('pet-processing') }}" class="d-flex align-items-center" target="_self">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
            <span class="menu-item text-truncate">Pet Processing</span>
          </a>
        </li>
        @endif
      @if(Auth::user()->user_role->role_id == 1)
        <li class="nav-item has-sub">
          <a href="javascript:void(0)" class="d-flex align-items-center" target="_self">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
            <span class="menu-title text-truncate">Users</span>
          </a>
          <ul class="menu-content">
            <li class="{{ (request()->route()->getName() == 'users.index') ? "active" : "" }}"">
              <a href="{{ route('users.index') }}" class="d-flex align-items-center" target="_self">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                <span class="menu-item text-truncate">List</span>
              </a>
            </li>
            <li class="{{ (request()->route()->getName() == 'users.create') ? "active" : "" }}"">
              <a href="{{ route('users.create') }}" class="d-flex align-items-center" target="_self">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span class="menu-item text-truncate">Add</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-sub">
          <a href="javascript:void(0)" class="d-flex align-items-center" target="_self">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            <span class="menu-title text-truncate">URNs Display</span>
          </a>
          <ul class="menu-content">
            <li class="{{ (request()->route()->getName() == 'urn-display.index') ? "active" : "" }}"">
              <a href="{{ route('urn-display.index') }}" class="d-flex align-items-center" target="_self">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                <span class="menu-item text-truncate">List</span>
              </a>
            </li>
            <li class="{{ (request()->route()->getName() == 'urn-display.create') ? "active" : "" }}"">
              <a href="{{ route('urn-display.create') }}" class="d-flex align-items-center" target="_self">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span class="menu-item text-truncate">Add</span>
              </a>
            </li>
          </ul>
        </li>
      @endif
      <li class="nav-item">
        <a href="#" class="d-flex align-items-center" target="_self">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
          <span class="menu-title text-truncate">Settings</span>
        </a>
      </li>
    @endif
    @if(Auth::user()->user_role->role_id == 3)
      <li class="navigation-header">
        <span>Manage Details</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
      </li>
      <li class="nav-item {{ (request()->route()->getName() == 'customers.front-edit') ? "active" : "" }}">
        <a href="{{ route('customers.front-edit', [Auth::user()->id]) }}" class="d-flex align-items-center" target="_self">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
          <span class="menu-title text-truncate">Edit Profile</span>
        </a>
      </li>
    @endif
  </ul>
</div>
</div>
<!-- END: Main Menu-->
