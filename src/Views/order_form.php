<form action="/create-order" method="post">
    <div class="container">
        <h1>Order form</h1>
        <a href="/user-order">Мои заказы</a>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <label for="name"><b>Name</b></label>
        <?php if (isset($errors['contact_name'])): ?>
            <label style="color: red"><?php echo $errors['contact_name']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Enter name" name="contact_name" id="contact_name" required>

        <label for="phone"><b>Phone</b></label>
        <?php if (isset($errors['contact_phone'])): ?>
        <label style="color: red"><?php echo $errors['contact_phone']; ?></form>
        <?php endif; ?>
        <input type="text" placeholder="Enter phone" name="contact_phone" id="contact_phone" required>

        <label for="address"><b>Address</b></label>
        <?php if (isset($errors['address'])): ?>
            <label style="color: red"><?php echo $errors['address']; ?></label>
        <?php endif; ?>
        <input type="text" placeholder="Enter address" name="address" id="address" required>

<label for="comment"><b>Comment</b></label>
<input type="comment" placeholder="Enter comment" name="comment" id="comment" required>

<hr>

<p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
<button type="submit" class="registerbtn">Create order</button>
</div>

<div class="container signin">
    <p>Already have an account? <a href="#">Sign in</a>.</p>
</div>
</form>

<style>
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
    <style>

