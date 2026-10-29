<x-app-layout title="Nouveau budget">
  <section class="hello">
    <div>
      <h1>Nouveau budget</h1>
      <p>Ajouter un budget annuel ou supplémentaire avec son document PDF.</p>
    </div>
    <a href="{{ route('budgets.index') }}" class="btn-no">
      <svg class="i"><use href="#i-arrow-left"/></svg>Retour
    </a>
  </section>

  <div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('budgets.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="field-row">
        <div class="field">
          <label class="field-label">Année</label>
          <input type="number" name="annee" value="{{ old('annee', date('Y')) }}"
                 required min="2020" max="2100" class="f-input" placeholder="{{ date('Y') }}">
          @error('annee') <p class="field-error">{{ $message }}</p> @enderror
        </div>
        <div class="field">
          <label class="field-label">Type de budget</label>
          <select name="type" required class="f-select">
            <option value="annuel"        {{ old('type','annuel') === 'annuel'        ? 'selected' : '' }}>Budget annuel</option>
            <option value="supplementaire"{{ old('type') === 'supplementaire' ? 'selected' : '' }}>Budget supplémentaire</option>
          </select>
          @error('type') <p class="field-error">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="field">
        <label class="field-label">Montant (FCFA)</label>
        <input type="number" name="montant" value="{{ old('montant') }}"
               required min="0" step="1000" class="f-input" placeholder="ex: 150 000 000">
        @error('montant') <p class="field-error">{{ $message }}</p> @enderror
      </div>

      <div class="field">
        <label class="field-label">Document PDF</label>
        <input type="file" name="fichier" required accept=".pdf" class="f-input">
        <p class="field-hint">Fichier PDF uniquement. Taille maximale : 10 Mo.</p>
        @error('fichier') <p class="field-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-ok">
          <svg class="i"><use href="#i-check"/></svg>Enregistrer
        </button>
        <a href="{{ route('budgets.index') }}" class="btn-no">Annuler</a>
      </div>
    </form>
  </div>
</x-app-layout>
