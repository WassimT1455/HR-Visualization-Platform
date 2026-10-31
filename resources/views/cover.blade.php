<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Congés et Missions - Détection de Connexions Suspectes</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #FFA500;
            --primary-dark: #FF8C00;
            --background: #FFFFFF;
            --foreground: #1a1a1a;
            --secondary: #f5f5f5;
            --border: #e0e0e0;
            --text-muted: #666666;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background);
            color: var(--foreground);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* HEADER */
        header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            transition: var(--transition);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo img {
            height: 50px;
            width: auto;
        }

        nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        nav a {
            color: var(--foreground);
            text-decoration: none;
            font-weight: 500;
            transition: color var(--transition);
            font-size: 0.95rem;
        }

        nav a:hover {
            color: var(--primary);
        }

        .btn-about {
            background: var(--primary);
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
            font-family: inherit;
        }

        .btn-about:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 165, 0, 0.3);
        }

        /* PROFILE BUTTON */
        .profile-container {
            position: relative;
        }

        .profile-btn {
            background: var(--secondary);
            border: 2px solid var(--border);
            color: var(--foreground);
            padding: 0.625rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
            font-family: inherit;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .profile-btn:hover {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
        }

        /* DROPDOWN MENU */
        .profile-dropdown {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            min-width: 280px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 100;
        }

        .profile-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .profile-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--border);
            background: var(--secondary);
            border-radius: 8px 8px 0 0;
        }

        .profile-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .profile-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 0.25rem;
        }

        .profile-email {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .profile-info {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            color: var(--primary);
            width: 20px;
            text-align: center;
        }

        .info-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .info-value {
            color: var(--foreground);
            font-weight: 600;
            margin-left: auto;
        }

        .profile-actions {
            padding: 0.5rem;
        }

        .dropdown-btn {
            width: 100%;
            padding: 0.75rem 1rem;
            background: transparent;
            border: none;
            color: var(--foreground);
            text-align: left;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            border-radius: 6px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-family: inherit;
        }

        .dropdown-btn:hover {
            background: var(--secondary);
        }

        .dropdown-btn.logout {
            color: #dc2626;
        }

        .dropdown-btn.logout:hover {
            background: #fee;
        }

        /* HERO */
        .hero {
            max-width: 1200px;
            margin: 0 auto;
            padding: 5rem 1.5rem;
            text-align: center;
            min-height: 70vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.1;
            color: var(--foreground);
        }

        .hero-accent {
            color: var(--primary);
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-family: inherit;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 165, 0, 0.3);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            padding: 0.875rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-family: inherit;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        /* FEATURES */
        .features {
            background: var(--secondary);
            padding: 5rem 1.5rem;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 1rem;
            color: var(--foreground);
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            padding: 2rem;
            border-radius: 12px;
            transition: var(--transition);
            cursor: pointer;
        }

        .feature-card:hover {
            border-color: var(--primary);
            box-shadow: 0 8px 24px rgba(255, 165, 0, 0.15);
            transform: translateY(-4px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--foreground);
        }

        .feature-description {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.7;
        }

        /* BENEFITS */
        .benefits {
            padding: 5rem 1.5rem;
        }

        .benefits-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .benefits-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .benefits-text h2 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: var(--foreground);
        }

        .benefit-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .benefit-icon {
            width: 40px;
            height: 40px;
            background: var(--primary);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }

        .benefit-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .benefit-text strong {
            color: var(--foreground);
            display: block;
            margin-bottom: 0.25rem;
        }

        .benefit-text p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .benefits-image {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 12px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            text-align: center;
            padding: 2rem;
        }

        /* CTA SECTION */
        .cta {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 4rem 1.5rem;
            text-align: center;
        }

        .cta-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .btn-cta {
            background: white;
            color: var(--primary);
            padding: 1rem 2.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            font-family: inherit;
        }

        .btn-cta:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* FOOTER */
        footer {
            background: var(--foreground);
            color: white;
            padding: 2rem 1.5rem;
            text-align: center;
            border-top: 1px solid var(--border);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            font-size: 0.95rem;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            animation: fadeIn 0.3s ease;
            overflow-y: auto;
            padding: 1rem;
        }

        .modal.show {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding-top: 2rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            max-width: 600px;
            width: 100%;
            animation: slideUp 0.3s ease;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-header h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--foreground);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
            transition: color var(--transition);
        }

        .modal-close:hover {
            color: var(--foreground);
        }

        .modal-body {
            color: var(--text-muted);
            line-height: 1.8;
            font-size: 1rem;
        }

        .modal-body h3 {
            color: var(--foreground);
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .modal-body ul {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .modal-body li {
            margin-bottom: 0.5rem;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .header-container {
                flex-wrap: wrap;
            }

            nav {
                order: 2;
                width: 100%;
                justify-content: center;
                gap: 1rem;
            }

            .profile-container {
                order: 3;
            }

            .profile-dropdown {
                right: auto;
                left: 50%;
                transform: translateX(-50%) translateY(-10px);
            }

            .profile-dropdown.show {
                transform: translateX(-50%) translateY(0);
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.75rem;
            }

            .benefits-content {
                grid-template-columns: 1fr;
            }

            .benefits-image {
                height: 250px;
            }

            .modal {
                padding: 1rem;
            }

            .modal.show {
                padding-top: 1rem;
            }

            .modal-content {
                padding: 1.5rem;
                max-width: calc(100% - 2rem);
            }

            .modal-header h2 {
                font-size: 1.5rem;
            }

            .modal-body {
                font-size: 0.95rem;
            }

            .cta h2 {
                font-size: 1.75rem;
            }

            .btn-primary,
            .btn-secondary {
                font-size: 0.9rem;
                padding: 0.75rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="header-container">
            <a href="#" class="logo">
                HR Platform
            </a>
            <nav>
                <a href="{{ route('conges.my') }}">Congés</a>
                <a href="{{ route('missions.my') }}">Missions</a>
                <a href="{{ route('dashboard.connexions') }}">Connexions</a>
                <button class="btn-about" onclick="openAboutModal()">À propos</button>
            </nav>
            
            <!-- PROFILE BUTTON -->
            <div class="profile-container">
                <button class="profile-btn" onclick="toggleProfileDropdown()">
                    <i class="fas fa-user-circle"></i>
                    Profil
                    <i class="fas fa-chevron-down" style="font-size: 0.75rem;"></i>
                </button>
                
                <!-- DROPDOWN -->
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="profile-name">{{ Auth::user()->name ?? 'Utilisateur' }}</div>
                        <div class="profile-email">{{ Auth::user()->email ?? 'user@example.com' }}</div>
                    </div>
                    
                    <div class="profile-info">
                        <div class="info-item">
                            <i class="fas fa-id-card info-icon"></i>
                            <span class="info-label">Matricule</span>
                            <span class="info-value">{{ Auth::user()->matricule ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-briefcase info-icon"></i>
                            <span class="info-label">Fonction</span>
                            <span class="info-value">{{ Auth::user()->fonction ?? 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-check info-icon"></i>
                            <span class="info-label">Solde congés</span>
                            <span class="info-value">{{ Auth::user()->solde_conges ?? '0' }} jours</span>
                        </div>
                    </div>
                    
                    <div class="profile-actions">
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-btn logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="hero">
<h1>Supervision Intelligente <span class="hero-accent">des Congés et Missions</span></h1>
        <p>Détectez les connexions suspectes avec notre technologie ML avancée. Sécurisez et optimisez l'affichage de vos ressources humaines.</p>
        <div class="hero-buttons">
            <a href="{{ route('conges.my') }}" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i> Commencer
            </a>
            <button class="btn-secondary" onclick="openAboutModal()">En savoir plus</button>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="features">
        <div class="features-container">
            <h2 class="section-title">Nos Fonctionnalités</h2>
            <p class="section-subtitle">Une solution complète pour visualiser vos congés, missions et connexions</p>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="feature-title">Affichage des Congés</h3>
                    <p class="feature-description"> Visualisez vos congés à l'aide d'une interface intuitive.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="feature-title">Organisation des Missions</h3>
                    <p class="feature-description">Planifiez les différentes missions professionnelles avec un contrôle total.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3 class="feature-title">Détection ML</h3>
                    <p class="feature-description">Intelligence artificielle pour détecter les connexions suspectes et renforcer la sécurité.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Sécurité Avancée</h3>
                    <p class="feature-description">Protection des données avec les dernières normes de sécurité informatique.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Analytics</h3>
                    <p class="feature-description">Tableaux de bord détaillés pour analyser les tendances et les patterns.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Collaboration</h3>
                    <p class="feature-description">Travaillez ensemble en temps réel avec des outils collaboratifs intégrés.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- BENEFITS SECTION -->
    <section class="benefits">
        <div class="benefits-container">
            <div class="benefits-content">
                <div class="benefits-text">
                    <h2>Pourquoi nous choisir?</h2>
                    <div class="benefit-item">
                        <div class="benefit-icon">✓</div>
                        <div class="benefit-text">
                            <strong>Technologie ML Avancée</strong>
                            <p>Détection en temps réel des anomalies et des connexions suspectes</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">✓</div>
                        <div class="benefit-text">
                            <strong>Interface Intuitive</strong>
                            <p>Facile à utiliser pour tous les niveaux d'expertise technique</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">✓</div>
                        <div class="benefit-text">
                            <strong>Support 24/7</strong>
                            <p>Équipe dédiée pour vous aider à tout moment</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">✓</div>
                        <div class="benefit-text">
                            <strong>Conformité Réglementaire</strong>
                            <p>Respecte toutes les normes de sécurité et de confidentialité</p>
                        </div>
                    </div>
                </div>
                <div class="benefits-image">
                    <div style="text-align: center;">
                        <i class="fas fa-lock" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                        <p>Sécurité Maximale</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta">
        <div class="cta-container">
            <h2>Prêt à transformer votre gestion RH?</h2>
            <p>Rejoignez des centaines d'entreprises qui font confiance à notre plateforme.</p>
            <button class="btn-cta" onclick="window.location.href='{{ route('conges.my') }}'">Commencer maintenant</button>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2026 HR Platform - Gestion Intelligente. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- ABOUT MODAL -->
    <div id="aboutModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>À propos de notre plateforme</h2>
                <button class="modal-close" onclick="closeAboutModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p><strong>Objectif Principal:</strong></p>
                <p>Notre plateforme révolutionne la gestion des ressources humaines en combinant deux piliers essentiels :</p>
                <h3>🗓️ Affichage Intuitif</h3>
<ul>
    <li><strong>Congés :</strong> Consultation claire des périodes de congés, statuts et soldes</li>
    <li><strong>Missions :</strong> Visualisation des missions attribuées, détails et historique</li>
</ul>


               
                <h3>🤖 Technologie Machine Learning</h3>
                <p>Notre système de détection alimenté par l'IA identifie automatiquement :</p>
                <ul>
                    <li>Les connexions suspectes et les tentatives d'accès non autorisées</li>
                    <li>Les patterns anormaux de comportement utilisateur</li>
                    <li>Les risques de sécurité potentiels en temps réel</li>
                </ul>

                <h3>🔒 Sécurité Maximale</h3>
                <p>Protégez vos données avec chiffrement de bout en bout, authentification multi-facteurs, et conformité RGPD.</p>
            </div>
        </div>
    </div>

    <script>
        function openAboutModal() {
            document.getElementById('aboutModal').classList.add('show');
        }

        function closeAboutModal() {
            document.getElementById('aboutModal').classList.remove('show');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('aboutModal');
            if (event.target === modal) {
                modal.classList.remove('show');
            }
        }
       
    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('show');
    }

    // Fermer le menu profil si on clique ailleurs
    document.addEventListener('click', function (event) {
        const profileContainer = document.querySelector('.profile-container');
        const dropdown = document.getElementById('profileDropdown');

        if (!profileContainer.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });


    </script>
</body>
</html>