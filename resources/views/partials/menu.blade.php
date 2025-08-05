<style>
    #sidebar {
        background-image: linear-gradient(to top,#1995AD 40%, #A1D6E2 100%,#F1F1F2 40% );
    }

    #sidebar .c-sidebar-nav-link,
    .c-sidebar .c-sidebar-nav-dropdown-toggle {
        color: #fff;
        font-size: 18px;
        font-weight: 700;
    }

    .c-sidebar .c-sidebar-nav-dropdown-toggle .c-sidebar-nav-icon,
    .c-sidebar .c-sidebar-nav-link .c-sidebar-nav-icon {
        color: #fff;
    }

    .c-sidebar .c-active.c-sidebar-nav-dropdown-toggle,
    .c-sidebar .c-sidebar-nav-link.c-active {
       background: hsl(63, 95%, 49%);
        color: #fff;
    }

    .c-sidebar .c-sidebar-nav-dropdown-toggle:hover,
    .c-sidebar .c-sidebar-nav-link:hover {
        background: hsl(63, 95%, 49%);
        color: #fff;
    }

    .c-sidebar-brand-full img {
        height: 100px;
        width: 100%;
    }

    .c-header.c-header-fixed {
        background-image: linear-gradient(to right, #1995AD 30%, #A1D6E2 87%,  #F1F1F2 100%);
    }

    .logo-img {
        height: 85px;

    }

    .to-gray-800 {
        --tw-gradient-to: #1f2937;
    }

    .from-blue-900 {
        --tw-gradient-from: #1e3a8a;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(30, 58, 138, 0));
    }

    .bg-gradient-to-r {
        background-image: linear-gradient(to right, var(--tw-gradient-stops));
    }
</style>


<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    @php
    $businessName = \App\Models\Setting::first()->business_name ?? 'All in one service';
    @endphp
    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ $businessName }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>

        @can('student_access')
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.students.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/students") || request()->is("admin/students/*") ? "c-active" : "" }}">
                <i class="fa-fw fas fa-user-alt c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.student.title') }}
            </a>
        </li>
    @endcan

        @can('exam_management_access')
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.exam-managements.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/exam-managements") || request()->is("admin/exam-managements/*") ? "c-active" : "" }}">
                <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.examManagement.title') }}
            </a>
        </li>
    @endcan

    @can('exam_pattern_access')
    <li class="c-sidebar-nav-item">
        <a href="{{ route("admin.exam-patterns.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/exam-patterns") || request()->is("admin/exam-patterns/*") ? "c-active" : "" }}">
            <i class="fa-fw fas fa-eye-dropper c-sidebar-nav-icon">

            </i>
            {{ trans('cruds.examPattern.title') }}
        </a>
    </li>
    @endcan

    @can('category_management_access')
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.category-managements.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/category-managements") || request()->is("admin/category-managements/*") ? "c-active" : "" }}">
                <i class="fa-fw fas fa-atlas c-sidebar-nav-icon">

                </i>
                {{ trans('Category / Sections') }}
            </a>
        </li>
    @endcan

        @can('course_access')
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.courses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/courses") || request()->is("admin/courses/*") ? "c-active" : "" }}">
                <i class="fa-fw fas fa-calendar-times c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.course.title') }}
            </a>
        </li>
    @endcan
       
        @can('result_management_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.result-managements.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/result-managements") || request()->is("admin/result-managements/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-hand-holding c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.resultManagement.title') }}
                </a>
            </li>
        @endcan
       
        
     
       
        @can('home_content_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.home-contents.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/home-contents") || request()->is("admin/home-contents/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-comment c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.homeContent.title') }}
                </a>
            </li>
        @endcan
        
        @can('setting_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/settings") || request()->is("admin/settings/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.setting.title') }}
                </a>
            </li>
        @endcan

        @can('user_management_access')
        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                </i>
                {{ trans('Staff Users') }}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('permission_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.permission.title') }}
                        </a>
                    </li>
                @endcan
                @can('role_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.role.title') }}
                        </a>
                    </li>
                @endcan
                @can('user_access')
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                            <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.user.title') }}
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
        {{-- @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li> --}}
    </ul>

</div>