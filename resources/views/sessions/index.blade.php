<x-app-layout title="Sessions">
  <section class="hello">
    <div>
      <div class="page-eyebrow">
        <span></span>Travaux du conseil
      </div>
      <h1>Sessions de travail</h1>
      <p>Historique et suivi des sessions du conseil municipal.</p>
    </div>
    @can('gerer')
      <a class="btn" href="{{ route('sessions.create') }}">
        <svg class="i"><use href="#i-plus"/></svg>Nouvelle session
      </a>
    @endcan
  </section>

  <div class="card">

    {{-- Barre de recherche --}}
    <label class="search-bar">
      <svg class="i"><use href="#i-search"/></svg>
      <input type="text" id="searchInput" placeholder="Rechercher par numéro, lieu, statut…">
    </label>

    {{-- Liste --}}
    <div class="items-list" id="sessionsList">
      @forelse($sessions as $session)
        <div class="item-row session-item"
             data-search="{{ strtolower($session->numero . ' ' . ($session->lieu ?? '') . ' ' . $session->statut_label) }}">

          {{-- Icône avec numéro --}}
          <div class="item-icon" style="background:linear-gradient(135deg,var(--ok-soft),#c6eada);color:var(--forest-2);font-family:var(--head);font-size:11px;font-weight:800;flex-direction:column;gap:0;line-height:1">
            <svg class="i" style="width:16px;height:16px;margin-bottom:1px"><use href="#i-gavel"/></svg>
            <span style="font-size:9px;font-weight:700;opacity:.7">Nº {{ $session->numero }}</span>
          </div>

          {{-- Corps --}}
          <div class="item-body">
            <span class="item-title">Session {{ $session->numero }}</span>
            <span class="item-meta">
              {{ $session->date->translatedFormat('d F Y') }}
              @if($session->lieu) &middot; <svg class="i" style="width:11px;height:11px;vertical-align:-2px;display:inline"><use href="#i-map-pin"/></svg> {{ $session->lieu }} @endif
            </span>
          </div>

          {{-- Actions --}}
          <div class="item-actions">
            @php
              $chipClass = match($session->statut) {
                'terminee'  => 'off2',
                'en_cours'  => 'pending',
                'annulee'   => 'wait',
                default     => ''
              };
            @endphp
            <span class="chip {{ $chipClass }}">{{ $session->statut_label }}</span>

            @foreach($session->documents as $doc)
              <span class="chip info" style="font-size:10.5px">{{ $doc->type_label }}</span>
            @endforeach

            <a href="{{ route('sessions.show', $session) }}" class="btn-add">
              <svg class="i"><use href="#i-arrow-right"/></svg>Voir
            </a>
          </div>
        </div>
      @empty
        <div class="empty-state">
          <svg class="i"><use href="#i-gavel"/></svg>
          <p>Aucune session enregistrée pour l'instant.</p>
          @can('gerer')
            <a href="{{ route('sessions.create') }}" class="btn-add" style="margin-top:4px">
              <svg class="i"><use href="#i-plus"/></svg>Créer la première session
            </a>
          @endcan
        </div>
      @endforelse
    </div>

    {{ $sessions->links() }}
  </div>

  @push('scripts')
  <script>
    document.getElementById('searchInput').addEventListener('input', function(e) {
      const q = e.target.value.toLowerCase();
      document.querySelectorAll('.session-item').forEach(el => {
        el.style.display = el.dataset.search.includes(q) ? '' : 'none';
      });
    });
  </script>
  @endpush
</x-app-layout>
