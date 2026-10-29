<x-app-layout title="Gestion des comptes">
  <section class="hello">
    <div>
      <h1>Gestion des comptes</h1>
      <p>Valider, suspendre ou supprimer des comptes utilisateurs.</p>
    </div>
  </section>

  <div class="card">
    <div class="items-list">
      @forelse($comptes as $compte)
        @php
          $chipClass = match($compte->statut) {
            'valide'     => 'off2',
            'suspendu'   => 'wait',
            'en_attente' => 'pending',
            default      => ''
          };
        @endphp
        <div class="item-row">
          <div class="avatar" style="width:42px;height:42px;font-size:14px;border-radius:50%;background:var(--ok-soft);color:var(--forest-2);border:none;display:grid;place-items:center;font-family:var(--head);font-weight:700;flex:none">
            {{ $compte->initiales }}
          </div>
          <div class="item-body">
            <span class="item-title">{{ $compte->nom_complet }}</span>
            <span class="item-meta">{{ $compte->email }} &middot; {{ $compte->role_label }}</span>
          </div>
          <div class="item-actions">
            <span class="chip {{ $chipClass }}">{{ $compte->statut_label }}</span>

            @if($compte->statut === 'en_attente')
              <form method="POST" action="{{ route('comptes.valider', $compte) }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-ok" style="height:32px;padding:0 12px;font-size:13px">
                  <svg class="i"><use href="#i-check"/></svg>Valider
                </button>
              </form>
            @endif

            @if($compte->statut === 'valide')
              <form method="POST" action="{{ route('comptes.suspendre', $compte) }}"
                    style="display:inline" onsubmit="return confirm('Suspendre ce compte ?')">
                @csrf
                <button type="submit" class="btn-no" style="height:32px;padding:0 12px;font-size:13px;border:none">Suspendre</button>
              </form>
            @endif

            @if($compte->statut === 'suspendu')
              <form method="POST" action="{{ route('comptes.reactiver', $compte) }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-ok" style="height:32px;padding:0 12px;font-size:13px">Réactiver</button>
              </form>
            @endif

            @if($compte->id !== auth()->id())
              <form method="POST" action="{{ route('comptes.destroy', $compte) }}"
                    style="display:inline" onsubmit="return confirm('Supprimer ce compte ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-no" style="height:32px;padding:0 10px;font-size:12.5px;border:none">Supprimer</button>
              </form>
            @endif
          </div>
        </div>
      @empty
        <div class="empty-state">
          <svg class="i"><use href="#i-users"/></svg>
          <p>Aucun compte enregistré.</p>
        </div>
      @endforelse
    </div>

    {{ $comptes->links() }}
  </div>
</x-app-layout>
