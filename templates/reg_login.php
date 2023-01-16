<nav class="nav">
      <ul class="nav__list container">
      <?php foreach ($categories as $key_cat) : ?>
      <li class="nav__item">
        <a href="all-lots.html"><?= $key_cat["name_category"] ?></a>
      </li>
      <?php endforeach ?>
      </ul>
    </nav>
    <?php $classname = isset($errors) ? "form--invalid" : ""; ?>
    <form class="form container" action="login.php" method="post"> <!-- form--invalid -->
      <h2>Аккаунт успешно зарегистрирован! Заходите!</h2>
      <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
      <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
        <label for="email">Введите E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value = '<?= $user_login['email'] ?? ''; ?>'>
        <span class="form__error"><?= $errors['email'];?></span>
      </div>
      <?php $classname = isset($errors['password']) ? "form__item--invalid" : ""; ?>
      <div class="form__item <?= $classname; ?>">
        <label for="password">Введите пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value = '<?= $user_login['password'] ?? ''; ?>'>
        <span class="form__error"><?= $errors['password'];?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>