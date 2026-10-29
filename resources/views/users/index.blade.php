<x-app-layout title="Utilisateurs">
  <section class="hello">
    <div>
      <h1>Utilisateurs</h1>
      <p>Liste et gestion des comptes utilisateurs de la plateforme.</p>
    </div>
    @can('gerer')
      <a class="btn" href="{{ route('users.create') }}">
        <svg class="i"><use href="#i-plus"/></svg>Nouvel utilisateur
      </a>
    @endcan
  </section>

  <div class="card">
    <label class="search-bar">
      <svg class="i"><use href="#i-search"/></svg>
      <input type="text" id="searchInput" placeholder="Rechercher par nom, email, rôle…">
    </label>

    <div class="items-list" id="usersList">
      @forelse($users as $user)
        @php
          $statutClass = match($user->statut) {
            'valide'     => 'off2',
            'suspendu'   => 'wait',
            'en_attente' => 'pending',
            default      => ''
          };
        @endphp
        <div class="item-row user-item"
             data-search="{{ strtolower($user->nom . ' ' . $user->prenom . ' ' . $user->email . ' ' . ($user->telephone ?? '') . ' ' . $user->role . ' ' . $user->statut_label) }}">

          <div class="avatar" style="width:42px;height:42px;font-size:14px;border-radius:50%;background:var(--ok-soft);color:var(--forest-2);border:none;display:grid;place-items:center;font-family:var(--head);font-weight:700;flex:none">
            {{ $user->initiales }}
          </div>

          <div class="item-body">
            <span class="item-title">{{ $user->nom_complet }}</span>
            <span class="item-meta">
              {{ $user->email }}
              @if($user->telephone) &middot; {{ $user->telephone }} @endif
            </span>
          </div>

          <div class="item-actions">
            <span class="chip info" style="font-size:11px">{{ $user->role_label }}</span>
            <span class="chip {{ $statutClass }}" style="font-size:11px">{{ $user->statut_label }}</span>
            @can('gerer')
              <a href="{{ route('users.edit', $user) }}" class="btn-add" style="height:32px;padding:0 10px;font-size:12.5px">
                <svg class="i"><use href="#i-edit"/></svg>Modifier
              </a>
              <form method="POST" action="{{ route('users.destroy', $user) }}"
                    style="display:inline" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-no" style="border:none;height:32px;padding:0 10px;font-size:12.5px">Supprimer</button>
              </form>
            @endcan
          </div>
        </div>
      @empty
        <div class="empty-state">
          <svg class="i"><use href="#i-user"/></svg>
          <p>Aucun utilisateur enregistré.</p>
        </div>
      @endforelse
    </div>

    {{ $users->links() }}
  </div>

  @push('scripts')
  <script>
    document.getElementById('searchInput').addEventListener('input', function(e) {
      const q = e.target.value.toLowerCase();
      document.querySelectorAll('.user-item').forEach(el => {
        el.style.display = el.dataset.search.includes(q) ? '' : 'none';
      });
    });
  </script>
  @endpush
</x-app-layout>
