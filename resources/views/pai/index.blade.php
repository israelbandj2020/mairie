<x-app-layout title="Plans d'investissement">
  <section class="hello">
    <div>
      <div class="page-eyebrow">
        <span></span>Documents
      </div>
      <h1>Plans d'investissement</h1>
      <p>Documents PAI classés par année budgétaire.</p>
    </div>
    @can('gerer')
      <a class="btn" href="{{ route('pai.create') }}">
        <svg class="i"><use href="#i-plus"/></svg>Nouveau plan
      </a>
    @endcan
  </section>

  <div class="card">

    <label class="search-bar">
      <svg class="i"><use href="#i-search"/></svg>
      <input type="text" id="searchInput" placeholder="Rechercher par année ou nom de fichier…">
    </label>

    <div class="items-list" id="plansList">
      @forelse($plans as $plan)
        <div class="item-row plan-item"
             data-search="{{ strtolower($plan->annee . ' ' . $plan->nom_original) }}">

          <div class="item-icon" style="background:var(--purple-soft);color:var(--purple);font-family:var(--head);font-size:12px;font-weight:800">
            {{ $plan->annee }}
          </div>

          <div class="item-body">
            <span class="item-title">PAI {{ $plan->annee }}</span>
            <span class="item-meta">
              <svg class="i" style="width:11px;height:11px;vertical-align:-2px;display:inline"><use href="#i-file"/></svg>
              {{ $plan->nom_original }}
              &middot; {{ round($plan->taille / 1024 / 1024, 2) }} Mo
            </span>
          </div>

          <div class="item-actions">
            <span class="chip purple">{{ $plan->annee }}</span>
            <a href="{{ route('fichiers.voir', ['type' => 'pai', 'id' => $plan->id]) }}"
               target="_blank" class="btn-add">
              <svg class="i"><use href="#i-eye"/></svg>Voir PDF
            </a>
            @can('gerer')
              <form method="POST" action="{{ route('pai.destroy', $plan) }}"
                    style="display:inline" onsubmit="return confirm('Supprimer ce plan PAI ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">
                  <svg class="i"><use href="#i-trash"/></svg>Supprimer
                </button>
              </form>
            @endcan
          </div>
        </div>
      @empty
        <div class="empty-state">
          <svg class="i"><use href="#i-plan"/></svg>
          <p>Aucun plan d'investissement enregistré.</p>
          @can('gerer')
            <a href="{{ route('pai.create') }}" class="btn-add" style="margin-top:4px">
              <svg class="i"><use href="#i-plus"/></svg>Ajouter le premier PAI
            </a>
          @endcan
        </div>
      @endforelse
    </div>
  </div>

  @push('scripts')
  <script>
    document.getElementById('searchInput').addEventListener('input', function(e) {
      const q = e.target.value.toLowerCase();
      document.querySelectorAll('.plan-item').forEach(el => {
        el.style.display = el.dataset.search.includes(q) ? '' : 'none';
      });
    });
  </script>
  @endpush
</x-app-layout>
