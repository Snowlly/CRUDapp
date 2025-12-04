<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Charger les routes
include("Controller/route.php");

// Valeurs par défaut
$header="HeaderIndex";
$model=null;
$controleur=null;
$vue="IndexMain";
$footer="Footer";
$action = "index";


// Vérifier la route demandée
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if (isset($routes[$page]) && $routes[$page]['active']) {
        $header = $routes[$page]['header'];
        $model = $routes[$page]['model'];
        $controleur = $routes[$page]['controleur'];
        $vue = $routes[$page]['vue'];
        $footer = $routes[$page]['footer'];
        $action = $_GET['action'] ?? $routes[$page]['action'] ?? 'index';
    }
}

// Charger la classe BDD
include("Model/BDD.php");

// Charger le modèle (si existe)
$modelInstance = null;
if ($model != null) {
    include("Model/" . $model . ".php");
    $modelInstance = new $model();
}

// Charger le contrôleur (si existe)
$data = [];
if ($controleur != null) {
    include("Controller/" . $controleur . ".php");

    $controllerInstance = new $controleur($modelInstance);

    // Exécution de l'action
    if (method_exists($controllerInstance, $action)) {
        
        // Action avec ID ?
        if (isset($_GET['id'])) {
            $data = $controllerInstance->{$action}($_GET['id']);
        } else {
            $data = $controllerInstance->{$action}();
        }

    }
}

// Rendre les données disponibles dans la vue
if (is_array($data)) {
    extract($data);
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("Controller/Head.php"); ?>
</head>
<body>

<?php if($header != null) include("View/Header/" . $header . ".php"); ?>

<?php if($vue != null) include("View/Navigation/" . $vue . ".php"); ?>

<?php if($footer != null) include("View/" . $footer . ".php"); ?>

</body>
</html>
