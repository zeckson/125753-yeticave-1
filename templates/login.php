<?php
require_once 'src/form_utils.php';
require_once 'src/links.php';
?>
<form class="form container <?= mark_if_true(!empty($errors), 'form--invalid') ?>" action="<?= get_login_page_link() ?>"
      enctype="application/x-www-form-urlencoded" method="post">
    <h2>Вход</h2>
    <div class="form__item <?= mark($errors['email']) ?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" value="<?= write_value($user['email']) ?>" name="email"
               placeholder="Введите e-mail" required>
        <span class="form__error"><?= $errors['email'] ?></span>
    </div>
    <div class="form__item form__item--last <?= mark($errors['password']) ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" placeholder="Введите пароль" required>
        <span class="form__error"><?= $errors['password'] ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>
  