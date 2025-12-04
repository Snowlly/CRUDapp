<?php

$routes = array(

    // Main
    'IndexMain' => array('nom' => 'IndexMain', 'header' => 'HeaderIndex', 'footer' => 'Footer', 'controleur' => null, 'model' => '', 'vue' => 'IndexMain', 'js' => 'Accueil', 'bdd' => 'BDD', 'visible' => true, 'active' => true),
    'ProjetMain' => array('nom' => 'ProjetMain', 'header' => 'HeaderPage', 'footer' => 'Footer', 'controleur' => null, 'model' => '', 'vue' => 'ProjetMain', 'js' => '', 'bdd' => 'BDD', 'visible' => true, 'active' => true),

    'EnterpriseIndex' => [
    'header' => 'HeaderPage',
    'footer' => 'Footer',
    'controleur' => 'EnterpriseController',
    'model' => 'EnterpriseModel',
    'vue' => 'Enterprise/index',
    'active' => true
    ],

    'EnterpriseShow' => [
    'header' => 'HeaderPage',
    'footer' => 'Footer',
    'controleur' => 'EnterpriseController',
    'model' => 'EnterpriseModel',
    'vue' => 'Enterprise/show',
    'active' => true
    ],

    'EnterpriseCreate' => [
    'header' => 'HeaderPage',
    'footer' => 'Footer',
    'controleur' => 'EnterpriseController',
    'model' => 'EnterpriseModel',
    'vue' => 'Enterprise/create',
    'active' => true
    ],

    'EnterpriseEdit' => [
    'header' => 'HeaderPage',
    'footer' => 'Footer',
    'controleur' => 'EnterpriseController',
    'model' => 'EnterpriseModel',
    'vue' => 'Enterprise/edit',
    'active' => true
    ],

    'EstablishmentCreate' => [
    'header' => 'HeaderPage',
    'footer' => 'Footer',
    'controleur' => 'EstablishmentController',
    'model' => 'EstablishmentModel',
    'vue' => 'Establishment/create',
    'active' => true
    ],
);
?>
