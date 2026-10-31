{{-- resources/views/conges/index.blade.php --}}
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mes Congés</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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
        }

        .btn-primary {
            background-color: hsl(var(--primary));
            color: hsl(var(--primary-foreground));
            width: 100%;
        }

        .btn-primary:hover:not(:disabled) {
            background-color: hsl(var(--primary) / 0.9);
        }

        .card {
            background-color: hsl(var(--card));
            color: hsl(var(--card-foreground));
            border: 1px solid hsl(var(--border));
            border-radius: 0.5rem;
            padding: 1.5rem;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: hsl(var(--accent));
        }

        .card-header { margin-bottom: 1rem; }
        .card-title { font-size: 1.375rem; font-weight: 600; margin-bottom: 0.5rem; }
        .card-description { font-size: 0.875rem; color: hsl(var(--muted-foreground)); }

        .table-container {
            border: 1px solid hsl(var(--border));
            border-radius: 0.5rem;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }
        thead { background-color: hsl(var(--secondary) / 0.5); }
        th, td { padding: 1rem; border-bottom: 1px solid hsl(var(--border)); }
        tbody tr:hover { background-color: hsl(var(--secondary) / 0.4); }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-default { background-color: hsl(var(--primary)); color: hsl(var(--primary-foreground)); }
        .badge-secondary { background-color: hsl(var(--secondary)); color: hsl(var(--secondary-foreground)); }
        .badge-destructive { background-color: hsl(var(--destructive)); color: hsl(var(--destructive-foreground)); }

        @media (max-width: 768px) {
            main { padding: 1rem; }
            table { font-size: 0.875rem; }
            th, td { padding: 0.75rem; }
        }
        .btn-secondary {
    background: hsl(var(--secondary));
    color: hsl(var(--secondary-foreground));
    border: 2px solid hsl(var(--border));
}

.btn-secondary:hover:not(:disabled) {
    background: hsl(var(--accent));
    color: hsl(var(--accent-foreground));
    transform: translateY(-2px);
}
    </style>
</head>
<body>
    <div class="flex flex-col" style="min-height: 100vh;">
        {{-- Header --}}
        <header>
            <div class="header-content">
                <a href="#" class="logo">Mes Congés</a>
            </div>
        </header>

        {{-- Main --}}
        <main style="flex: 1;">
            <div style="max-width: 1200px; margin: 0 auto;">
                {{-- Page Header --}}
                <div class="flex-between" style="margin-bottom: 2rem; flex-direction: column; align-items: flex-start; gap: 1rem;">
                    <div>
                        <h1>Mes Congés</h1>
<p>Consultez et suivez vos congés en toute simplicité</p>
                        {{-- Main --}}
<main style="flex: 1;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        {{-- Bouton Retour --}}
        <a href="/cover" class="btn btn-secondary" style="width: auto; margin-bottom: 2rem;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Retour
        </a>

        {{-- Page Header --}}
        <div class="flex-between" style="margin-bottom: 2rem; flex-direction: column; align-items: flex-start; gap: 1rem;">
                    </div>
                  
                </div>

                {{-- Table des congés --}}
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Liste des congés</h2>
                        <p class="card-description">Historique de vos demandes de congé</p>
                    </div>
                    <div class="card-content">
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Date début</th>
                                        <th>Date fin</th>
                                        <th>Type</th>
                                        <th>Statut</th>
                                        <th>Solde</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($conges as $conge)
                                        <tr>
                                            <td><strong>{{ \Carbon\Carbon::parse($conge->date_debut)->format('d/m/Y') }}</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($conge->date_fin)->format('d/m/Y') }}</td>
                                            <td>{{ $conge->type }}</td>
                                            <td>
                                                <span class="badge
                                                    @if($conge->statut === 'En Attente') badge-default
                                                    @elseif($conge->statut === 'Approuvé') badge-secondary
                                                    @else badge-destructive
                                                    @endif
                                                ">
                                                    {{ $conge->statut }}
                                                </span>
                                            </td>
<td>{{ $conge->user->solde_conges }}</td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <div class="empty-state">
                                                    <p>Aucun congé trouvé</p>
                                                    <a href="{{ route('conges.create') }}" class="btn btn-primary">Nouvelle demande</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>

        {{-- Footer --}}
        <footer>
            <div class="footer-content">
                <p style="margin-bottom: 0;">© 2026 Gestion des Congés. Tous droits réservés.</p>
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/global.js') }}"></script>
</body>
</html>
