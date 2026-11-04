<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soumettre un besoin - {{ config('conseil.commune', 'Conseil municipal') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="auth">
    <div class="auth-box" style="max-width: 700px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h1 style="margin: 0 0 8px 0; font-size: 24px;">Soumettre un besoin</h1>
                <p style="margin: 0; color: var(--muted);">Exprimez un besoin pour votre canton. Il sera examiné par l'administration.</p>
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

        <form method="POST" action="{{ route('besoins-citoyens.store') }}" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Canton</label>
                <select name="canton_id" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;">
                    <option value="">Sélectionnez votre canton</option>
                    @foreach($cantons as $canton)
                        <option value="{{ $canton->id }}" {{ old('canton_id') == $canton->id ? 'selected' : '' }}>
                            {{ $canton->nom }}
                        </option>
                    @endforeach
                </select>
                @error('canton_id') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
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
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Titre</label>
                <input type="text" name="titre" value="{{ old('titre') }}" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;" placeholder="Ex : Réparation de la route principale">
                @error('titre') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Description détaillée</label>
                <textarea name="description" rows="5" required style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px; resize: vertical;" placeholder="Décrivez le besoin en détail…">{{ old('description') }}</textarea>
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
                    <svg class="i"><use href="#i-send"/></svg>Soumettre le besoin
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
