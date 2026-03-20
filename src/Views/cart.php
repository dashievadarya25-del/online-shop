<div class="container">
    <a href="edit-profile">My profile</a>
    <a href="/user-orders">Мои заказы</a>
    <h3>Моя корзина</h3>
    <div class="card-deck">
        <?php if (empty($userProducts)): ?>
            <!-- Сообщение, если корзина пуста -->
            <div class="empty-cart-message">
                <p style="color: #ee962b">Корзина пуста.</p>
                <a href="/catalog" class="btn">Перейти к покупкам</a>
            </div>
        <?php else: ?>
        <!-- Список товаров, если они есть -->
        <?php foreach ($userProducts as &$userProduct) : ?>
        <div class="card text-center">
            <a href="#">
                <img class="card-img-top" src="<?php echo $userProduct->getProduct()->getImageUrl();?>" alt="Card image" height="480" width="480">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $userProduct->getProduct()->getName();?></p>
                    <a href="#"><h5 class="card-title"><?php echo $userProduct->getProduct()->getDescription();?></h5></a>
                    <div class="card-footer">
                       Стоимость <?php echo $userProduct->getProduct()->getPrice();?> рублей
                    </div>
                    <div>
                        Общее количество: <?php echo $userProduct->getAmount();?>
                    </div>
                </div>
            </a>
        </div>
        <form method="post" action="/add-product"> <!-- По умолчанию идет на добавление -->
            <div class="container">
                <!-- ID продукта (один на обе кнопки) -->
                <input type="hidden" name="product_id" value="<?php echo $userProduct->getProduct()->getId()?>" required>

                <label for="amount"><b>количество</b></label>
                <?php if (isset($errors['amount'])): ?>
                    <span style="color: red"><?php echo $errors['amount']; ?></span>
                <?php endif; ?>

                <!-- Поле ввода количества -->
                <input type="text" name="amount" id="amount" value="1" required>

                <!-- Кнопка ПЛЮС (использует action формы по умолчанию) -->
                <button type="submit" class="registerbtn">+</button>

                <!-- Кнопка МИНУС (переопределяет action на другой путь) -->
                <button type="submit" class="registerbtn" formaction="/decrease-product">-</button>
            </div>
    <?php endforeach; ?>

<?php endif; ?>
<a href="/create-order">Оформить заказ</a>
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
