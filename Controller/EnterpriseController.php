<?php

class EnterpriseController {

    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    // Page liste + recherche
    public function index() {
        $search = $_GET['q'] ?? null;
        $enterprises = $this->model->search($search);

        return [
            'enterprises' => $enterprises,
            'search' => $search
        ];
    }

    // Page fiche entreprise
    public function show($id) {
        $id = trim($id);
        return [
            'enterprise'     => $this->model->getById($id),
            'denominations'  => $this->model->getDenominations($id),
            'addresses'      => $this->model->getAddresses($id),
            'activities'     => $this->model->getActivities($id),
            'establishments' => $this->model->getEstablishments($id)
        ];
    }

    public function create() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $result = $this->model->create($_POST);

        if ($result === true) {
            header("Location: index.php?page=EnterpriseIndex");
            exit;
        }

        // Retourne les erreurs à la vue
        return ['errors' => $result];
    }

    return [];
}

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST);
            header("Location: index.php?page=EnterpriseShow&action=show&id=$id");
            exit;
        }

        return [
            'enterprise' => $this->model->getById($id)
        ];
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?page=EnterpriseIndex");
        exit;
    }
}
?>
