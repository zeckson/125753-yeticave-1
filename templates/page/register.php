<?php
/** @noinspection PhpIncludeInspection */
require_once 'src/form_utils.php';
require_once 'src/links.php';
?>
<form class="form container <?= mark_if_true(!empty($errors), 'form--invalid') ?>"
      enctype="multipart/form-data" action="<?= get_register_page_link() ?>" method="post">
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?= mark($errors['email']) ?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email"
               value="<?= write_value($user['email']) ?>" placeholder="Введите e-mail" required>
        <span class="form__error"><?= $errors['email'] ?></span>
    </div>
    <div class="form__item <?= mark($errors['password']) ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" required>
        <span class="form__error"><?= $errors['password'] ?></span>
    </div>
    <div class="form__item <?= mark($errors['name']) ?>">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name"
               value="<?= write_value($user['name']) ?>" placeholder="Введите имя" required>
        <span class="form__error"><?= $errors['name'] ?></span>
    </div>
    <div class="form__item <?= mark($errors['info']) ?>">
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="info"
                  placeholder="Напишите как с вами связаться" required><?= write_value($user['info']) ?></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
    </div>
    <div class="form__item form__item--file form__item--last <?= mark($errors['avatar_url']) ?>">
        <label>Аватар</label>
        <?php if (isset($user['avatar_url'])): ?>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="<?= $user['avatar_url'] ?>" width="113" height="113" alt="Ваш аватар">
                </div>
            </div>
        <?php else: ?>
            <div class="form__input-file">
                <input class="visually-hidden" name="avatar" type="file" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        <?php endif ?>
        <span class="form__error"><?= $errors['avatar_url'] ?></span>
    </div>
    <?php if (!empty($errors)): ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <?php endif; ?>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="<?= get_login_page_link() ?>">Уже есть аккаунт</a>
</form>
  