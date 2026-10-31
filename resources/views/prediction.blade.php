<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prédiction de Connexion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --background: 0 0% 100%;
            --foreground: 15 40% 25%;
            --card: 0 0% 100%;
            --card-foreground: 15 40% 25%;
            --primary: 25 95% 53%;
            --primary-foreground: 0 0% 100%;
            --secondary: 0 0% 95%;
            --secondary-foreground: 15 40% 25%;
            --muted: 0 0% 90%;
            --muted-foreground: 15 20% 50%;
            --accent: 25 95% 53%;
            --accent-foreground: 0 0% 100%;
            --border: 0 0% 92%;
            --input: 0 0% 96%;
            --destructive: 0 84.2% 60.2%;
            --destructive-foreground: 210 40% 98%;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: hsl(var(--background));
            color: hsl(var(--foreground));
            transition: var(--transition);
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: hsl(var(--background) / 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid hsl(var(--border));
            transition: var(--transition);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 4rem;
            display: flex;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: hsl(var(--primary));
            cursor: pointer;
            text-decoration: none;
            transition: color 0.2s;
        }

        .logo:hover {
            color: hsl(var(--primary) / 0.8);
        }

        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            flex: 1;
            width: 100%;
        }

        footer {
            border-top: 1px solid hsl(var(--border));
            background-color: hsl(var(--secondary) / 0.3);
            margin-top: 3rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: hsl(var(--muted-foreground));
        }

        h1, h3 {
            color: hsl(var(--foreground));
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        h1 { font-size: 2rem; }
        h3 { font-size: 1.375rem; }

        .card {
            background-color: hsl(var(--card));
            color: hsl(var(--card-foreground));
            border: 1px solid hsl(var(--border));
            border-radius: 0.5rem;
            padding: 1.5rem;
            transition: var(--transition);
            margin-top: 1.5rem;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: hsl(var(--accent));
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: hsl(var(--foreground));
        }

        .form-control {
            width: 100%;
            padding: 0.625rem 1rem;
            border: 1px solid hsl(var(--border));
            border-radius: 0.375rem;
            font-family: inherit;
            font-size: 1rem;
            background-color: hsl(var(--input));
            color: hsl(var(--foreground));
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: hsl(var(--primary));
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            font-family: inherit;
            width: 100%;
        }

        .btn-primary {
            background-color: hsl(var(--primary));
            color: hsl(var(--primary-foreground));
        }

        .btn-primary:hover:not(:disabled) {
            background-color: hsl(var(--primary) / 0.9);
        }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid;
            margin-top: 1rem;
        }

        .alert-danger {
            background-color: #fee;
            border-color: #fcc;
            color: #c33;
        }

        .alert-success {
            background-color: #efe;
            border-color: #cfc;
            color: #3c3;
        }

        .alert-secondary {
            background-color: hsl(var(--secondary));
            border-color: hsl(var(--border));
            color: hsl(var(--foreground));
        }

        .alert h3 {
            margin-bottom: 0.5rem;
        }

        .alert p {
            margin: 0;
        }

        .alert ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .alert li {
            margin-bottom: 0.5rem;
        }

        canvas {
            max-width: 100%;
            height: auto !important;
        }

        @media (max-width: 768px) {
            main { padding: 1rem; }
            h1 { font-size: 1.5rem; }
            .card { padding: 1rem; }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="#" class="logo">Prédiction Connexion</a>
        </div>
    </header>

    <main>
        <h1>Prédiction de Connexion</h1>
        <p style="color: hsl(var(--muted-foreground)); margin-bottom: 1.5rem;">Analysez et prédisez les connexions suspectes</p>

        <div class="card">
            <form action="{{ route('predict.connexion') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="id_utilisateur">ID Utilisateur</label>
                    <input type="text" class="form-control" id="id_utilisateur" name="id_utilisateur" required>
                </div>
                <div class="form-group">
                    <label for="ip">IP</label>
                    <input type="text" class="form-control" id="ip" name="ip" required>
                </div>
                <div class="form-group">
                    <label for="distance_horaire">Distance Horaire</label>
                    <input type="number" class="form-control" id="distance_horaire" name="distance_horaire" required>
                </div>
                <div class="form-group">
                    <label for="heure_connexion">Heure de Connexion (0 à 23)</label>
                    <input type="number" class="form-control" id="heure_connexion" name="heure_connexion" min="0" max="23" required>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="time">Heure</label>
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
                <div class="form-group">
                    <label for="cs_status">Statut de la connexion</label>
                    <input type="number" class="form-control" id="cs_status" name="cs_status" required>
                </div>
                <div class="form-group">
                    <label for="cs_user_agent">User Agent</label>
                    <input type="text" class="form-control" id="cs_user_agent" name="cs_user_agent" required>
                </div>
                <div class="form-group">
                    <label for="pays">Pays</label>
                    <input type="text" class="form-control" id="pays" name="pays" required>
                </div>
                <div class="form-group">
                    <label for="navigateur">Navigateur</label>
                    <input type="text" class="form-control" id="navigateur" name="navigateur" required>
                </div>
                <div class="form-group">
                    <label for="appareil">Appareil</label>
                    <input type="text" class="form-control" id="appareil" name="appareil" required>
                </div>

                <button type="submit" class="btn btn-primary">Soumettre</button>
            </form>
        </div>

        @if (isset($prediction))
            <div class="card">
                @if($prediction === 1 || $prediction === '1' || $prediction === true)
                    <div class="alert alert-danger">
                        <h3>Résultat de la prédiction</h3>
                        <p>Connexion <strong>suspecte</strong> détectée.</p>
                    </div>
                @elseif($prediction === 0 || $prediction === '0' || $prediction === false)
                    <div class="alert alert-success">
                        <h3>Résultat de la prédiction</h3>
                        <p>Connexion <strong>normale</strong>.</p>
                    </div>
                @else
                    <div class="alert alert-secondary">
                        <h3>Résultat de la prédiction</h3>
                        <p>{{ $prediction }}</p>
                    </div>
                @endif
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <h3>Erreur</h3>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

      
    </main>

    <footer>
        <div class="footer-content">
            <p style="margin-bottom: 0;">© 2026 Prédiction Connexion. Tous droits réservés.</p>
        </div>
    </footer>

  
</body>
</html>
