<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link {{ Str::endsWith(url()->current(), 'edit') ? 'active' : '' }}" aria-current="page" aria-current="page" href="{{ route('admin.projects.edit', [$project]) }}">Bewerk project</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Str::endsWith(url()->current(), 'members') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.projects.members', [$project]) }}">Leden</a>
    </li>
      <li class="nav-item">
        <a class="nav-link {{ Str::endsWith(url()->current(), 'roles') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.projects.roles', [$project]) }}">Rollen</a>
    </li>
      <li class="nav-item">
        <a class="nav-link {{ Str::endsWith(url()->current(), 'opentasks') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.projects.opentasks', [$project]) }}">Open taken</a>
    </li>
      <li class="nav-item">
        <a class="nav-link {{ Str::endsWith(url()->current(), 'closedtasks') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.projects.closedtasks', [$project]) }}">Afgeronde taken</a>
    </li>

    
  </ul>