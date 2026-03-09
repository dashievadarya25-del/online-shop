<?php
namespace Controllers;
use Model\User;
use Request\EditprofileRequest;
use Request\LoginRequest;
use Request\RegistrateRequest;

class UserController extends BaseController
{
    private User $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    public function getRegistrate()
    {
        require_once '../Views/registration_form.php';
    }


    public function registrate(RegistrateRequest $request)
    {
        $errors = $request->validate();

// добавляем в БД, если нет ошибок
        if (empty($errors)) {
//            $name = $_POST['name'];
//            $email = $_POST['email'];
//            $password = $_POST['psw'];
//            $passwordrepeat = $_POST['psw-repeat'];

            $password = password_hash($request->getPassword(), PASSWORD_DEFAULT);

            $this->userModel->insertUsers($request->getName(), $request->getEmail(), $request->getPassword());

            $result = $this->userModel->getByEmail($request->getEmail());

            print_r($result);
        }
        require_once '../Views/registration_form.php';
    }



    public function getLogin()
    {
        require_once '../Views/login_form.php';
    }

    public function login(LoginRequest $request)
    {

        $errors = $request->logValidate();

        if (empty($errors)) {
            $result = $this->authService->auth($request->getEmail(), $request->getPassword());

            if ($result === true) {
                header("Location: /catalog");
                exit();
            } else {
                $errors['autorization'] = 'email или пароль неверный';
            }
        }

        require_once '../Views/login_form.php';
    }



    public function getProfile()
    {
        require_once '../Views/profile_page.php';
    }

    public function profile()
    {
        if ($user = $this->authService->getCurrentUser()) {

            require_once '../Views/profile_page.php';
        } else {
            header("Location: /login");
        }
    }
    public function logout()
    {
        parent::logout();
        header("Location: /login");
        exit();
    }

    public function getEditprofile()
    {
        $user = $this->authService->getCurrentUser();

        require_once '../Views/edit_profile_form.php';
    }

    public function editProfile(EditprofileRequest $request)
    {

        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

        $errors = $request->editProfilevalidate();

        if (empty($errors)) {
//            $name = $data['name'];
//            $email = $data['email'];
//            $password = $data['password'];

            $password = password_hash($request->getPassword(), PASSWORD_DEFAULT);

            $user = $this->authService->getCurrentUser();

            if ($user->getName() !== $request->getName()) {
               $this->userModel->updateNameById($request->getName(), $user->getId());
            }

            if ($user->getName() !== $request->getEmail()) {

                $this->userModel->updateEmailById($request->getEmail(), $user->getId());
            }
            header("Location: /profile");
            exit;
        }


        require_once '../Views/edit_profile_form.php';
    }



}





