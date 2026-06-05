<div class="container">
    <a href="/profile">My profile</a>
    <a href="/cart">Корзина: <span id="js-cart-total"><?php echo $cartTotal; ?></span> руб.</a>
    <h2>Каталог</h2>
    <div class="card-deck">
        <?php foreach ($products as $product) : ?>
            <div class="card text-center">
                <img class="card-img-top" src="<?php echo $product->getImageUrl()?>" alt="Card image" height="480" width="480">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $product->getName()?></p>
                    <h5 class="card-title"><?php echo $product->getDescription()?></h5>
                    <div class="card-footer">
                        <?php echo $product->getPrice()?>
                    </div>
                </div>
            </div>
            <form method="post" action="/add-product" class="js-cart-form">
                <div class="container">
                    <input type="hidden" name="product_id" value="<?php echo $product->getId()?>" required>

                    <label for="amount-<?php echo $product->getId()?>"><b>Корзина</b></label>
                    <?php if (isset($errors['amount'])): ?>
                        <span style="color: red"><?php echo $errors['amount']; ?></span>
                    <?php endif; ?>

                    <input type="number" name="amount" id="amount-<?php echo $product->getId()?>" value="1" min="1" required>

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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
        $('.js-cart-form').on('submit', function (e) {
            e.preventDefault();

            var $form = $(this);
            var $submitter = $(e.originalEvent.submitter);
            var targetUrl = $submitter.attr('formaction') || $form.attr('action');

            $.ajax({
                type: 'POST',
                url: targetUrl,
                data: $form.serialize(),
                success: function (response) {
                    if (response.success) {
                        $('#js-cart-total').text(response.cartTotal);

                        var $btn = $submitter;
                        var origText = $btn.text();
                        $btn.text('✓').prop('disabled', true);
                        setTimeout(function () {
                            $btn.text(origText).prop('disabled', false);
                        }, 800);
                    }
                },
                error: function() {
                    console.error('Ошибка при обновлении корзины');
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

    .card-footer {
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>