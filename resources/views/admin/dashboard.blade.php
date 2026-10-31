<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

    <h1 class="mb-4">Admin - Gestion des utilisateurs</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
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
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->solde_conges }}</td>
                <td>
                    <!-- Boutons modals -->
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#congesModal{{ $user->id }}">Voir Congés</button>
                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#missionsModal{{ $user->id }}">Voir Missions</button>
                </td>
            </tr>

            <!-- Modal Congés -->
            <div class="modal fade" id="congesModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Congés de {{ $user->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
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
                                        <td>{{ $conge->id }}</td>
                                        <td>{{ $conge->date_debut }}</td>
                                        <td>{{ $conge->date_fin }}</td>
                                        <td>{{ $conge->type }}</td>
                                        <td>{{ $conge->statut }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.deleteConge', $conge->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce congé ?')">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Formulaire ajout congé -->
                            <form method="POST" action="{{ route('admin.addConge', $user->id) }}" class="mt-3">
                                @csrf
                                <div class="row g-2">
                                    <div class="col">
                                        <input type="date" name="date_debut" class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <input type="date" name="date_fin" class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="type" class="form-control" placeholder="Type de congé" required>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-success">Ajouter Congé</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Missions -->
            <div class="modal fade" id="missionsModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Missions de {{ $user->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
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
                                        <td>{{ $mission->id }}</td>
                                        <td>{{ $mission->titre }}</td>
                                        <td>{{ $mission->description }}</td>
                                        <td>{{ $mission->date_debut }}</td>
                                        <td>{{ $mission->date_fin }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.deleteMission', $mission->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette mission ?')">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Formulaire ajout mission -->
                            <form method="POST" action="{{ route('admin.addMission', $user->id) }}" class="mt-3">
                                @csrf
                                <div class="row g-2">
                                    <div class="col">
                                        <input type="text" name="titre" class="form-control" placeholder="Titre" required>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="description" class="form-control" placeholder="Description" required>
                                    </div>
                                    <div class="col">
                                        <input type="date" name="date_debut" class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <input type="date" name="date_fin" class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-success">Ajouter Mission</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
