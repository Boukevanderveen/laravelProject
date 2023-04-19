<ul class="nav nav-tabs">


    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="{{ route('admin.projects.edit', [$project]) }}">Bewerk project</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="{{ route('admin.projects.members', [$project]) }}">Leden</a>
    </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="{{ route('admin.projects.roles', [$project]) }}">Rollen</a>
    </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="{{ route('admin.projects.opentasks', [$project]) }}">Open taken</a>
    </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="{{ route('admin.projects.closedtasks', [$project]) }}">Afgeronde taken</a>
    </li>

    
  </ul>