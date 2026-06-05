<div class="container">
    <a href="edit-profile">My profile</a>
    <a href="/user-orders">Мои заказы</a>
    <h3>Моя корзина</h3>

    <?php if (empty($userProducts)): ?>
        <div class="empty-cart-message" id="js-empty-cart">
            <p style="color: #ee962b">Корзина пуста.</p>
            <a href="/catalog" class="btn">Перейти к покупкам</a>
        </div>
    <?php else: ?>

    <div class="cart-total">
        Итого: <strong><span id="js-cart-total"><?php echo $cartTotal; ?></span> руб.</strong>
    </div>

    <div class="card-deck" id="js-cart-products">
        <?php foreach ($userProducts as &$userProduct) : ?>
        <div class="card text-center" id="js-product-card-<?php echo $userProduct->getProduct()->getId(); ?>">
            <img class="card-img-top"
                 src="<?php echo $userProduct->getProduct()->getImageUrl(); ?>"
                 alt="Card image" height="480" width="480">
            <div class="card-body">
                <p class="card-text text-muted"><?php echo $userProduct->getProduct()->getName(); ?></p>
                <h5 class="card-title"><?php echo $userProduct->getProduct()->getDescription(); ?></h5>
                <div class="card-footer">
                    Стоимость <?php echo $userProduct->getProduct()->getPrice(); ?> рублей
                </div>
                <div class="product-qty">
                    Количество: <span class="js-amount"><?php echo $userProduct->getAmount(); ?></span>
                </div>
                <div class="product-sum">
                    Сумма: <span class="js-product-total"><?php echo $userProduct->getTotalSum(); ?></span> руб.
                </div>
                <div class="cart-controls">
                    <input type="number"
                           class="js-qty-input"
                           value="1"
                           min="1"
                           style="width:50px; text-align:center;">
                    <button class="registerbtn js-btn-plus"
                            data-product-id="<?php echo $userProduct->getProduct()->getId(); ?>"
                            data-price="<?php echo $userProduct->getProduct()->getPrice(); ?>">+</button>
                    <button class="registerbtn js-btn-minus"
                            data-product-id="<?php echo $userProduct->getProduct()->getId(); ?>"
                            data-price="<?php echo $userProduct->getProduct()->getPrice(); ?>">-</button>
                </div>
            </div>
        </div>
      <?php endforeach; ?>
    </div>

    <a href="/create-order" id="js-order-link">Оформить заказ</a>

   <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {

        function updateProductCard(productId, price, newAmount, cartTotal) {
            var $card = $('#js-product-card-' + productId);

            if (newAmount <= 0) {
                $card.remove();

                if ($('#js-cart-products .card').length === 0) {
                    $('#js-cart-products').html(
                        '<div class="empty-cart-message">' +
                        '<p style="color: #ee962b">Корзина пуста.</p>' +
                        '<a href="/catalog" class="btn">Перейти к покупкам</a>' +
                        '</div>'
                    );
                    $('.cart-total').hide();
                    $('#js-order-link').hide();
                }
            } else {
                $card.find('.js-amount').text(newAmount);
                $card.find('.js-product-total').text(newAmount * price);
            }

            $('#js-cart-total').text(cartTotal);
        }

        $(document).on('click', '.js-btn-plus', function () {
            var $btn = $(this);
            var productId = $btn.data('product-id');
            var price = parseInt($btn.data('price'));
            var amount = parseInt($btn.closest('.cart-controls').find('.js-qty-input').val()) || 1;

            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/add-product',
                data: {product_id: productId, amount: amount},
                success: function (response) {
                    if (response.success) {
                        updateProductCard(productId, price, response.newAmount, response.cartTotal);
                    }
                },
                error: function () {
                    alert('Ошибка при обновлении корзины');
                },
                complete: function () {
                    $btn.prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.js-btn-minus', function () {
            var $btn = $(this);
            var productId = $btn.data('product-id');
            var price = parseInt($btn.data('price'));
            var amount = parseInt($btn.closest('.cart-controls').find('.js-qty-input').val()) || 1;

            $btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '/decrease-product',
                data: {product_id: productId, amount: amount},
                success: function (response) {
                    if (response.success) {
                        updateProductCard(productId, price, response.newAmount, response.cartTotal);
                    }
                },
                error: function () {
                    alert('Ошибка при обновлении корзины');
                },
                complete: function () {
                    $btn.prop('disabled', false);
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

    .card-footer {
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }

    .text-muted {
        font-size: 11px;
    }

    .cart-total {
        margin: 16px 0;
        font-size: 20px;
    }

    .product-qty,
    .product-sum {
        margin: 6px 0;
    }

    .cart-controls {
        margin: 10px 0;
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
    }
</style>
