<x-app-layout title="Plaintes">
  <section class="hello">
    <div>
      <h1>Plaintes</h1>
      <p>Gestion des plaintes des citoyens.</p>
    </div>
  </section>

  <div class="card">

    {{-- Filtres et tri --}}
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid var(--line)">
      <div style="flex:1;min-width:150px">
        <label class="field-label" style="font-size:12px;margin-bottom:6px">Validation</label>
        <select name="statut_validation" id="filterValidation" class="f-select" style="height:38px;font-size:13px">
          <option value="">Tous</option>
          <option value="en_attente" {{ request('statut_validation') === 'en_attente' ? 'selected' : '' }}>En attente</option>
          <option value="valide" {{ request('statut_validation') === 'valide' ? 'selected' : '' }}>Validés</option>
          <option value="rejete" {{ request('statut_validation') === 'rejete' ? 'selected' : '' }}>Rejetés</option>
        </select>
      </div>
      <div style="flex:1;min-width:150px">
        <label class="field-label" style="font-size:12px;margin-bottom:6px">Type de plainte</label>
        <select name="type_plainte" id="filterType" class="f-select" style="height:38px;font-size:13px">
          <option value="">Tous</option>
          <option value="executif" {{ request('type_plainte') === 'executif' ? 'selected' : '' }}>Exécutif</option>
          <option value="agent_mairie" {{ request('type_plainte') === 'agent_mairie' ? 'selected' : '' }}>Agent de la mairie</option>
          <option value="conseiller" {{ request('type_plainte') === 'conseiller' ? 'selected' : '' }}>Conseiller</option>
          <option value="autres" {{ request('type_plainte') === 'autres' ? 'selected' : '' }}>Autres</option>
        </select>
      </div>
      <div style="flex:1;min-width:150px">
        <label class="field-label" style="font-size:12px;margin-bottom:6px">Trier par</label>
        <select name="sort_by" id="sortBy" class="f-select" style="height:38px;font-size:13px">
          <option value="created_at" {{ request('sort_by', 'created_at') === 'created_at' ? 'selected' : '' }}>Date de création</option>
          <option value="type_plainte" {{ request('sort_by') === 'type_plainte' ? 'selected' : '' }}>Type de plainte</option>
        </select>
      </div>
      <div style="flex:0 0 auto">
        <label class="field-label" style="font-size:12px;margin-bottom:6px">&nbsp;</label>
        <button type="button" id="resetFilters" class="btn-no" style="height:38px;padding:0 16px">
          Réinitialiser
        </button>
      </div>
    </div>

    @forelse($plaintes as $plainte)
      <div class="item" data-search="{{ strtolower($plainte->nom . ' ' . $plainte->prenom . ' ' . $plainte->description) }}">
        <div class="item-body">
          <span class="item-title">{{ $plainte->description }}</span>
          <span class="item-meta">
            <svg class="i" style="width:11px;height:11px;vertical-align:-2px;display:inline"><use href="#i-user"/></svg>
            {{ $plainte->prenom }} {{ $plainte->nom }}
            &middot; Type : <strong>{{ $plainte->type_plainte_label }}</strong>
          </span>
        </div>

        <div class="item-actions">
          @if($plainte->statut_validation === 'en_attente')
            <span class="chip wait">En attente</span>
          @elseif($plainte->statut_validation === 'rejete')
            <span class="chip off2">Rejeté</span>
          @endif
          @if($plainte->statut_validation === 'en_attente')
            <form method="POST" action="{{ route('plaintes.valider', $plainte) }}" style="display:inline">
              @csrf
              <button type="submit" class="btn-ok" style="height:32px;padding:0 10px;font-size:12.5px">
                <svg class="i"><use href="#i-check"/></svg>Valider
              </button>
            </form>
            <form method="POST" action="{{ route('plaintes.rejeter', $plainte) }}" style="display:inline">
              @csrf
              <button type="submit" class="btn-no" style="height:32px;padding:0 10px;font-size:12.5px">
                <svg class="i"><use href="#i-x"/></svg>Rejeter
              </button>
            </form>
          @endif
          <a href="{{ route('plaintes.show', $plainte) }}" class="btn-add">
            <svg class="i"><use href="#i-arrow-right"/></svg>Voir
          </a>
        </div>
      </div>
    @empty
      <div class="empty-state">
        <svg class="i"><use href="#i-alert"/></svg>
        <p>Aucune plainte enregistrée.</p>
      </div>
    @endforelse

    {{ $plaintes->links() }}

  </div>

  @push('scripts')
  <script>
    // Filtres dynamiques
    function applyFilters() {
      const statutValidation = document.getElementById('filterValidation').value;
      const typePlainte = document.getElementById('filterType').value;
      const sortBy = document.getElementById('sortBy').value;

      const url = new URL(window.location.href);
      if (statutValidation) url.searchParams.set('statut_validation', statutValidation);
      else url.searchParams.delete('statut_validation');

      if (typePlainte) url.searchParams.set('type_plainte', typePlainte);
      else url.searchParams.delete('type_plainte');

      if (sortBy) url.searchParams.set('sort_by', sortBy);
      else url.searchParams.delete('sort_by');

      window.location.href = url.toString();
    }

    document.getElementById('filterValidation').addEventListener('change', applyFilters);
    document.getElementById('filterType').addEventListener('change', applyFilters);
    document.getElementById('sortBy').addEventListener('change', applyFilters);

    document.getElementById('resetFilters').addEventListener('click', function() {
      window.location.href = '{{ route("plaintes.index") }}';
    });
  </script>
  @endpush
</x-app-layout>
