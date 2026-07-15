<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; line-height: 1.6; color: #1f2937; margin: 0; padding: 0; background: #f9fafb; }
        .container { max-width: 580px; margin: 0 auto; padding: 40px 20px; }
        .card { background: white; border-radius: 12px; padding: 40px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .logo { text-align: center; margin-bottom: 24px; }
        h1 { font-size: 22px; color: #111827; margin-bottom: 16px; }
        .highlight { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 16px; border-radius: 8px; margin: 20px 0; }
        .steps { margin: 24px 0; }
        .step { display: flex; align-items: flex-start; margin-bottom: 16px; }
        .step-num { background: #3b82f6; color: white; width: 24px; height: 24px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; margin-right: 12px; flex-shrink: 0; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; margin-top: 16px; }
        .footer { text-align: center; margin-top: 32px; font-size: 13px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">
                <img src="{{ config('app.url') }}/images/logo.png" alt="SchoolManager" style="height: 40px;">
            </div>

            <h1>Bienvenue {{ $user->name }} !</h1>

            <p>Votre école <strong>{{ $school->name }}</strong> est maintenant enregistrée sur SchoolManager. Votre période d'essai gratuite de 1 mois commence aujourd'hui.</p>

            <div class="highlight">
                <strong>Vos identifiants :</strong><br>
                Email : {{ $user->email }}<br>
                Mot de passe : celui que vous avez choisi à l'inscription
            </div>

            <p>Pour bien démarrer, voici les 4 étapes essentielles :</p>

            <div class="steps">
                <div class="step">
                    <span class="step-num">1</span>
                    <span><strong>Créez vos classes</strong> — Ajoutez les niveaux et sections de votre école</span>
                </div>
                <div class="step">
                    <span class="step-num">2</span>
                    <span><strong>Inscrivez vos élèves</strong> — Importez ou ajoutez les élèves un par un</span>
                </div>
                <div class="step">
                    <span class="step-num">3</span>
                    <span><strong>Configurez les frais</strong> — Définissez les montants d'inscription et mensualités</span>
                </div>
                <div class="step">
                    <span class="step-num">4</span>
                    <span><strong>Suivez les paiements</strong> — Enregistrez les encaissements au quotidien</span>
                </div>
            </div>

            <p style="text-align: center;">
                <a href="{{ config('app.url') }}/dashboard" class="btn">Accéder à mon espace</a>
            </p>
        </div>

        <div class="footer">
            <p>SchoolManager — La gestion scolaire simplifiée</p>
            <p>Des questions ? Répondez à cet email, nous vous répondrons rapidement.</p>
        </div>
    </div>
</body>
</html>
