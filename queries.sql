/*INSERT INTO categories SET id = 1, character_code = 'boards', name_category	= 'Доски и лыжи';
INSERT INTO categories SET id = 2, character_code = 'attachment', name_category	= 'Крепления';
INSERT INTO categories SET id = 3, character_code = 'boots', name_category	= 'Ботинки';
INSERT INTO categories SET id = 4, character_code = 'clothing', name_category	= 'Одежда';
INSERT INTO categories SET id = 5, character_code = 'other', name_category	= 'Другое';

INSERT INTO users SET id = 1, email = 'goommax@mail.ru', user_name	= 'Maxim', user_password = '11111', contacts = '+79882552774';
INSERT INTO users SET id = 2, email = 'fedusha_cat@mail.ru', user_name	= 'Fedusha the cat', user_password = '2222222', contacts = '+79882552774';

INSERT INTO lots SET id = 1, title = '2014 Rossignol District Snowboard', lot_description	= 'Супер-доска - только для настоящих мужчин',
img = 'img/lot-1.jpg', start_price = 10999, step = 1000, date_finish = '2021-08-10', user_id = 1, winner_id = 2, category_id = 1;
INSERT INTO lots SET id = 2, title = 'DC Ply Mens 2016/2017 Snowboard', lot_description	= 'Супер-доска для крутых покатушек', img = 'img/lot-2.jpg',
 start_price = 159999, step = 10000, date_finish = '2021-08-10', user_id = 1, winner_id = 2, category_id = 1;
INSERT INTO lots SET id = 3, title = 'Крепления Union Contact Pro 2015 года размер L/XL', lot_description	= 'Прочные и удобные крепления для горных лыж', img = 'img/lot-3.jpg',
 start_price = 8000, step = 500, date_finish = '2021-08-10', user_id = 1, winner_id = 2, category_id = 2;
INSERT INTO lots SET id = 4, title = 'Ботинки для сноуборда DC Mutiny Charocal', lot_description	= 'Черные, стильные, удобные тапки для горных лыж', img = 'img/lot-4.jpg',
 start_price = 10999, step = 1000, date_finish = '2021-08-10', user_id = 1, winner_id = 2, category_id = 3;
INSERT INTO lots SET id = 5, title = 'Куртка для сноуборда DC Mutiny Charocal', lot_description	= 'Стильная, теплая, удобная куртка', img = 'img/lot-5.jpg',
 start_price = 7500, step = 500, date_finish = '2021-08-12', user_id = 2, winner_id = 1, category_id = 4;
INSERT INTO lots SET id = 6, title = 'Маска Oakley Canopy', lot_description	= 'В этой маске вы будете выглядеть как крутой ниндзя', img = 'img/lot-6.jpg',
 start_price = 5400, step = 500, date_finish = '2021-08-13', user_id = 2, winner_id = 1, category_id = 5;

INSERT INTO bets SET price_bet = 11999, user_id = 2, lot_id = 1;
INSERT INTO bets SET price_bet = 9000, user_id = 2, lot_id = 3;*/
/*Получаем список всех категорий*/

USE yeticavedb;
SELECT name_category AS 'Категории' FROM categories;
/*получить самые новые, открытые лоты.
Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории*/
SELECT lots.id, lots.date_creation, lots.title, lots.start_price, lots.img, categories.name_category FROM lots JOIN categories ON
lots.category_id = categories.id;
/*показать лот по его ID. Получите также название категории, к которой принадлежит лот;*/
SELECT lots.id, lots.title, lots.start_price, lots.img, categories.name_category FROM lots JOIN categories ON
lots.category_id = categories.id WHERE lots.id = 3;
/*обновить название лота по его идентификатору*/
UPDATE lots SET title = 'Доска DC Ply Mens 2016/2017' WHERE id = 2;
/*получить список ставок для лота по его идентификатору с сортировкой по дате.*/
SELECT bets.id, bets.user_id, users.user_name, bets.date_bet, bets.price_bet, lots.id, lots.title, lots.start_price FROM bets
JOIN users ON bets.user_id = users.id
JOIN lots ON bets.lot_id = lots.id
WHERE bets.lot_id = 3
ORDER BY bets.date_bet ASC;
