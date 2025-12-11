<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
<div class="profile-container">
    <h1><img src="https://storage.yandexcloud.net/moskvichmag/uploads/2024/03/angelll1.jpg" alt="User avatar">User profile</h1>
    <form id="profile-form" action="edit_profile.php" method="post">
        <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" name="first-name" value="<?php echo $user['name'];?>" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo $user['email'];?>" required>
        </div>
        <div class="form-group">
            <label for="password">New Password (optional)</label>
            <!-- Это поле для установки нового пароля, старый пароль здесь не отображается -->
            <input type="password" id="password" name="password" value="">
        </div>
        <div class="buttons">
            <!-- Одна кнопка "Сохранить" -->
            <button type="submit" class="save">Save Profile</button>
        </div>
    </form>
</div>
</body>
</html>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .profile-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 400px;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    h1 img {
        width: 100px;
        display: block;
        margin: auto;
        transition: 0.5s;
        &:hover {
            scale: 0.9;
        }
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
        display: block;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .form-group input[readonly] {
        background-color: #f4f4f4;
    }

    .form-group input[type="password"] {
        font-family: Arial, sans-serif;
    }

    .buttons {
        display: flex;
        justify-content: flex-end;
    }

    .buttons button {
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .buttons button.edit {
        background-color: #333;
        color: white;
    }

    .buttons button.save {
        background-color: #ee962b;
        color: white;
    }

    .buttons button:hover {
        opacity: 0.8;
    }
</style>
