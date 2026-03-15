<div class="container">
    <a href="edit-profile">My profile</a>
    <a href="/user-orders">Мои заказы</a>
    <h3>Моя корзина</h3>
    <div class="card-deck">
        <?php if (empty($products)): ?>
            <!-- Сообщение, если корзина пуста -->
            <div class="empty-cart-message">
                <p style="color: #ee962b">Корзина пуста.</p>
                <a href="/catalog" class="btn">Перейти к покупкам</a>
            </div>
        <?php else: ?>
        <!-- Список товаров, если они есть -->
        <?php foreach ($products as $product) : ?>
        <div class="card text-center">
            <a href="#">
                <img class="card-img-top" src="<?php echo $product->getImageUrl();?>" alt="Card image" height="480" width="480">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $product->getName();?></p>
                    <a href="#"><h5 class="card-title"><?php echo $product->getDescription();?></h5></a>
                    <div class="card-footer">
                        <?php echo $product->getPrice();?>
                    </div>
                    <div>
                        Количество: <?php echo $product->getAmount();?>
                    </div>
                </div>
            </a>
        </div>
        <form action="/add-product" method="post">
            <div class="container">
                <input type="hidden" placeholder="Enter product-id" name="product_id" value="<?php echo $product->getId(); ?>" id="product_id" required>

                <label for="amount"><b>Amount</b></label>
                <?php if (isset($errors['amount'])): ?>
                <label style="color: red"><?php echo $errors['amount']; ?></form>
    <?php endif; ?>

        <input type="text" placeholder="Enter amount" name="amount" id="amount" required>


        <button type="submit" class="registerbtn">Add product</button>
    </div>
    </form>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<a href="/create-order">Оформление заказа</a>
</div>

<style>
    body {
        font-style: sans-serif;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 13px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 11px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>
