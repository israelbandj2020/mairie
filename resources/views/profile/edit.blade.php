<x-app-layout title="Mon profil">
  <section class="hello">
    <div>
      <h1>Mon profil</h1>
      <p>Gérez vos informations personnelles.</p>
    </div>
  </section>

  <div class="card">
    <form method="POST" action="{{ route('profile.update') }}">
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

      <div style="display: flex; gap: 12px; margin-top: 24px;">
        <button type="submit" class="btn-ok">Enregistrer</button>
      </div>
    </form>
  </div>

  <div class="card" style="margin-top: 24px;">
    <h3 style="margin-bottom: 20px;">Changer le mot de passe</h3>
    <form method="POST" action="{{ route('profile.password') }}">
      @csrf

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Mot de passe actuel</label>
        <input type="password" name="current_password" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
        @error('current_password') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nouveau mot de passe</label>
        <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
        @error('password') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px; font-weight: 600;">Confirmer le nouveau mot de passe</label>
        <input type="password" name="password_confirmation" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 12px; font-size: 15px;">
        @error('password_confirmation') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
      </div>

      <div style="display: flex; gap: 12px; margin-top: 24px;">
        <button type="submit" class="btn-ok">Changer le mot de passe</button>
      </div>
    </form>
  </div>
</x-app-layout>
