<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter - HR Platform</title>
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
            --border-radius: 12px;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, var(--dark-color) 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            position: relative;
            width: 100%;
            max-width: 900px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        /* Logo Header */
        .logo-container {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            width: 100%;
            text-align: center;
        }

        .logo {
            height: 50px;
            width: auto;
            opacity: 0.9;
            animation: slideDown 0.6s ease-out;
        }

        /* Left Side - Brand Content */
        .brand-content {
            display: flex;
            flex-direction: column;
            gap: 30px;
            padding: 20px;
        }

        .brand-content h1 {
            font-size: 2.5rem;
            color: var(--light-color);
            line-height: 1.2;
            font-weight: 700;
            animation: fadeInUp 0.8s ease-out;
        }

        .brand-content p {
            font-size: 1.1rem;
            color: #b0b0b0;
            line-height: 1.6;
            animation: fadeInUp 0.8s ease-out 0.1s both;
        }

        .features-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #b0b0b0;
            font-size: 0.95rem;
        }

        .feature-icon {
            width: 20px;
            height: 20px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            font-weight: bold;
            flex-shrink: 0;
        }

        /* Right Side - Login Form */
        .login-card {
            background: var(--light-color);
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideInRight 0.6s ease-out;
        }

        .login-card h2 {
            font-size: 1.8rem;
            color: var(--dark-color);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .login-card-subtitle {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            animation: fadeInUp 0.6s ease-out;
        }

        .form-group label {
            display: block;
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid var(--gray-medium);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.1);
        }

        .alert {
            background: #fee;
            color: #c00;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c00;
            font-size: 0.9rem;
            animation: slideInDown 0.4s ease-out;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #ff7700 100%);
            color: var(--light-color);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 140, 0, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translate(-50%, -20px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 30px;
                padding-top: 80px;
            }

            .logo-container {
                top: 20px;
            }

            .brand-content {
                display: none;
            }

            .login-card {
                padding: 30px 24px;
            }

            .login-card h2 {
                font-size: 1.5rem;
            }

            .brand-content h1 {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 24px 16px;
            }

            .form-group input {
                padding: 11px 12px;
                font-size: 16px;
            }

            .submit-btn {
                padding: 12px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="logo-container">
    </div>

    <div class="container">
        <!-- Left Side - Brand Content -->
        <div class="brand-content">
            <h1>Bienvenue</h1>
            <p>Gérez facilement les congés, les missions et surveillez les connexions suspectes avec notre plateforme alimentée par l'intelligence artificielle.</p>
            <div class="features-list">
                <div class="feature-item">
                    <div class="feature-icon">✓</div>
                    <span>Gestion automatisée des congés</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">✓</div>
                    <span>Suivi des missions en temps réel</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">✓</div>
                    <span>Détection IA des connexions</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-card">
            <h2>Se connecter</h2>
            <p class="login-card-subtitle">Accédez à votre compte</p>

            @if(Session::has('error'))
                <div class="alert">
                    {{ Session::get('error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <input type="hidden" name="client_hour" id="client_hour">

                <div class="form-group">
                    <label for="email">Adresse mail</label>
                    <input type="email" name="email" id="email" placeholder="you@example.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="submit-btn">Se connecter</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const now = new Date();
            document.getElementById('client_hour').value = now.getHours();
        });
    </script>
</body>
</html>