<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - {{ config('conseil.commune', 'Conseil municipal') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="auth">
    <div class="auth-box">
        <h1>Connexion</h1>
        <p>Accédez à votre espace conseil municipal.</p>

        @if (session('status'))
            <div style="background: var(--success); color: white; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;">
                @error('email') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Mot de passe</label>
                <input type="password" name="password" required autocomplete="current-password" style="width: 100%; padding: 12px; border: 1px solid var(--line); border-radius: 8px; font-size: 15px;">
                @error('password') <p style="color: var(--laterite); margin-top: 6px; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: inline-flex; align-items: center; gap: 8px;">
                    <input type="checkbox" name="remember" style="width: 16px; height: 16px;">
                    <span style="font-size: 14px;">Se souvenir de moi</span>
                </label>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px;">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color: var(--primary); text-decoration: none; font-size: 14px;">Mot de passe oublié ?</a>
                @endif
                <button type="submit" class="btn-ok">Se connecter</button>
            </div>
        </form>

        <p style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--muted);">
            Pas encore de compte ? <a href="{{ route('register') }}" style="color: var(--primary);">S'inscrire</a>
        </p>
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
