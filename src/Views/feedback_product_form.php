
<div class="card text-center">
    <img class="card-img-top" src="<?php echo $product->getImageUrl()?>" alt="Card image" width="600" height="600">
    <div class="card-body">
        <p class="card-text text-muted"><?php echo $product->getName()?></p>
        <h5 class="card-title"><?php echo $product->getDescription()?></h5>
        <div class="card-footer"><?php echo $product->getPrice()?></div>

        <!-- Форма для перехода к отзыву -->
        <!--<form action="/handleFeedbackProduct" method="post"> -->
            <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
           <button type="submit" class="btn btn-primary">Оставить отзыв</button>
        <!--</form> -->
    </div>
</div>
<div class="feedback-container">
    <h2>Оставить отзыв о товаре: <?= $product->getName() ?></h2>

    <!-- Вывод средней оценки -->
    <?php if ($averageRating): ?>
        <div class="rating-summary">
            <strong>Средняя оценка:</strong> <?= number_format((float)$averageRating, 1, '.', '') ?> / 5
        </div>
    <?php endif; ?>

    <form action="/feedback-product" method="POST">
        <input type="hidden" name="product_id" value="<?= $product->getId() ?>">

        <div class="form-group">
            <label for="name">Ваше имя:</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="review">Ваш отзыв:</label>
            <textarea name="review" id="review" required></textarea>
        </div>

        <div class="form-group">
            <label for="estimation">Оценка:</label>
            <select name="estimation" id="estimation" required>
                <option value="5">5 — Отлично</option>
                <option value="4">4 — Хорошо</option>
                <option value="3">3 — Удовлетворительно</option>
                <option value="2">2 — Плохо</option>
                <option value="1">1 — Ужасно</option>
            </select>
        </div>
        <button type="submit">Отправить отзыв</button>
    </form>

    <hr>

    <h3>Отзывы покупателей</h3>
    <div class="feedbacks-list">
        <?php if (!empty($feedbacks)): ?>
            <?php foreach ($feedbacks as $item): ?>
                <div class="feedback-item" style="border-bottom: 1px solid #ccc; margin-bottom: 15px;">
                    <p>
                        <strong>Автор:</strong> <?= htmlspecialchars($item['name']) ?> |
                        <strong>Оценка:</strong> <?= $item['estimation'] ?>/5 |
                        <small><?= date('d.m.Y H:i', strtotime($item['created_at'])) ?></small>
                    </p>
                    <p><?= nl2br(htmlspecialchars($item['review'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Отзывов пока нет. Будьте первым!</p>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Контейнер */
    .feedback-container {
        max-width: 600px;
        margin: 20px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
        line-height: 1.6;
    }

    /* Заголовки */
    .feedback-container h2 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    /* Средняя оценка */
    .rating-summary {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        border-left: 4px solid #f1c40f;
        font-size: 1.1rem;
    }

    /* Группы полей формы */
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
    }

    /* Инпуты, текстовое поле и селект */
    .feedback-container input[type="text"],
    .feedback-container textarea,
    .feedback-container select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box; /* Чтобы padding не раздувал ширину */
        font-size: 1rem;
    }

    .feedback-container textarea {
        height: 120px;
        resize: vertical;
    }

    .feedback-container input:focus,
    .feedback-container textarea:focus,
    .feedback-container select:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
    }

    /* Кнопка */
    .feedback-container button[type="submit"] {
        background-color: #27ae60;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .feedback-container button[type="submit"]:hover {
        background-color: #219150;
    }

    /* Список отзывов */
    .feedbacks-list {
        margin-top: 30px;
    }

    .feedback-item {
        padding: 15px 0;
        border-bottom: 1px solid #eee !important; /* перебиваем инлайн стиль если нужно */
    }

    .feedback-item p {
        margin: 5px 0;
    }

    .feedback-item strong {
        color: #2c3e50;
    }

    .feedback-item small {
        color: #95a5a6;
        margin-left: 10px;
    }

    /* Сообщение об отсутствии отзывов */
    .feedbacks-list p {
        font-style: italic;
        color: #7f8c8d;
    }
</style>