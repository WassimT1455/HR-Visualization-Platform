<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte - HR Platform</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #FF8C00;
            --dark-color: #1a1a1a;
            --light-color: #ffffff;
            --gray-light: #f5f5f5;
            --gray-medium: #cccccc;
            --gray-dark: #666666;
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, var(--dark-color) 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem;
        }

        .signup-container {
            background: var(--light-color);
            border-radius: var(--border-radius);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            animation: slideInUp 0.6s ease-out;
        }

        .signup-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #ff7700 100%);
            color: var(--light-color);
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .signup-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .signup-header p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .signup-body {
            padding: 2rem;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: #fee;
            color: #c00;
            border-left: 4px solid #c00;
        }

        .alert ul {
            margin: 0.5rem 0 0 1rem;
            padding: 0;
        }

        .alert li {
            list-style: disc;
            margin-bottom: 0.25rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            border-radius: 8px;
            border: 2px solid var(--gray-medium);
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: var(--transition);
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(255, 140, 0, 0.15);
        }

        .password-hint {
            font-size: 0.85rem;
            color: var(--gray-dark);
            margin-top: 0.25rem;
        }

        .btn {
            width: 100%;
            padding: 0.875rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #ff7700 100%);
            color: var(--light-color);
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 140, 0, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: var(--light-color);
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gray-medium);
        }

        .divider span {
            background: var(--light-color);
            padding: 0 1rem;
            position: relative;
            color: var(--gray-dark);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .footer-text {
            text-align: center;
            margin-top: 1rem;
            color: var(--gray-dark);
            font-size: 0.85rem;
        }

        .footer-text a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Responsive */
        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }

            .signup-header {
                padding: 2rem 1.5rem;
            }

            .signup-header h1 {
                font-size: 1.75rem;
            }

            .signup-body {
                padding: 1.5rem;
            }

            .form-control {
                padding: 0.75rem 0.875rem;
                font-size: 16px;
            }

            .btn {
                padding: 0.75rem;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-header">
            <h1>👤 Créer un compte</h1>
            <p>Rejoignez-nous en tant qu'employé</p>
        </div>

        <div class="signup-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Erreur :</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('signup.post') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Nom complet</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control" 
                        id="name" 
                        placeholder="John Doe" 
                        value="{{ old('name') }}" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email professionnel</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control" 
                        id="email" 
                        placeholder="john.doe@entreprise.com" 
                        value="{{ old('email') }}" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="matricule" class="form-label">Matricule</label>
                    <input 
                        type="text" 
                        name="matricule" 
                        class="form-control" 
                        id="matricule" 
                        placeholder="EMP-001" 
                        value="{{ old('matricule') }}" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="fonction" class="form-label">Fonction</label>
                    <input 
                        type="text" 
                        name="fonction" 
                        class="form-control" 
                        id="fonction" 
                        placeholder="Développeur, Commercial, etc." 
                        value="{{ old('fonction') }}" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-control" 
                        id="password" 
                        placeholder="••••••••" 
                        required
                    >
                    <div class="password-hint">Minimum 8 caractères</div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="form-control" 
                        id="password_confirmation" 
                        placeholder="••••••••" 
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    ✅ Créer mon compte
                </button>
            </form>

            <div class="divider">
                <span>Déjà inscrit ?</span>
            </div>

            <a href="/login" class="btn btn-outline">
                🔙 Retour à la connexion
            </a>

            <div class="footer-text">
                Vous êtes administrateur ? 
                <a href="/register">Inscription admin</a>
            </div>
        </div>
    </div>
</body>
</html>