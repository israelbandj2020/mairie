<x-app-layout title="Nouvelle délibération">
  <section class="hello">
    <div>
      <div class="page-eyebrow">
        <span></span>Délibérations
      </div>
      <h1>Nouvelle délibération</h1>
      <p>Enregistrer une délibération officielle du conseil municipal.</p>
    </div>
    <a href="{{ route('deliberations.index') }}" class="btn-no">
      <svg class="i"><use href="#i-arrow-left"/></svg>Retour
    </a>
  </section>

  <div class="card" style="max-width:660px">
    <form method="POST" action="{{ route('deliberations.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="form-section">
        <div class="form-section-title">
          <svg class="i" style="width:16px;height:16px;color:var(--forest-2)"><use href="#i-calendar"/></svg>
          Rattachement
        </div>
        <div class="field-row">
          <div class="field" style="margin-bottom:0">
            <label class="field-label">Session liée</label>
            <select name="session_travail_id" required class="f-select">
              @foreach($sessions as $session)
                <option value="{{ $session->id }}" {{ old('session_travail_id') == $session->id ? 'selected' : '' }}>
                  Session {{ $session->numero }} — {{ $session->date->translatedFormat('d F Y') }}
                </option>
              @endforeach
            </select>
            @error('session_travail_id') <p class="field-error">{{ $message }}</p> @enderror
          </div>
          <div class="field" style="margin-bottom:0">
            <label class="field-label">Date de la délibération</label>
            <input type="date" name="date" value="{{ old('date') }}" required class="f-input">
            @error('date') <p class="field-error">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      <div class="form-section">
        <div class="form-section-title">
          <svg class="i" style="width:16px;height:16px;color:var(--blue)"><use href="#i-scale"/></svg>
          Contenu
        </div>
        <div class="field">
          <label class="field-label">Titre de la délibération</label>
          <input type="text" name="titre" value="{{ old('titre') }}" required class="f-input"
                 placeholder="Ex : Approbation du budget primitif 2025">
          @error('titre') <p class="field-error">{{ $message }}</p> @enderror
        </div>
        <div class="field" style="margin-bottom:0">
          <label class="field-label">Description</label>
          <textarea name="description" rows="4" required class="f-textarea"
                    placeholder="Résumé ou contexte de la délibération…">{{ old('description') }}</textarea>
          @error('description') <p class="field-error">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="form-section">
        <div class="form-section-title">
          <svg class="i" style="width:16px;height:16px;color:var(--muted)"><use href="#i-file"/></svg>
          Document
        </div>
        <div class="field" style="margin-bottom:0">
          <label class="field-label">Fichier PDF</label>
          <input type="file" name="fichier" required accept=".pdf" class="f-input">
          <p class="field-hint">Format PDF uniquement · Taille maximale : 10 Mo</p>
          @error('fichier') <p class="field-error">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-ok">
          <svg class="i"><use href="#i-check"/></svg>Enregistrer
        </button>
        <a href="{{ route('deliberations.index') }}" class="btn-no">Annuler</a>
      </div>
    </form>
  </div>
</x-app-layout>
