<aside id="sidebar_main">
    <div class="sidebar_main_header" style="font-size: 17px!important; padding-top: 24px;">
        <div class="sidebar_logo">
            <a href="{{ route('home') }}" class="sSidebar_hide sidebar_logo_large">
                <strong>Shivam Travels</strong>
                {{--<img class="logo_regular" src="{{ asset('assets/img/logo_main.png') }}" alt="" height="15" width="71"/>--}}
                {{--<img class="logo_light" src="{{ asset('assets/img/logo_main_white.png') }}" alt="" height="15" width="71"/>--}}
            </a>
            <a href="{{ route('home') }}" class="sSidebar_show sidebar_logo_small">
                <img class="logo_regular" src="{{ asset('assets/img/logo_main_small.png') }}" alt="" height="32" width="32"/>
                <img class="logo_light" src="{{ asset('assets/img/logo_main_small_light.png') }}" alt="" height="32" width="32"/>
            </a>
        </div>
    </div>

    <div class="menu_section">
        <ul>
            <?php $currentRoute = Request::route()->getName(); ?>

            <li title="Dashboard" class="{{ ($currentRoute == 'home') ? 'current_section' : '' }}">
                <a href="{{ route('home') }}">
                    <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                    <span class="menu_title">Home</span>
                </a>
            </li>
            <li title="Work" class="{{ (Request::is('work') || Request::is('work/*')) ? 'current_section' : '' }}">
                <a href="{{ route('work.create') }}">
                    <span class="menu_icon"><i class="material-icons">&#xE87B;</i></span>
                    <span class="menu_title">Daily Work</span>
                </a>
            </li>
            <li title="Report" class="{{ (Request::is('report') || Request::is('report/*')) ? 'current_section' : '' }}">
                <a href="#">
                    <span class="menu_icon"><i class="material-icons">&#xE241;</i></span>
                    <span class="menu_title">Report</span>
                </a>
            </li>
            <li title="Staff" class="{{ (Request::is('staff') || Request::is('staff/*')) ? 'current_section' : '' }}">
                <a href="{{ route('staff.index') }}">
                    <span class="menu_icon"><i class="material-icons">&#xE87C;</i></span>
                    <span class="menu_title">Staff</span>
                </a>
            </li>
            <li title="Bus" class="{{ (Request::is('bus') || Request::is('bus/*')) ? 'current_section' : '' }}">
                <a href="{{ route('bus.index') }}">
                    <span class="menu_icon"><i class="material-icons">&#xE8F1;</i></span>
                    <span class="menu_title">Bus</span>
                </a>
            </li>
            <li title="Salary" class="{{ (Request::is('salary') || Request::is('salary/*')) ? 'current_section' : '' }}">
                <a href="{{ route('salary.index') }}">
                    <span class="menu_icon"><i class="material-icons">&#xE53E;</i></span>
                    <span class="menu_title">Salary</span>
                </a>
            </li>
            <li title="Settings" class="{{ (Request::is('expense') || Request::is('expense/*')) ? 'current_section' : '' }}">
                <a href="javascript:void(0)">
                    <span class="menu_icon"><i class="material-icons">&#xE8B8;</i></span>
                    <span class="menu_title">Settings</span>
                </a>
                <ul>
                    <li title="Expense" class="{{ (Request::is('expense') || Request::is('expense/*')) ? 'act_item' : '' }}">
                        <a href="{{ route('expense.index') }}">Expense</a>
                    </li>
                    <li title="Remove Oldest Work Record" class="{{ (Request::is('work/remove')) ? 'act_item' : '' }}">
                        <a href="#">Remove Oldest Work</a>
                    </li>
                </ul>
            </li>
            <li title="Sticky Notes">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="menu_icon"><i class="material-icons">&#xE7F4;</i></span>
                    <span class="menu_title">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>