<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connexion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Stevebauman\Location\Facades\Location;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Schema;

class AuthController extends Controller
{
    private const WORK_START_HOUR = 8;
    private const WORK_END_HOUR = 17;
    private const HTTP_SUCCESS = 200;
    private const HTTP_FORBIDDEN = 403;

    /** URL of the ML prediction API (configured with ML_API_URL in .env). */
    private function predictionApiUrl(): string
    {
        return (string) config('services.ml_api.url');
    }

    /* =========================
       REGISTER - ADMIN SEULEMENT
    ========================= */
    public function register()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/cover')->with('error', 'Accès refusé : réservé aux administrateurs');
        }
        return view('register');
    }
public function deleteUser($id)
{
    $user = User::findOrFail($id);

    // Optionnel : empêcher un admin de se supprimer lui-même
    if (auth()->id() === $user->id) {
        return redirect()->back()->with('error', 'Vous ne pouvez pas vous supprimer vous-même.');
    }

    $user->delete();

    return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
}

    public function registerPost(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/cover')->with('error', 'Accès refusé : réservé aux administrateurs');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role ?? 'user',
            'matricule' => $request->matricule,
            'fonction' => $request->fonction,
            'solde_conges' => $request->solde_conges ?? 0,
        ]);

        return back()->with('success', 'Inscription réussie');
    }

    /* =========================
       SIGN UP - PUBLIC (EMPLOYÉS)
    ========================= */
    public function signup()
    {
        return view('signup');
    }

    public function signupPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'matricule' => 'required|string|max:50',
            'fonction' => 'required|string|max:100',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'employee',
            'matricule' => $request->matricule,
            'fonction' => $request->fonction,
            'solde_conges' => 30,
        ]);

        return redirect('/login')->with('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
    }

    /* =========================
       LOGIN / LOGOUT
    ========================= */
    public function login()
    {
        return view('login');
    }

        public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $connectionData = $this->collectConnectionData($request);

        if (!Auth::attempt($request->only('email', 'password'))) {
            $this->logConnexion(null, $connectionData, self::HTTP_FORBIDDEN);
            return back()->with('error', 'Email ou mot de passe incorrect');
        }

        $request->session()->regenerate();
        $this->processSuccessfulLogin(Auth::user(), $connectionData);

        return redirect('/cover')->with('success', 'Connexion réussie');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    /* =========================
       DASHBOARD
    ========================= */
    public function dashboard()
    {
        $connexions = Connexion::where('user_id', Auth::id())->latest()->get();
        return view('connexions.dashboard', compact('connexions'));
    }

    /* =========================
       COLLECT CONNECTION DATA
    ========================= */
    private function collectConnectionData(Request $request): array
    {
        $userIp = $request->ip();
        if (in_array($userIp, ['127.0.0.1', '::1'])) {
            $userIp = trim(@file_get_contents("https://api64.ipify.org"));
        }

        $location = Location::get($userIp);
        $country = $location?->countryName ?? 'Algeria';

        $agent = new Agent();
        $userAgent = $request->userAgent() ?? '';

        $browser = $this->detectBrowser($userAgent, $agent);
        $device = $this->detectDevice($userAgent, $agent);
        $os = $this->detectOS($userAgent, $agent);

        $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');

        $now = Carbon::now();
        $hour = $now->hour;
        $distanceHoraire = max(0, $hour < self::WORK_START_HOUR
            ? self::WORK_START_HOUR - $hour
            : ($hour > self::WORK_END_HOUR ? $hour - self::WORK_END_HOUR : 0));

        return [
            'userIp' => $userIp,
            'country' => $country,
            'browser' => $browser,
            'os' => $os,
            'device' => $device,
            'deviceType' => $deviceType,
            'userAgent' => $userAgent,
            'loginTime' => $now->format('Y-m-d H:i:s'),
            'date' => $now->toDateString(),
            'time' => $now->toTimeString(),
            'heureConnexion' => $hour,
            'distanceHoraire' => $distanceHoraire,
        ];
    }

    /* =========================
       DETECT BROWSER / DEVICE / OS
    ========================= */
    private function detectBrowser(string $userAgent, Agent $agent): string
    {
        $browser = $agent->browser();
        if (!empty($browser) && is_string($browser)) return $browser;

        $ua = strtolower($userAgent);
        if (strpos($ua, 'edg/') !== false || strpos($ua, 'edge/') !== false) return 'Edge';
        if (strpos($ua, 'opr/') !== false || strpos($ua, 'opera') !== false) return 'Opera';
        if (strpos($ua, 'chrome/') !== false) return 'Chrome';
        if (strpos($ua, 'firefox/') !== false) return 'Firefox';
        if (strpos($ua, 'safari/') !== false && strpos($ua, 'chrome') === false) return 'Safari';
        if (strpos($ua, 'msie') !== false || strpos($ua, 'trident/') !== false) return 'Internet Explorer';

        return 'Unknown';
    }

    private function detectDevice(string $userAgent, Agent $agent): string
    {
        $device = $agent->device();
        if (!empty($device) && is_string($device)) return $device;

        $ua = strtolower($userAgent);
        if (strpos($ua, 'iphone') !== false) return 'iPhone';
        if (strpos($ua, 'ipad') !== false) return 'iPad';
        if (strpos($ua, 'android') !== false) return strpos($ua, 'mobile') !== false ? 'Android Phone' : 'Android Tablet';
        if (strpos($ua, 'windows phone') !== false) return 'Windows Phone';
        if (strpos($ua, 'macintosh') !== false || strpos($ua, 'mac os') !== false) return 'Mac';
        if (strpos($ua, 'windows nt') !== false) return 'Windows PC';
        if (strpos($ua, 'linux') !== false && strpos($ua, 'android') === false) return 'Linux PC';

        return 'Desktop';
    }

    private function detectOS(string $userAgent, Agent $agent): string
    {
        $os = $agent->platform();
        if (!empty($os) && is_string($os)) return $os;

        $ua = strtolower($userAgent);
        if (strpos($ua, 'windows nt 10.0') !== false) return 'Windows 10';
        if (strpos($ua, 'windows nt 11.0') !== false) return 'Windows 11';
        if (strpos($ua, 'windows nt') !== false) return 'Windows';
        if (strpos($ua, 'mac os x') !== false) return 'macOS';
        if (strpos($ua, 'android') !== false) return 'Android';
        if (strpos($ua, 'iphone') !== false || strpos($ua, 'ipad') !== false) return 'iOS';
        if (strpos($ua, 'linux') !== false) return 'Linux';

        return 'Unknown';
    }

    /* =========================
       LOGIN SUCCESS
    ========================= */
   private function processSuccessfulLogin(User $user, array $data): void
{
    try {
        // Enregistrer la connexion
        $connexionData = [
            'user_id' => $user->id,
            'ip_address' => $data['userIp'],
            'device' => $data['device'],
            'browser' => $data['browser'],
            'operating_system' => $data['os'],
            'country' => $data['country'],
            'login_time' => $data['loginTime'],
            'heure_connexion' => $data['heureConnexion'],
            'date' => $data['date'],
            'time' => $data['time'],
            'cs_user_agent' => $data['userAgent'],
            'distance_horaire' => $data['distanceHoraire'],
            'cs_status' => self::HTTP_SUCCESS,
            'suspicious' => null,
        ];

        if (Schema::hasColumn('connexions', 'navigateur')) {
            $connexionData['navigateur'] = $data['browser'];
        }

        $connexion = Connexion::create($connexionData);

        // Envoi à l'API pour prédiction
        $payload = [
            'id_utilisateur' => $user->id,
            'heure_connexion' => (int)$data['heureConnexion'],
            'ip' => $data['userIp'],
            'distance_horaire' => (int)$data['distanceHoraire'],
            'cs_status' => self::HTTP_SUCCESS,
            'pays' => $data['country'],
            'navigateur' => $data['browser'],
        ];

        $response = Http::timeout(5)->post($this->predictionApiUrl(), $payload);

        if ($response->successful()) {
            $prediction = $response->json()['prediction'] ?? null;
            if (!is_null($prediction)) {
                $connexion->update(['suspicious' => (int)$prediction]);
            }
        }

    } catch (\Exception $e) {
        Log::error('Exception processSuccessfulLogin', ['message' => $e->getMessage()]);
    }
}


    private function logConnexion($userId, array $data, int $status): void
    {
        Connexion::create([
            'user_id' => $userId,
            'ip_address' => $data['userIp'],
            'device' => $data['device'],
            'browser' => $data['browser'],
            'operating_system' => $data['os'],
            'country' => $data['country'],
            'login_time' => $data['loginTime'],
            'heure_connexion' => $data['heureConnexion'],
            'date' => $data['date'],
            'time' => $data['time'],
            'cs_user_agent' => $data['userAgent'],
            'distance_horaire' => $data['distanceHoraire'],
            'cs_status' => $status,
            'suspicious' => null,
        ]);
    }
 
public function showPredictionForm()
{
    // On peut précharger les données pour le graphique si nécessaire
    $dataChart = $this->getChartData();
    $prediction = null; // Pas encore de prédiction

    return view('prediction', compact('prediction', 'dataChart'));
}
private function getChartData(): array
{
    // Récupère le nombre de connexions suspectes par mois
    $suspectByMonth = \App\Models\Connexion::selectRaw('MONTH(date) as month, COUNT(*) as count')
        ->where('suspicious', 1)
        ->whereNotNull('date')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    $labels = [];
    $data = [];

    $moisNoms = [
        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
    ];

    foreach ($suspectByMonth as $item) {
        $labels[] = $moisNoms[$item->month] ?? 'Mois ' . $item->month;
        $data[] = $item->count;
    }

    return [
        'labels' => $labels,
        'data' => $data
    ];
}
public function predictConnexion(Request $request)
{
    $request->validate([
        'id_utilisateur' => 'required',
        'ip' => 'required',
        'distance_horaire' => 'required|numeric',
        'heure_connexion' => 'required|numeric|min:0|max:23',
        'date' => 'required|date',
        'time' => 'required',
        'cs_status' => 'required|numeric',
        'cs_user_agent' => 'required',
        'pays' => 'required',
        'navigateur' => 'required',
        'appareil' => 'required',
    ]);

    $data = $request->all();

    // Non-admin users can only run predictions for their own account.
    if (Auth::user()->role !== 'admin') {
        $data['id_utilisateur'] = Auth::id();
    }

    $payload = [
        'id_utilisateur' => (int)$data['id_utilisateur'],
        'heure_connexion' => (int)$data['heure_connexion'],
        'ip' => $data['ip'],
        'distance_horaire' => (int)$data['distance_horaire'],
        'cs_status' => (int)$data['cs_status'],
        'pays' => $data['pays'],
        'navigateur' => $data['navigateur'],
    ];

    try {
        $response = \Illuminate\Support\Facades\Http::timeout(10)->post($this->predictionApiUrl(), $payload);
    } catch (\Throwable $e) {
        Log::warning('Prediction API unreachable', ['message' => $e->getMessage()]);

        return back()->withInput()->withErrors([
            'api' => "Le service de prédiction est indisponible (il peut mettre environ une minute à se réveiller). Réessayez dans un instant.",
        ]);
    }

    $prediction = null;

    if ($response->successful()) {
        $prediction = $response->json()['prediction'] ?? null;

        \App\Models\Connexion::create([
            'user_id' => $data['id_utilisateur'],
            'ip_address' => $data['ip'],
            'device' => $data['appareil'],
            'browser' => $data['navigateur'],
            'operating_system' => 'Unknown',
            'country' => $data['pays'],
            'login_time' => $data['date'] . ' ' . $data['time'],
            'heure_connexion' => $data['heure_connexion'],
            'date' => $data['date'],
            'time' => $data['time'],
            'cs_user_agent' => $data['cs_user_agent'],
            'distance_horaire' => $data['distance_horaire'],
            'cs_status' => $data['cs_status'],
            'suspicious' => $prediction,
        ]);

        if ($prediction === 1) {
            $user = \App\Models\User::find($data['id_utilisateur']);
            if ($user) {
                $this->sendSuspiciousConnectionAlert($user, [
                    'country' => $data['pays'],
                    'userIp' => $data['ip'],
                    'browser' => $data['navigateur'],
                    'deviceType' => $data['appareil'],
                    'loginTime' => $data['date'] . ' ' . $data['time'],
                ]);
            }
        }
    }

    $dataChart = $this->getChartData();

    return view('prediction', compact('prediction', 'dataChart'));
}
/**
 * Envoie un email d'alerte pour connexion suspecte
 */
private function sendSuspiciousConnectionAlert(\App\Models\User $user, array $data): void
{
    try {
        \Illuminate\Support\Facades\Mail::raw(
            "⚠️ ALERTE SÉCURITÉ\n\n" .
            "Une connexion suspecte a été détectée sur votre compte.\n\n" .
            "Détails :\n" .
            "- Pays : {$data['country']}\n" .
            "- IP : {$data['userIp']}\n" .
            "- Navigateur : {$data['browser']}\n" .
            "- Appareil : {$data['deviceType']}\n" .
            "- Date : {$data['loginTime']}\n\n" .
            "Si ce n'était pas vous, changez immédiatement votre mot de passe.",
            function ($mail) use ($user) {
                $mail->to($user->email)
                     ->subject('🔒 Alerte sécurité - Connexion suspecte');
            }
        );

        \Illuminate\Support\Facades\Log::info('📧 Email envoyé', ['user_id' => $user->id]);
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('❌ Erreur email', ['error' => $e->getMessage()]);
    }
}

}