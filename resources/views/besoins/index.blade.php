<x-app-layout title="Besoins prioritaires">
  <section class="hello">
    <div>
      <div class="page-eyebrow">
        <span></span>Travaux du conseil
      </div>
      <h1>Besoins prioritaires</h1>
      <p>Besoins exprimés par canton et leur état de traitement.</p>
    </div>
    <a class="btn" href="{{ route('besoins.create') }}">
      <svg class="i"><use href="#i-plus"/></svg>Nouveau besoin
    </a>
  </section>

  <div class="card">

    {{-- Filtres et tri --}}
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid var(--line)">
      @can('gerer')
        <div style="flex:1;min-width:150px">
          <label class="field-label" style="font-size:12px;margin-bottom:6px">Validation</label>
          <select name="statut_validation" id="filterValidation" class="f-select" style="height:38px;font-size:13px">
            <option value="">Tous</option>
            <option value="en_attente" {{ request('statut_validation') === 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="valide" {{ request('statut_validation') === 'valide' ? 'selected' : '' }}>Validés</option>
            <option value="rejete" {{ request('statut_validation') === 'rejete' ? 'selected' : '' }}>Rejetés</option>
          </select>
        </div>
      @endcan
      <div style="flex:1;min-width:200px">
        <label class="field-label" style="font-size:12px;margin-bottom:6px">Canton</label>
        <select name="canton_id" id="filterCanton" class="f-select" style="height:38px;font-size:13px">
          <option value="">Tous les cantons</option>
          @foreach($cantons as $canton)
            <option value="{{ $canton->id }}" {{ request('canton_id') == $canton->id ? 'selected' : '' }}>
              {{ $canton->nom }}
            </option>
          @endforeach
        </select>
      </div>
      <div style="flex:1;min-width:150px">
        <label class="field-label" style="font-size:12px;margin-bottom:6px">Priorité</label>
        <select name="priorite" id="filterPriorite" class="f-select" style="height:38px;font-size:13px">
          <option value="">Toutes</option>
          <option value="haute" {{ request('priorite') === 'haute' ? 'selected' : '' }}>Haute</option>
          <option value="moyenne" {{ request('priorite') === 'moyenne' ? 'selected' : '' }}>Moyenne</option>
          <option value="basse" {{ request('priorite') === 'basse' ? 'selected' : '' }}>Basse</option>
        </select>
      </div>
      <div style="flex:1;min-width:150px">
        <label class="field-label" style="font-size:12px;margin-bottom:6px">Statut</label>
        <select name="statut" id="filterStatut" class="f-select" style="height:38px;font-size:13px">
          <option value="">Tous</option>
          <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
          <option value="traite" {{ request('statut') === 'traite' ? 'selected' : '' }}>Traité</option>
          <option value="rejete" {{ request('statut') === 'rejete' ? 'selected' : '' }}>Rejeté</option>
        </select>
      </div>
      <div style="flex:1;min-width:150px">
        <label class="field-label" style="font-size:12px;margin-bottom:6px">Trier par</label>
        <select name="sort_by" id="sortBy" class="f-select" style="height:38px;font-size:13px">
          <option value="created_at" {{ request('sort_by', 'created_at') === 'created_at' ? 'selected' : '' }}>Date de création</option>
          <option value="priorite" {{ request('sort_by') === 'priorite' ? 'selected' : '' }}>Priorité</option>
          <option value="statut" {{ request('sort_by') === 'statut' ? 'selected' : '' }}>Statut</option>
          <option value="canton_id" {{ request('sort_by') === 'canton_id' ? 'selected' : '' }}>Canton</option>
        </select>
      </div>
      <div style="flex:0 0 auto">
        <label class="field-label" style="font-size:12px;margin-bottom:6px">&nbsp;</label>
        <button type="button" id="resetFilters" class="btn-no" style="height:38px;padding:0 16px">
          Réinitialiser
        </button>
      </div>
    </div>

    <label class="search-bar">
      <svg class="i"><use href="#i-search"/></svg>
      <input type="text" id="searchInput" placeholder="Rechercher par canton, description, statut…">
    </label>

    <div class="items-list" id="besoinsList">
      @forelse($besoins as $besoin)
        @php
          $prioriteClass = match($besoin->priorite) {
            'haute'  => 'wait',
            'basse'  => 'off2',
            default  => ''
          };
          $statutClass = match($besoin->statut) {
            'traite' => 'off2',
            'rejete' => 'wait',
            default  => 'pending'
          };
        @endphp
        <div class="item-row besoin-item"
             data-search="{{ strtolower($besoin->description . ' ' . $besoin->canton->nom . ' ' . $besoin->priorite_label . ' ' . $besoin->statut_label) }}">

          <div class="item-icon" style="background:var(--laterite-soft);color:var(--laterite)">
            <svg class="i"><use href="#i-pin"/></svg>
          </div>

          <div class="item-body">
            <span class="item-title">{{ $besoin->description }}</span>
            <span class="item-meta">
              <svg class="i" style="width:11px;height:11px;vertical-align:-2px;display:inline"><use href="#i-map-pin"/></svg>
              {{ $besoin->canton->nom }}
              &middot; Priorité : <strong>{{ $besoin->priorite_label }}</strong>
            </span>
          </div>

          <div class="item-actions">
            @if($besoin->statut_validation === 'en_attente')
              <span class="chip wait">En attente</span>
            @elseif($besoin->statut_validation === 'rejete')
              <span class="chip off2">Rejeté</span>
            @endif
            <span class="chip {{ $prioriteClass }}">{{ $besoin->priorite_label }}</span>
            <span class="chip {{ $statutClass }}">{{ $besoin->statut_label }}</span>
            @can('gerer')
              @if($besoin->statut_validation === 'en_attente')
                <form method="POST" action="{{ route('besoins.valider', $besoin) }}" style="display:inline">
                  @csrf
                  <button type="submit" class="btn-ok" style="height:32px;padding:0 10px;font-size:12.5px">
                    <svg class="i"><use href="#i-check"/></svg>Valider
                  </button>
                </form>
                <form method="POST" action="{{ route('besoins.rejeter', $besoin) }}" style="display:inline">
                  @csrf
                  <button type="submit" class="btn-no" style="height:32px;padding:0 10px;font-size:12.5px">
                    <svg class="i"><use href="#i-x"/></svg>Rejeter
                  </button>
                </form>
              @endif
            @endcan
            <a href="{{ route('besoins.show', $besoin) }}" class="btn-add">
              <svg class="i"><use href="#i-arrow-right"/></svg>Voir
            </a>
          </div>
        </div>
      @empty
        <div class="empty-state">
          <svg class="i"><use href="#i-pin"/></svg>
          <p>Aucun besoin prioritaire enregistré.</p>
          <a href="{{ route('besoins.create') }}" class="btn-add" style="margin-top:4px">
            <svg class="i"><use href="#i-plus"/></svg>Exprimer le premier besoin
          </a>
        </div>
      @endforelse
    </div>

    {{ $besoins->links() }}
  </div>

  @push('scripts')
  <script>
    // Filtres dynamiques
    function applyFilters() {
      const cantonId = document.getElementById('filterCanton').value;
      const priorite = document.getElementById('filterPriorite').value;
      const statut = document.getElementById('filterStatut').value;
      const sortBy = document.getElementById('sortBy').value;
      const filterValidation = document.getElementById('filterValidation');

      const url = new URL(window.location.href);
      if (cantonId) url.searchParams.set('canton_id', cantonId);
      else url.searchParams.delete('canton_id');

      if (priorite) url.searchParams.set('priorite', priorite);
      else url.searchParams.delete('priorite');

      if (statut) url.searchParams.set('statut', statut);
      else url.searchParams.delete('statut');

      if (sortBy) url.searchParams.set('sort_by', sortBy);
      else url.searchParams.delete('sort_by');

      if (filterValidation) {
        if (filterValidation.value) url.searchParams.set('statut_validation', filterValidation.value);
        else url.searchParams.delete('statut_validation');
      }

      window.location.href = url.toString();
    }

    document.getElementById('filterCanton').addEventListener('change', applyFilters);
    document.getElementById('filterPriorite').addEventListener('change', applyFilters);
    document.getElementById('filterStatut').addEventListener('change', applyFilters);
    document.getElementById('sortBy').addEventListener('change', applyFilters);
    const filterValidation = document.getElementById('filterValidation');
    if (filterValidation) filterValidation.addEventListener('change', applyFilters);

    document.getElementById('resetFilters').addEventListener('click', function() {
      window.location.href = '{{ route("besoins.index") }}';
    });

    // Recherche
    document.getElementById('searchInput').addEventListener('input', function(e) {
      const q = e.target.value.toLowerCase();
      document.querySelectorAll('.besoin-item').forEach(el => {
        el.style.display = el.dataset.search.includes(q) ? '' : 'none';
      });
    });
  </script>
  @endpush
</x-app-layout>
