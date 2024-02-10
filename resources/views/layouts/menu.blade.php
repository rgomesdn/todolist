<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>{{ __('common.Home') }}</p>
    </a>

    <a href="{{ route('task_index') }}" class="nav-link {{ Request::is('tasks') ? 'active' : '' }}">
        <i class="nav-icon fas fa-list"></i>
        <p>{{ __('task.title') }}</p>
    </a>
</li>
