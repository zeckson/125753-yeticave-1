<?php if ($current_user): ?>
    <div class="user-menu__image">
        <img src="<?=$current_user['avatar_url'];?>" width="40" height="40" alt="Пользователь">
    </div>
    <div class="user-menu__logged">
        <p><?= $current_user['name'] ?></p>
    </div>
<?php else: ?>
    <ul class="user-menu__list">
        <li class="user-menu__item">
            <a href="register.php">Регистрация</a>
        </li>
        <li class="user-menu__item">
            <a href="login.php">Вход</a>
        </li>
    </ul>
<?php endif; ?>