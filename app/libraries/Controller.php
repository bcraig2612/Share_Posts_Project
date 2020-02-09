<?php 

// Base Controller
// Loads The Models & Views

class Controller {
    // Load Model
    public function Model($model) {
        // Require Model File
        require_once '../app/models/' . $model . '.php';

        // Instantiate Model
        return new $model();
    }

    // Load View
    public function view($view, $data = []) {
        // Check For View File
        if(file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            // View Does Not Exist
            die('View Does Not Exist');
        }
    }
}

?>