@if(!Auth::check() || Auth::user()->role !== 'admin')
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accès refusé</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                padding: 2rem;
            }
            .access-denied {
                background: white;
                border-radius: 16px;
                padding: 3rem;
                text-align: center;
                max-width: 500px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            }
            .icon {
                font-size: 4rem;
                margin-bottom: 1rem;
            }
            h1 {
                font-size: 2rem;
                color: #333;
                margin-bottom: 1rem;
            }
            p {
                color: #666;
                margin-bottom: 2rem;
                line-height: 1.6;
            }
            .btn {
                display: inline-block;
                padding: 1rem 2rem;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 600;
                transition: transform 0.2s;
            }
            .btn:hover {
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body>
        <div class="access-denied">
            <div class="icon">🔒</div>
            <h1>Accès refusé</h1>
            <p>Cette page est réservée aux administrateurs. Vous n'avez pas les permissions nécessaires pour y accéder.</p>
            <a href="/cover" class="btn">Retour à l'accueil</a>
        </div>
        <script>
            // Redirection automatique après 5 secondes
            setTimeout(() => {
                window.location.href = '/cover';
            }, 5000);
        </script>
    </body>
    </html>
    @php
        exit;
    @endphp
@endif

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des utilisateurs</title>
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
            --success: 142 71% 45%;
            --danger: 0 84% 60%;
            --warning: 38 92% 50%;
            --consumed: 240 20% 60%;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: hsl(var(--background));
            color: hsl(var(--text));
            padding: 2rem;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--primary-dark)));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

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

        .alert-danger {
            background: hsl(0 84% 60% / 0.1);
            color: hsl(0 84% 40%);
            border-left-color: hsl(0 84% 60%);
        }

        .table-wrapper {
            background: hsl(var(--surface));
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            border: 1px solid hsl(var(--border));
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: hsl(var(--surface));
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

        @media (max-width: 768px) {
            .table th,
            .table td {
                padding: 0.875rem;
                font-size: 0.85rem;
            }

            .table th {
                font-size: 0.75rem;
            }
        }

        .btn {
            padding: 0.65rem 1.25rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: var(--transition);
            text-decoration: none;
            white-space: nowrap;
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
        }

        .btn-success {
            background: linear-gradient(135deg, hsl(var(--success)), hsl(var(--success) / 0.8));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-success:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-danger {
            background: linear-gradient(135deg, hsl(var(--danger)), hsl(var(--danger) / 0.8));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-danger:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-sm {
            padding: 0.5rem 0.875rem;
            font-size: 0.8rem;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s ease-out;
            backdrop-filter: blur(4px);
            padding: 1rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .modal.show {
            display: flex;
        }

        .modal-dialog {
            background: hsl(var(--surface));
            border-radius: 16px;
            width: 100%;
            max-width: 950px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            border: 1px solid hsl(var(--border));
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 2rem;
            border-bottom: 2px solid hsl(var(--primary));
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .modal-title {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--primary-dark)));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 2rem;
            cursor: pointer;
            color: hsl(var(--text-secondary));
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }

        .btn-close:hover {
            background: hsl(var(--surface-hover));
            color: hsl(var(--text));
        }

        .modal-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: hsl(var(--text));
            letter-spacing: 0.3px;
        }

        input[type="text"],
        input[type="date"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 0.875rem;
            border: 2px solid hsl(var(--border));
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            background: hsl(var(--background));
            color: hsl(var(--text));
            transition: var(--transition);
        }

        input[type="text"]::placeholder,
        input[type="date"]::placeholder,
        input[type="email"]::placeholder,
        textarea::placeholder {
            color: hsl(var(--text-secondary));
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            outline: none;
            border-color: hsl(var(--primary));
            background: hsl(var(--surface));
            box-shadow: 0 0 0 4px hsl(var(--primary) / 0.1);
        }

        .form-row {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .action-row {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .action-row {
                flex-direction: column;
            }

            .action-row .btn {
                width: 100%;
            }
        }

        .modal-body .table-wrapper {
            margin-bottom: 2rem;
            box-shadow: none;
            border: 1px solid hsl(var(--border-light));
        }

        .modal-body .table-wrapper:last-of-type {
            margin-bottom: 0;
        }

        .form-container {
            background: hsl(var(--background));
            border: 2px dashed hsl(var(--border));
            border-radius: 10px;
            padding: 2rem;
            margin-top: 2rem;
        }

        .form-container h3 {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            color: hsl(var(--text));
        }

        .no-data {
            text-align: center;
            padding: 2.5rem;
            color: hsl(var(--text-secondary));
        }

        .no-data p {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .mt-3 {
            margin-top: 1.5rem;
        }

        .form-control {
            width: 100%;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: hsl(var(--warning) / 0.15);
            color: hsl(var(--warning));
        }

        .status-consumed {
            background: hsl(var(--consumed) / 0.15);
            color: hsl(var(--consumed));
        }

        .status-approved {
            background: hsl(var(--success) / 0.15);
            color: hsl(var(--success));
        }

        @media (max-width: 1024px) {
            h1 {
                font-size: 2rem;
            }

            .modal-header {
                padding: 1.5rem;
            }

            .modal-body {
                padding: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .header-container {
                margin-bottom: 2rem;
            }

            h1 {
                font-size: 1.75rem;
            }

            .modal-dialog {
                max-width: 100%;
                border-radius: 12px;
            }

            .form-container {
                padding: 1.5rem;
            }

            .action-row {
                flex-direction: column;
            }

            .action-row .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-container">
        <h1>Admin - Gestion des utilisateurs</h1>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px; flex-shrink: 0;">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Solde Congés</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td><strong>#{{ $user->id }}</strong></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->solde_conges }} jours</td>
                    <td>
                        <div class="action-row">
                            <button class="btn btn-primary btn-sm" onclick="openModal('congesModal{{ $user->id }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                Voir Congés
                            </button>
                            <button class="btn btn-secondary btn-sm" onclick="openModal('missionsModal{{ $user->id }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"></path>
                                </svg>
                                Voir Missions
                            </button>
                              {{-- Delete User --}}
        <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                    <path d="M3 6h18"></path>
                    <path d="M19 6l-1 14H6L5 6"></path>
                    <path d="M10 11v6"></path>
                    <path d="M14 11v6"></path>
                </svg>
                Supprimer
            </button>
        </form>
    </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modals -->
    @foreach($users as $user)

    <!-- Leaves Modal -->
    <div class="modal" id="congesModal{{ $user->id }}">
        <div class="modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title">Congés de {{ $user->name }}</h5>
                <button class="btn-close" onclick="closeModal('congesModal{{ $user->id }}')">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Leaves Table -->
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date Début</th>
                                <th>Date Fin</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->conges as $conge)
                            <tr>
                                <td>#{{ $conge->id }}</td>
                                <td>{{ $conge->date_debut }}</td>
                                <td>{{ $conge->date_fin }}</td>
                                <td>{{ $conge->type }}</td>
                                <td>
                                    <span class="status-badge status-pending" data-conge-id="{{ $conge->id }}" data-date-fin="{{ $conge->date_fin }}">
                                        <span class="status-text">{{ $conge->statut }}</span>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.deleteConge', $conge->id) }}" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Add Leave Form -->
                <div class="form-container">
                    <h3>Ajouter un nouveau congé</h3>
                    <form method="POST" action="{{ route('admin.addConge', $user->id) }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Date début</label>
                                <input type="date" name="date_debut" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date fin</label>
                                <input type="date" name="date_fin" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Type de congé</label>
                                <input type="text" name="type" class="form-control" placeholder="Ex: Congé annuel" required>
                            </div>
                        </div>
                        <button class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Ajouter Congé
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Missions Modal -->
    <div class="modal" id="missionsModal{{ $user->id }}">
        <div class="modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title">Missions de {{ $user->name }}</h5>
                <button class="btn-close" onclick="closeModal('missionsModal{{ $user->id }}')">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Missions Table -->
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Date Début</th>
                                <th>Date Fin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->missions as $mission)
                            <tr>
                                <td>#{{ $mission->id }}</td>
                                <td>{{ $mission->titre }}</td>
                                <td>{{ $mission->description }}</td>
                                <td>{{ $mission->date_debut }}</td>
                                <td>{{ $mission->date_fin }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.deleteMission', $mission->id) }}" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Add Mission Form -->
                <div class="form-container">
                    <h3>Ajouter une nouvelle mission</h3>
                    <form method="POST" action="{{ route('admin.addMission', $user->id) }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Titre</label>
                                <input type="text" name="titre" class="form-control" placeholder="Titre de la mission" required>
                            </div>
                            <div class="form-group">
                                <div class="form-group">
                                <label class="form-label">Date début</label>
                                <input type="date" name="date_debut" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date fin</label>
                                <input type="date" name="date_fin" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Description de la mission" required></textarea>
                        </div>
                        <button class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Ajouter Mission
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endforeach

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Fermer modal en cliquant à l'extérieur
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });

        // Fermer modal avec la touche Échap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal.show').forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });

        // Gestion automatique du statut des congés
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            document.querySelectorAll('.status-badge[data-date-fin]').forEach(badge => {
                const dateFin = new Date(badge.dataset.dateFin);
                dateFin.setHours(0, 0, 0, 0);

                if (dateFin < today) {
                    badge.classList.remove('status-pending', 'status-approved');
                    badge.classList.add('status-consumed');
                    badge.querySelector('.status-text').textContent = 'Consommé';
                }
            });
        });
    </script>
</body>
</html>