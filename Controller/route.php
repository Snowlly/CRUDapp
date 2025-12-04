<?php

$routes = array(

    // Main
    'IndexMain' => array('nom' => 'IndexMain', 'header' => 'HeaderIndex', 'footer' => 'Footer', 'controleur' => null, 'model' => '', 'vue' => 'IndexMain', 'js' => 'Accueil', 'bdd' => 'BDD', 'visible' => true, 'active' => true),
    'ProjetMain' => array('nom' => 'ProjetMain', 'header' => 'HeaderPage', 'footer' => 'Footer', 'controleur' => null, 'model' => '', 'vue' => 'ProjetMain', 'js' => '', 'bdd' => 'BDD', 'visible' => true, 'active' => true),

    // Enterprise

    'EnterpriseIndex' => [
    'header' => 'HeaderIndex',
    'footer' => 'Footer',
    'controleur' => 'EnterpriseController',
    'model' => 'EnterpriseModel',
    'vue' => 'Enterprise/index',
    'active' => true,
    'action' => 'index'
    ],

    'EnterpriseShow' => [
    'header' => 'HeaderIndex',
    'footer' => 'Footer',
    'controleur' => 'EnterpriseController',
    'model' => 'EnterpriseModel',
    'vue' => 'Enterprise/show',
    'active' => true,
    'action' => 'show'
    ],

    'EnterpriseCreate' => [
    'header' => 'HeaderIndex',
    'footer' => 'Footer',
    'controleur' => 'EnterpriseController',
    'model' => 'EnterpriseModel',
    'vue' => 'Enterprise/create',
    'active' => true,
    'action' => 'create'
    ],

    'EnterpriseEdit' => [
    'header' => 'HeaderPage',
    'footer' => 'Footer',
    'controleur' => 'EnterpriseController',
    'model' => 'EnterpriseModel',
    'vue' => 'Enterprise/edit',
    'active' => true
    ],

    'EnterpriseDelete' => [
    'nom' => 'EnterpriseDelete',
    'header' => 'HeaderIndex',
    'footer' => 'Footer',
    'controleur' => 'EnterpriseController',
    'model' => 'EnterpriseModel',
    'vue' => null,
    'active' => true,
    'action' => 'delete'
    ],

    // Establishment


    'EstablishmentCreate' => [
    'header' => 'HeaderPage',
    'footer' => 'Footer',
    'controleur' => 'EstablishmentController',
    'model' => 'EstablishmentModel',
    'vue' => 'Establishment/create',
    'active' => true
    ]
);
?>
