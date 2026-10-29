<x-app-layout title="Modifier utilisateur">
  <section class="hello">
    <div>
      <h1>Modifier utilisateur</h1>
      <p>Modifier les informations de {{ $user->nom_complet }}.</p>
    </div>
    <a href="{{ route('users.index') }}" class="btn-no">Retour</a>
  </section>

  <div class="card">
    <form method="POST" action="{{ route('users.update', $user) }}">
      @csrf
      @method('PATCH')

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nom</label>
        <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
        @error('nom') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Prénom</label>
        <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
        @error('prenom') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
        @error('email') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Téléphone</label>
        <input type="tel" name="telephone" value="{{ old('telephone', $user->telephone) }}" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
        @error('telephone') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Fonction</label>
        <input type="text" name="fonction" value="{{ old('fonction', $user->fonction) }}" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
        @error('fonction') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Rôle</label>
        <select name="role" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
          <option value="conseiller" {{ $user->role === 'conseiller' ? 'selected' : '' }}>Conseiller</option>
          <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
        </select>
        @error('role') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Statut</label>
        <select name="statut" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
          <option value="en_attente" {{ $user->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
          <option value="valide" {{ $user->statut === 'valide' ? 'selected' : '' }}>Validé</option>
          <option value="rejete" {{ $user->statut === 'rejete' ? 'selected' : '' }}>Rejeté</option>
        </select>
        @error('statut') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Mot de passe (laisser vide pour ne pas changer)</label>
        <input type="password" name="password" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
        @error('password') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
        @error('password_confirmation') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="display: flex; gap: 12px; margin-top: 24px;">
        <a href="{{ route('users.index') }}" class="btn-no">Annuler</a>
        <button type="submit" class="btn-ok">Enregistrer</button>
      </div>
    </form>
  </div>
</x-app-layout>
