<?php 

    class Users extends Controller {
        public function __construct() {
            $this->userModel = $this->model('User');
        }

        public function register() {
            // Check For POST
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process Form

                // Sanitize POST Data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                // Initialize Data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => ''
                ];
                
                // Validate Email
                if(empty($data['email'])) {
                    $data['email_error'] = 'Please enter email';
                } else {
                    // Check Email
                    if($this->userModel->findUserByEmail($data['email'])) {
                        $data['email_error'] = 'Email is already taken';
                    }
                }

                // Validate Name
                if(empty($data['name'])) {
                    $data['name_error'] = 'Please enter name';
                }

                // Validate Password
                if(empty($data['password'])) {
                    $data['password_error'] = 'Please enter password';
                } elseif(strlen($data['password']) < 6) {
                    $data['password_error'] = 'Please must be at least 6 characters';
                }

                // Validate Confirm Password
                if(empty($data['confirm_password'])){
                    $data['confirm_password_error'] = 'Please confirm password';
                } else {
                    if($data['password'] != $data['confirm_password']){
                     $data['confirm_password_error'] = 'Passwords do not match';
                    }
                }
                
                // Make Sure Errors Are Empty
                if(empty($data['email_error']) && empty($data['name_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {
                    // Validated

                    // Hash Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register User
                    if($this->userModel->register($data)) {
                        flash('register_success', 'You are registered and can now log in');
                        redirect('users/login');
                    } else {
                        die('Something Went Wrong');
                    }

                } else {
                  // Load View With Errors
                  $this->view('users/register', $data);   
                }

            } else {
                // Initialize Data
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_error' => '',
                    'email_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => ''
                ];    
                // Load View
                $this->view('users/register', $data);
            }
        }

                public function login() {
            // Check For Post
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process Form

                // Sanitize POST Data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                // Initialize Data
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_error' => '',
                    'password_error' => ''
                ];

                // Validate Email
                if(empty($data['email'])) {
                    $data['email_error'] = 'Please enter email';
                }

                // Validate Password
                if(empty($data['password'])) {
                    $data['password_error'] = 'Please enter password';
                }

                // Make Sure Errors Are Empty
                if(empty($data['email_error']) && empty($data['password_error'])) {
                    // Validated
                    die('SUCCESS');
                } else {
                  // Load View With Errors
                  $this->view('users/login', $data);   
                }


            } else {
                // Initialize Data
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_error' => '',
                    'password_error' => ''
                ];    
                // Load View
                $this->view('users/login', $data);
            }
        }

    }

?>