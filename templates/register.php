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
<form class="form container" action="https://echo.htmlacademy.ru" method="post"> <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" required>
        <span class="form__error">Введите e-mail</span>
    </div>
    <div class="form__item">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" placeholder="Введите пароль" required>
        <span class="form__error">Введите пароль</span>
    </div>
    <div class="form__item">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name" placeholder="Введите имя" required>
        <span class="form__error">Введите имя</span>
    </div>
    <div class="form__item">
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
    </div>
    <div class="form__item form__item--file form__item--last">
        <label>Аватар</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
  