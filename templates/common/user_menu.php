<?php
require_once 'src/links.php';

/**
 * @var array $current_user
 */
?>
<?php
if ($current_user): ?>
    <div class="user-menu__image">
        <img src="<?= $current_user['avatar_url']; ?>" width="40" height="40" alt="Пользователь">
    </div>
    <div class="user-menu__logged">
        <p><?= $current_user['name'] ?></p>
        <a href="<?= get_logout_page_link() ?>">Выйти</a>
    </div>
<?php else: ?>
    <ul class="user-menu__list">
        <li class="user-menu__item">
            <a href="<?= get_register_page_link() ?>">Регистрация</a>
        </li>
        <li class="user-menu__item">
            <a href="<?= get_login_page_link() ?>">Вход</a>
        </li>
    </ul>
<?php endif; ?>