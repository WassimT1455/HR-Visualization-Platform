// resources/js/global.js

// Fonction pour toggle le dark mode
function toggleTheme() {
    const html = document.documentElement;      // On cible <html>
    const isDark = html.classList.toggle('dark'); // Toggle classe 'dark'
    localStorage.setItem('theme', isDark ? 'dark' : 'light'); // Sauvegarde le choix
}

// Au chargement de la page, applique le thème choisi
document.addEventListener('DOMContentLoaded', () => {
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    }
});
