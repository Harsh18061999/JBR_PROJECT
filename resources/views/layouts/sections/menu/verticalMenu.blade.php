<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link" style="position: absolute;left: 0;">
            <img src="{{ asset('/assets/img/JBR_Staffing_Solutions.jpg') }}" class="m-auto" alt="" height="200px"
                weight="250px">
            {{-- <span class="app-brand-logo demo">
        @include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menuData[0]->menu as $menu)
            {{-- adding active and open class if child is active --}}

            {{-- menu headers --}}
            @if (isset($menu->menuHeader))
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">{{ $menu->menuHeader }}</span>
                </li>
            @else
                {{-- active menu method --}}
                @php
                    // echo "<pre>";
                    // print_r($menuData[0]);die;
                    $activeClass = 'asd';
                    $currentRouteName = Str::before(Route::currentRouteName(), '.');
                    $route_prefix = Request::route()->getPrefix();
                    if (in_array($currentRouteName,$menu->menu_slug)) {
                        $activeClass = 'active open';
                    } elseif (isset($menu->submenu)) {
                        // echo "<pre>";
                        // print_r($menu);die;
                        // if (gettype($menu->slug) === 'array') {
                        // echo $submenu->slug;
                        // foreach ($menu->submenu as $submenu) {
                        //     if (str_contains($currentRouteName, $submenu->slug) and strpos($currentRouteName, $submenu->slug) === 0) {
                        //         $activeClass = 'active open';
                        //     } elseif (str_contains($route_prefix, $submenu->slug)) {
                        //         $activeClass = 'active open';
                        //     }
                        // }
                    }
                    // }
                @endphp
                @if (
                    $menu->slug == ''
                        ? true
                        : auth()->user()->can($menu->slug))
                    {{-- main menu --}}
                    <li class="menu-item {{ $activeClass }}">
                        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                            class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                            @if (isset($menu->target) and !empty($menu->target)) target="_self" @endif>
                            @isset($menu->icon)
                                <i class="{{ $menu->icon }}"></i>
                            @endisset
                            <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                        </a>

                        {{-- submenu --}}
                        @isset($menu->submenu)
                            @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                        @endisset
                    </li>
                @endif
            @endif
        @endforeach
    </ul>

</aside>
