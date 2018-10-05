<?php
//       lot.id,
//       lot.name,
//       lot.description
//       start_price,
//       IFNULL(MAX(bid.amount), start_price) AS price,
//       image_url                            AS image,
//       category.id                          AS category,
//       count(bid.id)                        AS bids_count

function mark(&$var, $value = 'form__item--invalid')
{
    return mark_if_true(isset($var), $value);
}

function mark_if_true($condition, $value = 'form__item--invalid')
{
    return $condition ? $value : '';
}

?>
<?= $navigation ?>
<form class="form form--add-lot container <?= mark_if_true(!empty($errors), 'form--invalid') ?>" action="add.php"
      enctype="multipart/form-data" method="post">
    <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?= mark($errors['name']) ?>">
            <label for="lot-name">Наименование</label>
            <input id="lot-name" value="<?= htmlspecialchars($lot['name'] ?? '') ?>" type="text" name="name"
                   placeholder="Введите наименование лота" required>
            <span class="form__error">Введите наименование лота</span>
        </div>
        <div class="form__item <?= mark($errors['category']) ?>">
            <label for="category">Категория</label>
            <select id="category" name="category" required>
                <?php foreach ($categories as $category): ?>
                    <option <?= isset($lot['category']) ? ($category['id'] === $lot['category'] ?: 'selected') : '' ?>
                            value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <div class="form__item form__item--wide <?= mark($errors['description']) ?>">
        <label for="message">Описание</label>
        <textarea id="message" name="description" placeholder="Напишите описание лота"
                  required><?= htmlspecialchars($lot['description'] ?? '') ?></textarea>
        <span class="form__error">Напишите описание лота</span>
    </div>
    <div class="form__item form__item--file <?= mark($lot['image'], 'form__item--uploaded') ?> <?= mark($errors['image']) ?>">
        <label>Изображение</label>
        <?php if (isset($lot['image'])): ?>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="<?= $lot['image'] ?>" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
        <?php else: ?>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="image" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        <?php endif; ?>
        <span class="form__error">Укажите картинку</span>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?= mark($errors['start_price']) ?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="start_price" value="<?= intval($lot['start_price'] ?? '') ?>"
                   placeholder="0" required>
            <span class="form__error">Введите начальную цену</span>
        </div>
        <div class="form__item form__item--small <?= mark($errors['bid_step']) ?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="bid_step" value="<?= intval($lot['bid_step'] ?? '') ?>"
                   placeholder="0" required>
            <span class="form__error">Введите шаг ставки</span>
        </div>
        <div class="form__item" <?= mark($errors['closed_at']) ?>>
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="lot-date" type="date" name="closed_at"
                   value="<?= htmlspecialchars($lot['closed_at'] ?? '') ?>" required>
            <span class="form__error">Введите дату завершения торгов</span>
        </div>
    </div>
    <?php if (!empty($errors)): ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <?php endif; ?>
    <button type="submit" class="button">Добавить лот</button>
</form>
  