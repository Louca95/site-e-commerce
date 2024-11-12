<?php
// Gestion des routes du projet

// PENSER À IMPORTER LES CONTROLLERS

include __DIR__ . '/../controllers/adminController.php';
include __DIR__ . '/../controllers/productController.php';
include __DIR__ . '/../controllers/cartController.php';
// Simplifier l'URI en supprimant le préfixe
$baseUri = '/08_Site_boutique_base';

// Extraction de l'URI demandée par l'utilisateur depuis la requête HTTP
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
var_dump($uri);

// Vérifie si l'URI commence par le préfixe défini dans $baseUri
if (strpos($uri, $baseUri) === 0) {
    // Si c'est le cas, on retire le préfixe pour obtenir l'URI relative
    $uri = substr($uri, strlen($baseUri));
}

echo 'URI : ' . $uri . '<br>'; // Affiche l'URI pour vérification


// Définition des routes disponibles et des fonctions correspondantes
$routes = [
    '/admin/dashboard' => 'dashboard',
    '/admin/orders' => 'viewOrders',
    '/admin/logout' => 'logout',
    '/cart' => 'showCart',
    '/cart/add' => 'addToCart',
    '/checkout' => 'checkout', 
];

// Gestion des routes
if (array_key_exists($uri, $routes)) { // Vérifie si l'URI demandée existe dans les routes définies
    $functionName = $routes[$uri]; // Récupère le nom de la fonction associée à l'URI
    if (function_exists($functionName)) { // Vérifie si la fonction existe
        $functionName(); // Appelle la fonction correspondante
    } else {
        // Si la fonction n'existe pas, affiche un message d'erreur
        echo 'Fonction non trouvée : ' . htmlspecialchars($functionName);
    }
} 
else {
    // Si l'URI demandée n'existe pas dans les routes, affiche un message d'erreur
    echo 'Route inconnue : ' . htmlspecialchars($uri);
    include __DIR__ . '/../views/404.php'; // Page 404 pour les routes inexistantes
}
?>
