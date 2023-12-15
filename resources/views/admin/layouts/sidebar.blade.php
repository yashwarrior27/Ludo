<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo" style="justify-content: space-between;padding:50px;">
        <img src="{{url('images/logo.jfif')}}" class="w-50 " style="border-radius: 50% ;box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 10px 0 rgba(0, 0, 0, 0.19);" alt="">

        <a href="{{url('/logout')}}" class="btn btn-danger btn-sm" ><i class='bx bx-log-out'></i></a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>

    </div>

    <div class="menu-inner-shadow " style="margin-top: 50px"></div>

    <ul class="menu-inner py-1 mt-2 ">
      <!-- Dashboard -->

      <li class="menu-item  {{ request()->segment(1)=='dashboard' ?'active': '' }}">
        <a href="{{url("/dashboard")}}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>
      <li class="menu-item  {{ request()->segment(1)=='deposits' ?'active': '' }}">
        <a href="{{url("/deposits")}}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-bank' ></i>
          <div data-i18n="Analytics">Deposits</div>
        </a>
      </li>
      <li class="menu-item  {{ request()->segment(1)=='games' ?'active': '' }}">
        <a href="{{url("/games")}}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-dice-6' ></i>
          <div data-i18n="Analytics">Games</div>
        </a>
      </li>
      <li class="menu-item  {{ request()->segment(1)=='withdrawals' ?'active': '' }}">
        <a href="{{url("/withdrawals")}}" class="menu-link">
            <i class='menu-icon tf-icons bx bx-transfer'></i>
          <div data-i18n="Analytics">Withdrawals</div>
        </a>
      </li>
      <li class="menu-item  {{ request()->segment(1)=='categories' ?'active': '' }}">
        <a href="{{url("/categories")}}" class="menu-link">
            <i class='menu-icon tf-icons bx bxs-category-alt'></i>
          <div data-i18n="Analytics">Categories</div>
        </a>
      </li>
    </ul>
  </aside>
