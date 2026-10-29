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
            <span class="chip {{ $prioriteClass }}">{{ $besoin->priorite_label }}</span>
            <span class="chip {{ $statutClass }}">{{ $besoin->statut_label }}</span>
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
    document.getElementById('searchInput').addEventListener('input', function(e) {
      const q = e.target.value.toLowerCase();
      document.querySelectorAll('.besoin-item').forEach(el => {
        el.style.display = el.dataset.search.includes(q) ? '' : 'none';
      });
    });
  </script>
  @endpush
</x-app-layout>
