<x-app-layout title="Nouveau besoin">
  <section class="hello">
    <div>
      <h1>Nouveau besoin</h1>
      <p>Exprimer un besoin prioritaire pour un canton.</p>
    </div>
    <a href="{{ route('besoins.index') }}" class="btn-no">
      <svg class="i"><use href="#i-arrow-left"/></svg>Retour
    </a>
  </section>

  <div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('besoins.store') }}">
      @csrf

      <div class="field-row">
        <div class="field">
          <label class="field-label">Canton</label>
          <select name="canton_id" required class="f-select">
            @foreach($cantons as $canton)
              <option value="{{ $canton->id }}" {{ old('canton_id') == $canton->id ? 'selected' : '' }}>
                {{ $canton->nom }}
              </option>
            @endforeach
          </select>
          @error('canton_id') <p class="field-error">{{ $message }}</p> @enderror
        </div>
        <div class="field">
          <label class="field-label">Priorité</label>
          <select name="priorite" required class="f-select">
            <option value="haute"  {{ old('priorite') === 'haute'  ? 'selected' : '' }}>🔴 Haute</option>
            <option value="moyenne"{{ old('priorite','moyenne') === 'moyenne' ? 'selected' : '' }}>🟡 Moyenne</option>
            <option value="basse"  {{ old('priorite') === 'basse'  ? 'selected' : '' }}>🟢 Basse</option>
          </select>
          @error('priorite') <p class="field-error">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="field">
        <label class="field-label">Description du besoin</label>
        <textarea name="description" rows="5" required class="f-textarea"
                  placeholder="Décrivez le besoin en détail…">{{ old('description') }}</textarea>
        @error('description') <p class="field-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-ok">
          <svg class="i"><use href="#i-check"/></svg>Enregistrer
        </button>
        <a href="{{ route('besoins.index') }}" class="btn-no">Annuler</a>
      </div>
    </form>
  </div>
</x-app-layout>
