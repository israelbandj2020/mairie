<aside class="side" id="menu" aria-label="Navigation principale">

  {{-- Brand --}}
  <div class="brand">
    <div class="brand-mark">
      <svg class="i"><use href="#i-scale"/></svg>
    </div>
    <div>
      <b>Espace du conseil</b>
      <span>{{ config('conseil.commune', 'Conseil municipal') }}</span>
    </div>
  </div>

  <nav class="nav">

    {{-- Principal --}}
    <a href="{{ route('dashboard') }}"
       aria-current="{{ request()->is('') ? 'page' : null }}">
      <svg class="i"><use href="#i-home"/></svg>Tableau de bord
    </a>

    <div class="nav-label">Travaux du conseil</div>

    <a href="{{ route('sessions.index') }}"
       aria-current="{{ request()->is('sessions*') ? 'page' : null }}">
      <svg class="i"><use href="#i-gavel"/></svg>Sessions
    </a>

    <a href="{{ route('deliberations.index') }}"
       aria-current="{{ request()->is('deliberations*') ? 'page' : null }}">
      <svg class="i"><use href="#i-scale"/></svg>Délibérations
    </a>

    <a href="{{ route('besoins.index') }}"
       aria-current="{{ request()->is('besoins*') ? 'page' : null }}">
      <svg class="i"><use href="#i-pin"/></svg>Besoins prioritaires
    </a>

    <div class="nav-label">Documents</div>

    <a href="{{ route('pai.index') }}"
       aria-current="{{ request()->is('pai*') ? 'page' : null }}">
      <svg class="i"><use href="#i-plan"/></svg>Plans d'investissement
    </a>

    <a href="{{ route('budgets.index') }}"
       aria-current="{{ request()->is('budgets*') ? 'page' : null }}">
      <svg class="i"><use href="#i-coin"/></svg>Budgets
    </a>

    <a href="{{ route('administration.index') }}"
       aria-current="{{ request()->is('administration*') ? 'page' : null }}">
      <svg class="i"><use href="#i-book"/></svg>Administration
    </a>

    @can('gerer')
      <div class="nav-label">Gestion</div>
      <a href="{{ route('comptes.index') }}"
         aria-current="{{ request()->is('comptes*') ? 'page' : null }}">
        <svg class="i"><use href="#i-users"/></svg>Comptes
        <span class="badge" id="navBadge" {{ ($comptesEnAttente ?? 0) > 0 ? '' : 'hidden' }}>{{ $comptesEnAttente ?? 0 }}</span>
      </a>
      <a href="{{ route('users.index') }}"
         aria-current="{{ request()->is('users*') ? 'page' : null }}">
        <svg class="i"><use href="#i-user"/></svg>Utilisateurs
      </a>
    @endcan

    <div class="sep"></div>

    <a href="{{ route('parametres.edit') }}"
       aria-current="{{ request()->is('parametres*') ? 'page' : null }}">
      <svg class="i"><use href="#i-cog"/></svg>Paramètres
    </a>

  </nav>

  {{-- User footer --}}
  <div class="me">
    <div class="me-card">
      <div class="avatar">{{ auth()->user()->initiales }}</div>
      <div style="min-width:0;flex:1">
        <b style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block">{{ auth()->user()->nom_complet }}</b>
        <small>{{ auth()->user()->estAdmin() ? 'Administrateur' : 'Conseiller' }}</small>
      </div>
    </div>
    <form method="POST" action="{{ route('logout') }}" style="width:100%;margin-top:0">
      @csrf
      <button type="submit" class="btn-sidebar-logout">
        <svg class="i" style="width:14px;height:14px"><use href="#i-log-out"/></svg>
        Se déconnecter
      </button>
    </form>
  </div>

</aside>
