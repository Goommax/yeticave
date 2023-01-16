
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>

        <ul class="promo__list">
        <?php foreach ($categories as $key_cat): ?>
            <li class="promo__item promo__item--<?= $key_cat ['character_code']; ?>">
                <a class="promo__link" href="pages/all-lots.html"><?= $key_cat ['name_category']; ?></a>
            </li>
        <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
          <?php foreach ($inform as $key_info): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=htmlspecialchars($key_info ['img']);?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $key_info ['name_category']; ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $key_info['id']; ?>"><?= htmlspecialchars($key_info ['title']); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">1</span>
                            <span class="lot__cost"><?= form_price($key_info ['start_price']); ?></span>
                        </div>
                        <?php $time_res = time_left($key_info ['date_finish']); ?>
                        <div class="lot__timer timer <?php if ($time_res[0] < 1): ?> timer--finishing <?php endif; ?>">
                            <?= "$time_res[0] : $time_res[1]"; ?>
                        </div>
                    </div>
                </div>
            </li>
      <?php endforeach; ?>
        </ul>
    </section>
