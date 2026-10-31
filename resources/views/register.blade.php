@if(!Auth::check() || Auth::user()->role !== 'admin')
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accès refusé</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .access-denied-box {
                background: white;
                border-radius: 20px;
                padding: 3rem;
                text-align: center;
                max-width: 500px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            }
            .icon-lock {
                font-size: 5rem;
                margin-bottom: 1rem;
            }
            h1 {
                color: #333;
                margin-bottom: 1rem;
            }
            p {
                color: #666;
                margin-bottom: 2rem;
            }
            .btn-home {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                padding: 1rem 2rem;
                font-size: 1.1rem;
                border-radius: 10px;
                transition: transform 0.2s;
            }
            .btn-home:hover {
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body>
        <div class="access-denied-box">
            <div class="icon-lock">🔒</div>
            <h1>Accès refusé</h1>
            <p>Cette page d'inscription est réservée aux administrateurs. Vous n'avez pas les permissions nécessaires pour créer de nouveaux utilisateurs.</p>
            <a href="/cover" class="btn btn-primary btn-home">Retour à l'accueil</a>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Admin Only</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="row justify-content-center mt-5">
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title mb-0">📝 Inscription (Admin)</h1>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        ✅ {{ Session::get('success') }}
                    </div>
                @endif
                
                <div class="alert alert-info">
                    <strong>👤 Connecté en tant que :</strong> {{ Auth::user()->name }} ({{ Auth::user()->role }})
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom complet</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select name="role" id="role" class="form-control">
                            <option value="employee">Employé</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="matricule" class="form-label">Matricule</label>
                        <input type="text" name="matricule" class="form-control" id="matricule" placeholder="MAT-001" required>
                    </div>
                    <div class="mb-3">
                        <label for="fonction" class="form-label">Fonction</label>
                        <input type="text" name="fonction" class="form-control" id="fonction" placeholder="Développeur" required>
                    </div>
                    <div class="mb-3">
                        <label for="solde_conges" class="form-label">Solde de Congés (jours)</label>
                        <input type="number" name="solde_conges" class="form-control" id="solde_conges" value="30" required>
                    </div>
                    <div class="mb-3">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary">✅ Créer le compte</button>
                            <a href="/cover" class="btn btn-secondary">Retour</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('6b2ccd232df2447a9698', {
        cluster: 'eu'
    });

    var channel = pusher.subscribe('suivi');
    channel.bind('suivi-notif', function(data) {
        // Vérifiez si l'utilisateur est un administrateur avant d'afficher la notification
        if ('{{ Auth::user()->role }}' === 'admin') {
            toastr.info(`Le suivi de la mission a été modifié.`);
        }
    });
</script>
</body>
</html>