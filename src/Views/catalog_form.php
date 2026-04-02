<div class="container">
    <a href="/profile">My profile</a>
    <a href="/cart">Перейти в корзину</a>
    <h2>Каталог</h2>
    <div class="card-deck">
        <?php foreach ($products as $product) : ?>
            <div class="card text-center">
                <a href="#">
                    <img class="card-img-top" src="<?php echo $product->getImageUrl()?>" alt="Card image" height="480" width="480">
                    <div class="card-body">
                        <p class="card-text text-muted"><?php echo $product->getName()?></p>
                        <a href="#"><h5 class="card-title"><?php echo $product->getDescription()?></h5></a>
                        <div class="card-footer">
                            <?php echo $product->getPrice()?>
                        </div>
                    </div>
                </a>
            </div>
        <form method="post" action="/add-product" class="js-cart-form">
            <div class="container">
                <input type="hidden" name="product_id" value="<?php echo $product->getId()?>" required>

                <label for="amount"><b>Корзина</b></label>
                <?php if (isset($errors['amount'])): ?>
                    <span style="color: red"><?php echo $errors['amount']; ?></span>
                <?php endif; ?>

                <input type="text" name="amount" id="amount" value="1" required>

                <button type="submit" class="registerbtn">+</button>

                <button type="submit" class="registerbtn" formaction="/decrease-product">-</button>
            </div>
        </form>

            <form method="post" action="/feedback-product">
                <div class="container">
                    <input type="hidden" name="product_id" value="<?php echo $product->getId()?>" required>
                    <button type="submit" class="registerbtn">Оставить отзыв</button>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Вешаем событие на форму
        $('.js-cart-form').on('submit', function(e) {
            e.preventDefault();

            var $form = $(this);

            var targetUrl = $(e.originalEvent.submitter).attr('formaction') || $form.attr('action');

            $.ajax({
                type: "POST",
                url: targetUrl,
                data: $form.serialize(),
                dataType: 'json',
                success: function (response) {
                    console.log('Успешно выполнено для:', targetUrl);
                    // Здесь обновляйте количество в корзине, если сервер прислал его
                    // $('.badge').text(response.count);
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при запросе:', error);
                }
            });
        });
    });

</script>


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