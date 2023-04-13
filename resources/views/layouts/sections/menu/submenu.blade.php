<ul class="menu-sub">
    @if (isset($menu))
    @php
    // echo "<pre>";
    // print_r($menu);
    @endphp
        @foreach ($menu as $submenu)
            {{-- active menu method --}}
            @php
                $activeClass = null;
                $active = 'active open';
                $currentRouteName = Str::before(Route::currentRouteName(), '.');
               
                if ($currentRouteName == Str::before($submenu->slug, '.')) {
                    $activeClass = 'active';
                } elseif (isset($submenu->submenu)) {
                    if (gettype($submenu->slug) === 'array') {
                        foreach ($submenu->slug as $slug) {
                            if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                $activeClass = $active;
                            }
                        }
                    } else {
                        if (str_contains($currentRouteName, $submenu->slug) and strpos($currentRouteName, $submenu->slug) === 0) {
                            $activeClass = $active;
                        }
                    }
                }
            @endphp
            @if (auth()->user()->can($submenu->slug))
                <li class="menu-item {{ $activeClass }}">
                    <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                        class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                        @if (isset($submenu->target) and !empty($submenu->target)) target="_self" @endif>
                       
                        @if (isset($submenu->icon))
                            <iconify-icon icon="{{ $submenu->icon }}"></iconify-icon>
                            {{-- <iconify-icon icon="line-md:account"></iconify-icon> --}}
                        @endif
                        <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
                    </a>

                    {{-- submenu --}}
                    @if (isset($submenu->submenu))
                        @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                    @endif
                </li>
            @endif
        @endforeach
    @endif
</ul>
