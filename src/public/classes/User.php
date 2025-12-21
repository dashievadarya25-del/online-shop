<?php

class User
{
    public function getRegistrate()
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            header('location: /catalog');
        }
        require_once './pages/registration_form.php';
    }


    public function registrate()
    {
        $errors = $this->regValidate($_POST);

// добавляем в БД, если нет ошибок
        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordrepeat = $_POST['psw-repeat'];

            $password = password_hash($password, PASSWORD_DEFAULT);
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');

            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);

            $result = $stmt->fetch();
            print_r($result);
        }
        require_once './pages/registration_form.php';
    }

    private function regValidate(array $data): array
    {
        $errors = [];

        //объявление и валидация данных
        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 3) {
                $errors['name'] = "Name must be at least 3 characters";
            }
        } else {
            $errors['name'] = "Name is required";
        }

        if (isset($data['email'])) {
            $email = $data['email'];

            if (strlen($email) < 2) {
                $errors['email'] = 'email не должен быть меньше 2 символов';
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'email некорректный';
            } else {
                //соединение с БД
                $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $count = $stmt->fetchColumn();
                if ($count > 0) {
                    $errors['email'] = "этот email уже существует";
                }
            }
        } else {
            $errors['email'] = 'email должен быть заполнен';
        }

        if (isset($data['psw'])) {
            $password = $data ['psw'];

            if (strlen($password) < 4) {
                $errors['psw'] = 'Пароль не должен быть меньше 4';
            }

            $passwordrepeat = $data['psw-repeat'];
            if ($password !== $passwordrepeat) {
                $errors['psw-repeat'] = 'пароли не совпадают';
            }
        } else {
            $errors['psw'] = 'Пароль должен быть заполнен';
        }

        return $errors;
    }

    public function getLogin()
    {
        require_once './pages/login_form.php';
    }

    public function login()
    {

        $errors = $this->logValidate($_POST);

        if (empty($errors)) {
            $username = $_POST["u"];
            $password = $_POST["p"];

            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $username]);

            $user = $stmt->fetch();
            if (!empty($user)) {
                $passwordDb = $user['password'];

                if (password_verify($password, $passwordDb)) {
                    //вход через сессии
                    session_start();
                    $_SESSION['userId'] = $user['id'];
                    //вход через куки
                    // setcookie('user_id', $user['id']);
                    header("Location: /catalog");
                } else {
                    $errors['u'] = 'username or password incorrect';
                }
            } else {
                $errors['u'] = 'пользователя с таким логином не существует';
            }
        }

        require_once './login';
    }

    function logValidate(array $data): array
    {
        $errors = [];

        if (!isset($data['u'])) {
            $errors['u'] = 'Поле Username обязательно для заполнения';
        }
        if (!isset($data['p'])) {
            $errors['p'] = 'Поле Password обязательно для заполнения';
        }
        return $errors;
    }

    public function getProfile()
    {
        require_once './pages/profile_page.php';
    }

    public function profile()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');

            $stmt = $pdo->query('SELECT * FROM users WHERE id = ' . $_SESSION['userId']);
            $user = $stmt->fetch();

            require_once './pages/profile_page.php';
        } else {
            header("Location: /login");
        }
    }


    public function getEditprofile()
    {
        require_once './pages/edit_profile_form.php';
    }
    public function editProfile()
    {
        if (isset($_SESSION['userId'])) {

            $errors = $this->editProfilevalidate($_POST);

            if (empty($errors)) {
                $firstName = $_POST['first-name'];
                $address = $_POST['address'];
                $password = $_POST['password'];

                // Начало SQL-запроса
                $sql = "UPDATE users SET name = :firstName, email = :address, password = :password WHERE id = :userId";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':firstName' => $firstName, ':address' => $address, ':password' => $password,
                    ':userId' => $_SESSION['userId']]);

            }
            header("Location: /profile");
            exit;

        }
        require_once './pages/edit_profile_form.php';
    }
    function editProfilevalidate(array $data): array
    {
        $errors = [];

        if (!isset($data['first-name'])) {
            $errors['first-name'] = 'Поле Username обязательно для заполнения';
        }

        if (!isset($data['address'])) {
            $errors['address'] = 'Поле Email обязательно для заполнения';
        }

        if (!isset($data['password'])) {
            $errors['password'] = 'Поле Password обязательно для заполнения';
        }
        return $errors;
    }

}





