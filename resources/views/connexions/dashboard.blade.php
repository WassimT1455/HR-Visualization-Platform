<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Connexions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: 25 95% 53%;
            --primary-dark: 25 85% 45%;
            --background: 0 0% 100%;
            --surface: 0 0% 98%;
            --surface-hover: 0 0% 95%;
            --text: 15 40% 25%;
            --text-secondary: 15 20% 50%;
            --border: 0 0% 92%;
            --border-light: 0 0% 96%;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --danger: 0 84% 60%;
            --warning: 38 92% 50%;
            --success: 142 71% 45%;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: hsl(var(--background));
            color: hsl(var(--text));
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--primary-dark)));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        /* Main Content */
        main {
            flex: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            width: 100%;
        }

        /* Footer */
        footer {
            border-top: 1px solid hsl(var(--border));
            background-color: hsl(var(--surface) / 0.5);
            margin-top: auto;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: hsl(var(--text-secondary));
        }

        /* Card */
        .card {
            background-color: hsl(var(--surface));
            border: 1px solid hsl(var(--border));
            border-radius: 12px;
            padding: 2rem;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            margin-bottom: 2rem;
        }

        .card-title {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--primary-dark)));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .card-description {
            color: hsl(var(--text-secondary));
            font-size: 0.95rem;
        }

        /* Table */
        .table-wrapper {
            background: hsl(var(--background));
            border-radius: 10px;
            overflow-x: auto;
            border: 1px solid hsl(var(--border-light));
            margin-bottom: 2rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .table thead {
            background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--primary-dark)));
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .table th {
            padding: 1.25rem;
            text-align: left;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .table td {
            padding: 1.25rem;
            border-bottom: 1px solid hsl(var(--border-light));
            font-size: 0.95rem;
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background-color: hsl(var(--surface-hover));
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .status-success {
            background-color: hsl(var(--success) / 0.15);
            color: hsl(var(--success));
        }

        .status-danger {
            background-color: hsl(var(--danger) / 0.15);
            color: hsl(var(--danger));
        }

        .status-warning {
            background-color: hsl(var(--warning) / 0.15);
            color: hsl(var(--warning));
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            color: hsl(var(--text-secondary));
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            font-family: inherit;
            letter-spacing: 0.3px;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-primary {
            background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--primary-dark)));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-secondary {
            background: hsl(var(--surface));
            color: hsl(var(--text));
            border: 2px solid hsl(var(--border));
        }

        .btn-secondary:hover:not(:disabled) {
            background: hsl(var(--surface-hover));
            border-color: hsl(var(--primary));
            transform: translateY(-2px);
        }

        .btn-back {
            margin-bottom: 2rem;
        }

        /* Alerts */
        .alert {
            padding: 1.25rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            font-weight: 500;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-left: 4px solid;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: hsl(142 71% 45% / 0.1);
            color: hsl(142 71% 35%);
            border-left-color: hsl(142 71% 45%);
        }

        .alert-info {
            background: hsl(199 89% 48% / 0.1);
            color: hsl(199 89% 38%);
            border-left-color: hsl(199 89% 48%);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                padding: 0 1rem;
            }

            main {
                padding: 1rem;
            }

            .card {
                padding: 1.5rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .table th,
            .table td {
                padding: 0.875rem;
                font-size: 0.85rem;
            }

            .table th {
                font-size: 0.75rem;
                letter-spacing: 0.3px;
            }

            .table-wrapper {
                overflow-x: scroll;
            }
        }

        @media (max-width: 640px) {
            .table {
                font-size: 0.8rem;
            }

            .table th,
            .table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-content">
            <a href="#" class="logo" onclick="goHome(); return false;">Mes Connexions</a>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Back Button -->
        <button class="btn btn-secondary btn-back" onclick="goBack()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Retour
        </button>

        <!-- Card -->
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Mes Connexions</h1>
                <p class="card-description">Consultez l'historique de toutes vos connexions</p>
            </div>

            <!-- Connexions Table -->
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Heure</th>
                            <th>IP</th>
                            <th>Pays</th>
                            <th>Navigateur</th>
                  <th>Distance Horaire</th>
                            <th>Status</th>
                            <th>Suspicion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($connexions as $connexion)
                        <tr>
                            <td>{{ $connexion->login_time }}</td>
                            <td>{{ $connexion->ip_address }}</td>
                            <td>{{ $connexion->country }}</td>
                            <td>{{ $connexion->navigateur }}</td>
                            <td>{{ $connexion->distance_horaire }}</td>
                            <td>
                                @if($connexion->cs_status == 'Connecté' || $connexion->cs_status == 'Actif')
                                    <span class="status-badge status-success">{{ $connexion->cs_status }}</span>
                                @elseif($connexion->cs_status == 'Bloquée' || $connexion->cs_status == 'Refusé')
                                    <span class="status-badge status-danger">{{ $connexion->cs_status }}</span>
                                @else
                                    <span class="status-badge status-warning">{{ $connexion->cs_status }}</span>
                                @endif
                            </td>
                            <td>
                                @if($connexion->suspicious == 'Oui' || $connexion->suspicious == 'Yes')
                                    <span class="status-badge status-danger">Oui</span>
                                @elseif($connexion->suspicious == 'Possible')
                                    <span class="status-badge status-warning">Possible</span>
                                @else
                                    <span class="status-badge status-success">Non</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-state-icon">🔒</div>
                                    <p>Aucune connexion enregistrée</p>
                                    <p style="font-size: 0.875rem; margin-top: 0.5rem; color: hsl(var(--text-secondary) / 0.8);">Votre historique de connexions apparaîtra ici.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>© 2026 Gestion des Connexions. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Navigation functions
        function goBack() {
            if (document.referrer && document.referrer.includes(window.location.hostname)) {
                window.history.back();
            } else {
                window.location.href = '/';
            }
        }

        function goHome() {
            window.location.href = '/';
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Connexions page loaded');
        });

        // Handle keyboard navigation
        document.addEventListener('keydown', function(event) {
            if (event.altKey && event.key === 'ArrowLeft') {
                goBack();
            }
        });
    </script>
</body>
</html>