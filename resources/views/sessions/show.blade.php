<x-app-layout title="Session {{ $session->numero }}">
  <section class="hello">
    <div>
      <div class="page-eyebrow">
        <span></span>Sessions de travail
      </div>
      <h1>Session {{ $session->numero }}</h1>
      <p>
        {{ $session->date->translatedFormat('d F Y') }}
        @if($session->lieu) &middot; {{ $session->lieu }} @endif
      </p>
    </div>
    @can('gerer')
      <div style="display:flex;gap:8px;align-items:center">
        <a href="{{ route('sessions.edit', $session) }}" class="btn-add">
          <svg class="i"><use href="#i-edit"/></svg>Modifier
        </a>
        <form method="POST" action="{{ route('sessions.destroy', $session) }}"
              onsubmit="return confirm('Supprimer cette session ?')" style="display:inline">
          @csrf @method('DELETE')
          <button type="submit" class="btn-danger">
            <svg class="i"><use href="#i-trash"/></svg>Supprimer
          </button>
        </form>
      </div>
    @endcan
  </section>

  <div class="duo">
    {{-- Informations --}}
    <div class="card card-accent">
      <div class="card-head">
        <h3>Informations</h3>
        @php
          $chipClass = match($session->statut) {
            'terminee'  => 'off2',
            'en_cours'  => 'pending',
            'annulee'   => 'wait',
            default     => ''
          };
        @endphp
        <span class="chip {{ $chipClass }}">{{ $session->statut_label }}</span>
      </div>

      <div class="info-row">
        <span class="info-label">Numéro</span>
        <span class="info-value">{{ $session->numero }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Date</span>
        <span class="info-value">{{ $session->date->translatedFormat('d F Y') }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Lieu</span>
        <span class="info-value">{{ $session->lieu ?? '—' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Statut</span>
        <span class="info-value">{{ $session->statut_label }}</span>
      </div>
    </div>

    {{-- Documents --}}
    <div class="card">
      <div class="card-head">
        <h3>Documents</h3>
        @can('gerer')
          <form method="POST" action="{{ route('sessions.ajouter-document', $session) }}"
                enctype="multipart/form-data" id="uploadForm" style="display:flex;gap:8px;align-items:center">
            @csrf
            <select name="type" class="f-select" style="height:34px;font-size:12.5px;padding:0 28px 0 10px;width:auto">
              <option value="ordre_du_jour">Ordre du jour</option>
              <option value="ordre_du_jour_valide">OJ validé</option>
              <option value="compte_rendu">Compte rendu</option>
              <option value="decision">Décision</option>
            </select>
            <input type="file" name="fichier" id="fichierInput" style="display:none" onchange="this.form.submit()">
            <button type="button" onclick="document.getElementById('fichierInput').click()" class="btn-add">
              <svg class="i"><use href="#i-upload"/></svg>Ajouter
            </button>
          </form>
        @endcan
      </div>

      @if($session->documents->count() > 0)
        <ul class="sessions-list">
          @foreach($session->documents as $doc)
            <li>
              <div class="sn" style="display:flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:12px;background:var(--blue-soft);color:var(--blue)">
                <svg class="i" style="width:20px;height:20px"><use href="#i-file"/></svg>
              </div>
              <div class="s-title">
                <b>{{ $doc->type_label }}</b>
                <span>{{ $doc->nom_original }} &middot; {{ round($doc->taille / 1024 / 1024, 2) }} Mo</span>
              </div>
              <div class="docs">
                <a href="{{ route('fichiers.voir', ['type' => 'session-document', 'id' => $doc->id]) }}"
                   target="_blank" class="btn-add" style="height:30px;padding:0 10px;font-size:12px">
                  <svg class="i"><use href="#i-eye"/></svg>Voir
                </a>
                @can('gerer')
                  <form method="POST" action="{{ route('sessions.supprimer-document', [$session, $doc]) }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-danger" style="height:30px;padding:0 10px;font-size:12px">Supprimer</button>
                  </form>
                @endcan
              </div>
            </li>
          @endforeach
        </ul>
      @else
        <div class="empty-state" style="padding:28px 0">
          <svg class="i"><use href="#i-file"/></svg>
          <p>Aucun document pour cette session.</p>
        </div>
      @endif
    </div>
  </div>
</x-app-layout>
