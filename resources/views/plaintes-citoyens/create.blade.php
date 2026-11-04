<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soumettre une plainte - {{ config('conseil.commune', 'Conseil municipal') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="auth">
    <div class="auth-box" style="max-width: 700px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h1 style="margin: 0 0 8px 0; font-size: 24px;">Soumettre une plainte</h1>
                <p style="margin: 0; color: var(--muted);">Déposez une plainte. Elle sera examinée par l'administration.</p>
            </div>
            <a href="{{ route('login') }}" class="btn-no" style="height: 36px; padding: 0 16px;">
                <svg class="i"><use href="#i-arrow-left"/></svg>Retour
            </a>
        </div>

        @if(session('succes'))
            <div style="background:var(--ok-soft);color:var(--forest-2);padding:16px;border-radius:8px;margin-bottom:20px">
                <svg class="i" style="width:18px;height:18px;vertical-align:-4px;margin-right:8px"><use href="#i-check"/></svg>
                {{ session('succes') }}
            </div>
        @endif

        <form method="POST" action="{{ route('plaintes-citoyens.store') }}" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Type de plainte</label>
                <select name="type_plainte" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;">
                    <option value="">Sélectionnez le type de plainte</option>
                    <option value="executif" {{ old('type_plainte') === 'executif' ? 'selected' : '' }}>Exécutif</option>
                    <option value="agent_mairie" {{ old('type_plainte') === 'agent_mairie' ? 'selected' : '' }}>Agent de la mairie</option>
                    <option value="conseiller" {{ old('type_plainte') === 'conseiller' ? 'selected' : '' }}>Conseiller</option>
                    <option value="autres" {{ old('type_plainte') === 'autres' ? 'selected' : '' }}>Autres</option>
                </select>
                @error('type_plainte') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="display: flex; gap: 12px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;" placeholder="Votre nom">
                    @error('nom') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Prénom</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;" placeholder="Votre prénom">
                    @error('prenom') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Téléphone (optionnel)</label>
                <input type="text" name="telephone" value="{{ old('telephone') }}" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;" placeholder="Ex : +228 90 00 00 00">
                @error('telephone') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Description de la plainte</label>
                <textarea name="description" rows="5" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px; resize: vertical;" placeholder="Décrivez votre plainte en détail…">{{ old('description') }}</textarea>
                @error('description') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Photo (optionnel)</label>
                <input type="file" name="photo" accept="image/*" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;">
                <p style="font-size: 13px; color: var(--muted); margin-top: 6px;">Formats acceptés : JPG, PNG, GIF · Taille maximale : 5 Mo</p>
                @error('photo') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn-ok" style="flex: 1;">
                    <svg class="i"><use href="#i-send"/></svg>Soumettre la plainte
                </button>
                <a href="{{ route('login') }}" class="btn-no" style="flex: 0 0 auto; height: 40px; padding: 0 20px; display: inline-flex; align-items: center; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>

    <style>
        body.auth {
            background: linear-gradient(135deg, var(--bg) 0%, var(--line) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-box {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            width: 100%;
        }
    </style>
</body>
</html>
