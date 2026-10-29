<x-app-layout title="Nouveau plan PAI">
  <section class="hello">
    <div>
      <h1>Nouveau plan PAI</h1>
      <p>Ajouter un plan d'investissement annuel.</p>
    </div>
    <a href="{{ route('pai.index') }}" class="btn-no">
      <svg class="i"><use href="#i-arrow-left"/></svg>Retour
    </a>
  </section>

  <div class="card" style="max-width:500px">
    <form method="POST" action="{{ route('pai.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="field">
        <label class="field-label">Année</label>
        <input type="number" name="annee" value="{{ old('annee', date('Y')) }}"
               required min="2020" max="2100" class="f-input" placeholder="{{ date('Y') }}">
        <p class="field-hint">Indiquez l'année correspondant à ce plan d'investissement.</p>
        @error('annee') <p class="field-error">{{ $message }}</p> @enderror
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
        <a href="{{ route('pai.index') }}" class="btn-no">Annuler</a>
      </div>
    </form>
  </div>
</x-app-layout>
