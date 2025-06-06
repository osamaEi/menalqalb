<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <!-- Logo area with more bottom margin -->
  <div class="" style="margin-bottom: 15px;">
    <a href="{{ route('dashboard.index') }}" class="app-brand-link">
      <span class="app-brand-logo demo" style="  margin-right: 66px;">
          <span style="color: var(--bs-primary)">
              <img src="{{ asset('front/img/logo1.png')}}" style="width : 120px;" alt="Company Logo" class="logo-img">
          </span>
      </span>
      <span class="app-brand-text demo menu-text fw-semibold ms-2"></span>
    </a>
  </div>
 
  <!-- Space between logo and navigation -->
  <div style="margin-top: 25px; margin-bottom: 15px;"></div>
  
  <!-- Start of navigation with increased top padding -->
  <ul class="menu-inner py-1" style="padding-top: 10px;">
    <!-- Dashboards with increased margins -->
    <li class="menu-item {{ Request::is('dashboard.index*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="{{ route('dashboard.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ri-dashboard-line"></i>
        <div>{{ __('Dashboard') }}</div>
      </a>
    </li>
 
    <!-- Apps & Pages section with increased margins -->
    <li class="menu-header" style="margin-top: 30px; margin-bottom: 15px;">
      <span class="menu-header-text" >{{ __('Content Management') }}</span>
    </li>
   
    <li class="menu-item {{ Request::is('users*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ri-user-settings-line"></i>
        <div>{{ __('Users') }}</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ Request::routeIs('users.index') ? 'active' : '' }}">
          <a href="{{ route('users.index') }}" class="menu-link">
            <div>{{ __('Manage Users') }}</div>
          </a>
        </li>
    
      </ul>
    </li>

    <li class="menu-item {{ Request::is('categories*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ri-folder-chart-line"></i>
        <div>{{ __('Categories') }}</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ Request::routeIs('categories.index') ? 'active' : '' }}">
          <a href="{{ route('categories.index') }}" class="menu-link">
            <div>{{ __('Manage Categories') }}</div>
          </a>
        </li>
        
      </ul>
    </li>

    <li class="menu-item {{ Request::is('card_types*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ri-layout-grid-line"></i>
        <div>{{ __('Card Types') }}</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ Request::routeIs('card_types.index') ? 'active' : '' }}">
          <a href="{{ route('card_types.index') }}" class="menu-link">
            <div>{{ __('Manage Card Types') }}</div>
          </a>
        </li>
   
      </ul>
    </li>

    <li class="menu-item {{ Request::is('cards*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ri-gallery-line"></i>
        <div>{{ __('Cards & Locks') }}</div>
      </a>
      <ul class="menu-sub">


        
        <li class="menu-item {{ Request::routeIs('locks_w_ready_cards.index') ? 'active' : '' }}">
          <a href="{{ route('locks_w_ready_cards.index') }}" class="menu-link">
            <div>{{ __('Lock and Ready Card') }}</div>
          </a>
        </li>
        <li class="menu-item {{ Request::routeIs('locks.index') ? 'active' : '' }}">
          <a href="{{ route('locks.index') }}" class="menu-link">
            <div>{{ __('Lock Management') }}</div>
          </a>
        </li>

        <li class="menu-item {{ Request::routeIs('ready-cards.index') ? 'active' : '' }}">
          <a href="{{ route('ready-cards.index') }}" class="menu-link">
            <div>{{ __('Ready Cards') }}</div>
          </a>
        </li>
      </ul>
    </li>
   
    <li class="menu-item {{ Request::is('messages*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ri-gallery-line"></i>
        <div>{{ __('Greetings') }}</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ Request::routeIs('cards.index') ? 'active' : '' }}">
          <a href="{{ route('cards.index') }}" class="menu-link">
            <div>{{ __('Ready Greetings') }}</div>
          </a>
        </li>

        <li class="menu-item {{ Request::routeIs('messages.index') ? 'active' : '' }}">
          <a href="{{ route('messages.index') }}" class="menu-link">
            <div>{{ __('all Greetings') }}</div>
          </a>
        </li>
        <li class="menu-item {{ Request::routeIs('messages.create') ? 'active' : '' }}">
          <a href="{{ route('messages.create') }}" class="menu-link">
            <div>{{ __('Send Greetings') }}</div>
          </a>
        </li>
        
      </ul>
    </li>

    <li class="menu-item {{ Request::is('countries*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ri-gallery-line"></i>
        <div>{{ __('payments') }}</div>
      </a>
      <ul class="menu-sub">


        <li class="menu-item">
          <a href="{{ route('admin.bills.index') }}" class="menu-link">
            <div>{{ __('Bills') }}</div>
          </a>
        </li>
        
        <li class="menu-item">
          <a href="{{ route('admin.payments.index') }}" class="menu-link">
            <div>{{ __('Payments') }}</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ Request::is('admin.page*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ri-gallery-line"></i>
        <div>{{ __('Pages') }}</div>
      </a>
      <ul class="menu-sub">


        <li class="menu-item">
          <a href="{{ route('admin.pages.index') }}" class="menu-link">
            <div>{{ __('Pages') }}</div>
          </a>
        </li>
        
   
      </ul>
    </li>
    <li class="menu-item {{ Request::is('countries*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ri-gallery-line"></i>
        <div>{{ __('Settings') }}</div>
      </a>
      <ul class="menu-sub">


        <li class="menu-item {{ Request::routeIs('countries.index') ? 'active' : '' }}">
          <a href="{{ route('countries.index') }}" class="menu-link">
            <div>{{ __('Countries') }}</div>
          </a>
        </li>
        
        <li class="menu-item {{ Request::routeIs('packages.index') ? 'active' : '' }}">
          <a href="{{ route('packages.index') }}" class="menu-link">
            <div>{{ __('Package Management') }}</div>
          </a>
        </li>
        
        <li class="menu-item {{ Request::routeIs('admin.settings.index') ? 'active' : '' }}">
          <a href="{{ route('admin.settings.index') }}" class="menu-link">
            <div>{{ __('Settings') }}</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item {{ Request::is('countries*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ri-gallery-line"></i>
        <div>{{ __('Requests') }}</div>
      </a>
      <ul class="menu-sub">


        
        <li class="menu-item {{ Request::routeIs('requests.index') ? 'active' : '' }}">
          <a href="{{ route('requests.index') }}" class="menu-link">
            <div>{{ __('Requests') }}</div>
          </a>
        </li>

        {{-- <li class="menu-item {{ Request::routeIs('requests.create.lock') ? 'active' : '' }}">
          <a href="{{ route('requests.create.lock') }}" class="menu-link">
            <div>{{ __('Locks Requests') }}</div>
          </a>
        </li>
        <li class="menu-item {{ Request::routeIs('requests.create.ready-card') ? 'active' : '' }}">
          <a href="{{ route('requests.create.ready-card') }}" class="menu-link">
            <div>{{ __('Ready card Requests') }}</div>
          </a>
        </li> --}}
      </ul>
    </li>
    {{-- <!-- Orders & Sales section -->
    <li class="menu-header" style="margin-top: 30px; margin-bottom: 15px;">
      <span class="menu-header-text">{{ __('Orders & Sales') }}</span>
    </li>

    <li class="menu-item {{ Request::is('ready_cards*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ri-mail-send-line"></i>
        <div>{{ __('Ready Cards') }}</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ Request::routeIs('ready_cards.index') ? 'active' : '' }}">
          <a href="{{ route('ready_cards.index') }}" class="menu-link">
            <div>{{ __('Manage Ready Cards') }}</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ Request::is('orders*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ri-shopping-cart-line"></i>
        <div>{{ __('Orders') }}</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ Request::routeIs('orders.index') ? 'active' : '' }}">
          <a href="{{ route('orders.index') }}" class="menu-link">
            <div>{{ __('Manage Orders') }}</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- System section -->
    <li class="menu-header" style="margin-top: 30px; margin-bottom: 15px;">
      <span class="menu-header-text">{{ __('System') }}</span>
    </li>

    <li class="menu-item {{ Request::is('settings*') ? 'active open' : '' }}" style="margin-bottom: 8px;">
      <a href="{{ route('settings.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ri-settings-3-line"></i>
        <div>{{ __('Settings') }}</div>
      </a>
    </li> --}}

    <li class="menu-item" style="margin-bottom: 8px;">
      <a href="{{ route('logout') }}" class="menu-link" 
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="menu-icon tf-icons ri-logout-box-line"></i>
        <div>{{ __('Logout') }}</div>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </li>
  </ul>
</aside>