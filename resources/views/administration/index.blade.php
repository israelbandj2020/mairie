<x-app-layout title="Administration">
  <section class="hello">
    <div>
      <h1>Administration</h1>
      <p>Documents administratifs et composition du bureau municipal.</p>
    </div>
  </section>

  <div class="duo" style="align-items:start">

    {{-- ========== DOCUMENTS ========== --}}
    <div class="card">
      <div class="card-head">
        <h3>Documents</h3>
        @can('gerer')
          <button type="button" id="toggleDocForm" class="btn-add">
            <svg class="i"><use href="#i-upload"/></svg>Ajouter un document
          </button>
        @endcan
      </div>

      @can('gerer')
        <div id="docFormPanel" style="display:none">
          <form id="docForm" method="POST" action="{{ route('administration.documents.store') }}"
                enctype="multipart/form-data" class="inline-form">
            @csrf
            <div class="field">
              <label class="field-label">Titre du document</label>
              <input type="text" name="titre" required class="f-input" placeholder="Ex: Règlement intérieur 2025">
            </div>
            <div class="field">
              <label class="field-label">Fichier PDF</label>
              <input type="file" name="fichier" required accept=".pdf" class="f-input">
            </div>
            <div style="display:flex;gap:8px;margin-top:4px">
              <button type="submit" class="btn-ok" style="height:36px;padding:0 14px;font-size:13.5px">
                <svg class="i"><use href="#i-check"/></svg>Enregistrer
              </button>
              <button type="button" id="cancelDocForm" class="btn-no" style="height:36px;padding:0 14px;font-size:13.5px">Annuler</button>
            </div>
          </form>
        </div>
      @endcan

      <label class="search-bar" style="margin-top:4px">
        <svg class="i"><use href="#i-search"/></svg>
        <input type="text" id="searchDocs" placeholder="Rechercher un document…">
      </label>

      <div class="items-list" id="documentsList">
        @forelse($documents as $document)
          <div class="item-row doc-item" data-search="{{ strtolower($document->titre) }}">
            <div class="item-icon" style="background:#e6f0ff;color:#2b5fac">
              <svg class="i"><use href="#i-file"/></svg>
            </div>
            <div class="item-body">
              <span class="item-title">{{ $document->titre }}</span>
              <span class="item-meta">{{ round($document->taille / 1024 / 1024, 2) }} Mo</span>
            </div>
            <div class="item-actions">
              <a href="{{ route('fichiers.voir', ['type' => 'administration', 'id' => $document->id]) }}"
                 target="_blank" class="btn-add" style="height:32px;padding:0 10px;font-size:12.5px">
                <svg class="i"><use href="#i-eye"/></svg>Voir
              </a>
              @can('gerer')
                <form method="POST" action="{{ route('administration.documents.destroy', $document) }}" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-no" style="border:none;height:32px;padding:0 10px;font-size:12.5px">Supprimer</button>
                </form>
              @endcan
            </div>
          </div>
        @empty
          <div class="empty-state" style="padding:28px 0">
            <svg class="i"><use href="#i-file"/></svg>
            <p>Aucun document administratif.</p>
          </div>
        @endforelse
      </div>
    </div>

    {{-- ========== BUREAU ========== --}}
    <div class="card">
      <div class="card-head">
        <h3>Bureau municipal</h3>
        @can('gerer')
          <button type="button" id="toggleMembreForm" class="btn-add">
            <svg class="i"><use href="#i-plus"/></svg>Ajouter
          </button>
        @endcan
      </div>

      @can('gerer')
        <div id="membreFormPanel" style="display:none">
          <form id="membreForm" method="POST" action="{{ route('administration.membres.store') }}"
                class="inline-form">
            @csrf
            <div class="field">
              <label class="field-label">Nom</label>
              <input type="text" name="nom" required class="f-input" placeholder="Nom de famille">
            </div>
            <div class="field">
              <label class="field-label">Prénom</label>
              <input type="text" name="prenom" required class="f-input" placeholder="Prénom">
            </div>
            <div class="field">
              <label class="field-label">Poste / Rôle</label>
              <input type="text" name="role" required class="f-input" placeholder="Ex: Maire, Adjoint, Secrétaire…">
            </div>
            <div style="display:flex;gap:8px;margin-top:4px">
              <button type="submit" class="btn-ok" style="height:36px;padding:0 14px;font-size:13.5px">
                <svg class="i"><use href="#i-check"/></svg>Enregistrer
              </button>
              <button type="button" id="cancelMembreForm" class="btn-no" style="height:36px;padding:0 14px;font-size:13.5px">Annuler</button>
            </div>
          </form>
        </div>
      @endcan

      <label class="search-bar" style="margin-top:4px">
        <svg class="i"><use href="#i-search"/></svg>
        <input type="text" id="searchMembres" placeholder="Rechercher un membre…">
      </label>

      <div class="items-list" id="membresList">
        @forelse($membres as $membre)
          <div class="item-row membre-item" data-search="{{ strtolower($membre->user->nom_complet . ' ' . $membre->role) }}">
            <div class="avatar" style="width:42px;height:42px;font-size:14px;background:var(--ok-soft);color:var(--forest-2);border:none;border-radius:50%">
              {{ $membre->user->initiales }}
            </div>
            <div class="item-body">
              <span class="item-title">{{ $membre->user->nom_complet }}</span>
              <span class="item-meta">{{ $membre->role }}</span>
            </div>
            @can('gerer')
              <div class="item-actions">
                <form method="POST" action="{{ route('administration.membres.destroy', $membre) }}" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-no" style="border:none;height:32px;padding:0 10px;font-size:12.5px">Retirer</button>
                </form>
              </div>
            @endcan
          </div>
        @empty
          <div class="empty-state" style="padding:28px 0">
            <svg class="i"><use href="#i-users"/></svg>
            <p>Aucun membre du bureau.</p>
          </div>
        @endforelse
      </div>
    </div>

  </div>

  @push('scripts')
  <script>
    // Toggle forms
    function setupToggle(btnId, panelId, cancelId) {
      const btn    = document.getElementById(btnId);
      const panel  = document.getElementById(panelId);
      const cancel = document.getElementById(cancelId);
      if (!btn || !panel) return;
      btn.addEventListener('click', () => { panel.style.display = panel.style.display === 'none' ? 'block' : 'none'; });
      if (cancel) cancel.addEventListener('click', () => { panel.style.display = 'none'; });
    }
    setupToggle('toggleDocForm',    'docFormPanel',    'cancelDocForm');
    setupToggle('toggleMembreForm', 'membreFormPanel', 'cancelMembreForm');

    // Search
    function setupSearch(inputId, itemClass) {
      const input = document.getElementById(inputId);
      if (!input) return;
      input.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.' + itemClass).forEach(el => {
          el.style.display = el.dataset.search.includes(q) ? '' : 'none';
        });
      });
    }
    setupSearch('searchDocs',    'doc-item');
    setupSearch('searchMembres', 'membre-item');
  </script>
  @endpush
</x-app-layout>
