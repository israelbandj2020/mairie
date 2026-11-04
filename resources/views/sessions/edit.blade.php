<x-app-layout title="Modifier session {{ $session->numero }}">
  <section class="hello">
    <div>
      <h1>Modifier session {{ $session->numero }}</h1>
      <p>{{ $session->date->translatedFormat('d F Y') }}</p>
    </div>
    <a href="{{ route('sessions.show', $session) }}" class="btn-no">
      <svg class="i"><use href="#i-arrow-left"/></svg>Retour
    </a>
  </section>

  <div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('sessions.update', $session) }}">
      @csrf
      @method('PUT')

      <div class="field">
        <label class="field-label">Numéro de session</label>
        <input type="text" value="{{ $session->numero }}" disabled class="f-input" style="background:var(--paper-2)">
        <p class="field-hint">Le numéro de session ne peut pas être modifié</p>
      </div>

      <div class="field">
        <label class="field-label">Date</label>
        <input type="date" name="date" value="{{ old('date', $session->date->format('Y-m-d')) }}" required class="f-input">
        @error('date') <p class="field-error">{{ $message }}</p> @enderror
      </div>

      <div class="field">
        <label class="field-label">Lieu</label>
        <input type="text" name="lieu" value="{{ old('lieu', $session->lieu) }}" class="f-input" placeholder="Salle du conseil…">
        @error('lieu') <p class="field-error">{{ $message }}</p> @enderror
      </div>

      <div class="field">
        <label class="field-label">Statut</label>
        <select name="statut" required class="f-select">
          <option value="planifiee" {{ $session->statut === 'planifiee' ? 'selected' : '' }}>Planifiée</option>
          <option value="en_cours"  {{ $session->statut === 'en_cours'  ? 'selected' : '' }}>En cours</option>
          <option value="terminee"  {{ $session->statut === 'terminee'  ? 'selected' : '' }}>Terminée</option>
          <option value="annulee"   {{ $session->statut === 'annulee'   ? 'selected' : '' }}>Annulée</option>
        </select>
        @error('statut') <p class="field-error">{{ $message }}</p> @enderror
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-ok">
          <svg class="i"><use href="#i-check"/></svg>Enregistrer
        </button>
        <a href="{{ route('sessions.show', $session) }}" class="btn-no">Annuler</a>
      </div>
    </form>
  </div>
</x-app-layout>
