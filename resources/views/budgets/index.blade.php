<x-app-layout title="Budgets">
  <section class="hello">
    <div>
      <div class="page-eyebrow">
        <span></span>Documents
      </div>
      <h1>Budgets</h1>
      <p>Consultez et gérez les budgets de la commune.</p>
    </div>
    @can('gerer')
      <a href="{{ route('budgets.create') }}" class="btn">
        <svg class="i"><use href="#i-plus"/></svg>Ajouter un budget
      </a>
    @endcan
  </section>

  <div class="card">

    <label class="search-bar">
      <svg class="i"><use href="#i-search"/></svg>
      <input type="text" id="searchInput" placeholder="Rechercher par année, type, montant…">
    </label>

    <div class="items-list" id="budgetsList">
      @forelse($budgets as $budget)
        <div class="item-row budget-item"
             data-search="{{ strtolower($budget->annee . ' ' . $budget->type_label . ' ' . number_format($budget->montant, 0, ',', ' ')) }}">

          <div class="item-icon" style="background:var(--sun-soft);color:#7a5208;font-family:var(--head);font-size:12px;font-weight:800">
            {{ $budget->annee }}
          </div>

          <div class="item-body">
            <span class="item-title">{{ $budget->type_label }}</span>
            <span class="item-meta">
              <svg class="i" style="width:11px;height:11px;vertical-align:-2px;display:inline"><use href="#i-coin"/></svg>
              {{ number_format($budget->montant, 0, ',', ' ') }} FCFA
            </span>
          </div>

          <div class="item-actions">
            <span class="chip pending">{{ $budget->annee }}</span>
            <a href="{{ route('fichiers.voir', ['type' => 'budget', 'id' => $budget->id]) }}"
               target="_blank" class="btn-add">
              <svg class="i"><use href="#i-eye"/></svg>Voir PDF
            </a>
            @can('gerer')
              <form method="POST" action="{{ route('budgets.destroy', $budget) }}"
                    style="display:inline" onsubmit="return confirm('Supprimer ce budget ?')">
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
          <svg class="i"><use href="#i-coin"/></svg>
          <p>Aucun budget enregistré pour l'instant.</p>
          @can('gerer')
            <a href="{{ route('budgets.create') }}" class="btn-add" style="margin-top:4px">
              <svg class="i"><use href="#i-plus"/></svg>Ajouter le premier budget
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
      document.querySelectorAll('.budget-item').forEach(el => {
        el.style.display = el.dataset.search.includes(q) ? '' : 'none';
      });
    });
  </script>
  @endpush
</x-app-layout>
