<x-app-layout title="Nouvelle session">
  <section class="hello">
    <div>
      <h1>Nouvelle session</h1>
      <p>Planifier une nouvelle session de travail du conseil.</p>
    </div>
    <a href="{{ route('sessions.index') }}" class="btn-no">
      <svg class="i"><use href="#i-arrow-left"/></svg>Retour
    </a>
  </section>

  <div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('sessions.store') }}">
      @csrf

      <div class="field-row">
        <div class="field">
          <label class="field-label">Numéro de session</label>
          <input type="text" name="numero" value="{{ old('numero') }}" required
                 class="f-input" placeholder="ex: 2024-01">
          @error('numero')
            <p class="field-error">{{ $message }}</p>
          @enderror
        </div>
        <div class="field">
          <label class="field-label">Date</label>
          <input type="date" name="date" value="{{ old('date') }}" required class="f-input">
          @error('date')
            <p class="field-error">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="field">
        <label class="field-label">Lieu</label>
        <input type="text" name="lieu" value="{{ old('lieu') }}" class="f-input"
               placeholder="Salle du conseil, mairie…">
        @error('lieu')
          <p class="field-error">{{ $message }}</p>
        @enderror
      </div>

      <div class="field">
        <label class="field-label">Statut</label>
        <select name="statut" required class="f-select">
          <option value="planifiee"  {{ old('statut','planifiee') === 'planifiee'  ? 'selected' : '' }}>Planifiée</option>
          <option value="en_cours"   {{ old('statut') === 'en_cours'   ? 'selected' : '' }}>En cours</option>
          <option value="terminee"   {{ old('statut') === 'terminee'   ? 'selected' : '' }}>Terminée</option>
          <option value="annulee"    {{ old('statut') === 'annulee'    ? 'selected' : '' }}>Annulée</option>
        </select>
        @error('statut')
          <p class="field-error">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-ok">
          <svg class="i"><use href="#i-check"/></svg>Créer la session
        </button>
        <a href="{{ route('sessions.index') }}" class="btn-no">Annuler</a>
      </div>
    </form>
  </div>
</x-app-layout>
