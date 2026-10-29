<x-app-layout title="Délibérations">
  <section class="hello">
    <div>
      <div class="page-eyebrow">
        <span></span>Travaux du conseil
      </div>
      <h1>Délibérations</h1>
      <p>Décisions officielles et délibérations du conseil municipal.</p>
    </div>
    @can('gerer')
      <a class="btn" href="{{ route('deliberations.create') }}">
        <svg class="i"><use href="#i-plus"/></svg>Nouvelle délibération
      </a>
    @endcan
  </section>

  <div class="card">

    <label class="search-bar">
      <svg class="i"><use href="#i-search"/></svg>
      <input type="text" id="searchInput" placeholder="Rechercher par titre, date, session…">
    </label>

    <div class="items-list" id="deliberationsList">
      @forelse($deliberations as $deliberation)
        <div class="item-row deliberation-item"
             data-search="{{ strtolower($deliberation->titre . ' ' . $deliberation->date->translatedFormat('d F Y') . ' ' . ($deliberation->session->numero ?? 'Sans session')) }}">

          <div class="item-icon" style="background:var(--blue-soft);color:var(--blue)">
            <svg class="i"><use href="#i-scale"/></svg>
          </div>

          <div class="item-body">
            <span class="item-title">{{ $deliberation->titre }}</span>
            <span class="item-meta">
              {{ $deliberation->date->translatedFormat('d F Y') }}
              @if($deliberation->session)
                &middot; Session {{ $deliberation->session->numero }}
              @else
                &middot; <em style="font-style:normal;opacity:.65">Sans session liée</em>
              @endif
            </span>
          </div>

          <div class="item-actions">
            <a href="{{ route('fichiers.voir', ['type' => 'deliberation', 'id' => $deliberation->id]) }}"
               target="_blank" class="btn-add">
              <svg class="i"><use href="#i-eye"/></svg>Voir PDF
            </a>
            @can('gerer')
              <form method="POST" action="{{ route('deliberations.destroy', $deliberation) }}"
                    style="display:inline" onsubmit="return confirm('Supprimer cette délibération ?')">
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
          <svg class="i"><use href="#i-scale"/></svg>
          <p>Aucune délibération enregistrée pour l'instant.</p>
          @can('gerer')
            <a href="{{ route('deliberations.create') }}" class="btn-add" style="margin-top:4px">
              <svg class="i"><use href="#i-plus"/></svg>Créer la première délibération
            </a>
          @endcan
        </div>
      @endforelse
    </div>

    {{ $deliberations->links() }}
  </div>

  @push('scripts')
  <script>
    document.getElementById('searchInput').addEventListener('input', function(e) {
      const q = e.target.value.toLowerCase();
      document.querySelectorAll('.deliberation-item').forEach(el => {
        el.style.display = el.dataset.search.includes(q) ? '' : 'none';
      });
    });
  </script>
  @endpush
</x-app-layout>
