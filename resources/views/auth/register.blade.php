<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - {{ config('conseil.commune', 'Conseil municipal') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="auth">
    <div class="auth-box">
        <h1>Inscription</h1>
        <p>Créez votre compte pour accéder à l'espace conseil.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Nom</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required autofocus autocomplete="family-name" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;">
                @error('nom') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required autocomplete="given-name" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;">
                @error('prenom') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;">
                @error('email') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Téléphone</label>
                <input type="tel" name="telephone" value="{{ old('telephone') }}" autocomplete="tel" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;">
                @error('telephone') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Mot de passe</label>
                <input type="password" name="password" required autocomplete="new-password" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;">
                @error('password') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;">
                @error('password_confirmation') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px;">
                <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-size: 14px;">Déjà inscrit ?</a>
                <button type="submit" class="btn-ok">S'inscrire</button>
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
            max-width: 400px;
        }
        .auth-box h1 {
            margin: 0 0 8px 0;
            font-size: 24px;
        }
        .auth-box p {
            margin: 0 0 24px 0;
            color: var(--muted);
        }
    </style>
</body>
</html>
