# clean all categories
DELETE
FROM categories;

# init all default categories
INSERT INTO categories (id, name)
VALUES (0, 'Доски и лыжи'),
       (1, 'Крепления'),
       (2, 'Ботинки'),
       (3, 'Одежда'),
       (4, 'Инструменты'),
       (5, 'Разное');

DELETE
FROM users;

# setup test users
INSERT INTO users (name, email, password)
VALUES ('Евгеша Бандит', 'evgesha@bandit.com', sha1(CONCAT(email, '12345'))),
       ('Витька Хромой', 'vitaly@bandit.com', sha1(CONCAT(email, 'secret')));

SET @evgesha = -1;
SET @vitka = -1;

SELECT id
FROM users
WHERE email = 'evgesha@bandit.com' INTO @evgesha;
SELECT id
FROM users
WHERE email = 'vitaly@bandit.com' INTO @vitka;

SELECT @evgesha, @vitka;

# create some lots
DELETE
FROM lots;

# open lots
INSERT INTO lots (name, category_id, start_price, image_url, author_id)
VALUES ('2014 Rossignol District Snowboard', 0, 10999, 'img/lot-1.jpg', @evgesha),
       ('DC Ply Mens 2016/2017 Snowboard', 0, 15999, 'img/lot-2.jpg', @vitka),
       ('Крепления Union Contact Pro 2015 года размер L/XL', 1, 8000, 'img/lot-3.jpg', @evgesha),
       ('Ботинки для сноуборда DC Mutiny Charocal', 2, 10999, 'img/lot-4.jpg', @vitka),
       ('Куртка для сноуборда DC Mutiny Charocal', 3, 7500, 'img/lot-5.jpg', @evgesha),
       ('Маска Oakley Canopy', 5, 5400, 'img/lot-§.jpg', @vitka);

# closed lots
INSERT INTO lots (name, category_id, start_price, bid_step, created_at, closed_at, image_url, author_id, winner_id)
VALUES ('Сноуборд BF snowboards Scoop (17-18)',
        0,
        6690,
        100,
        TIMESTAMPADD(WEEK, -1, NOW()),
        NOW(),
        'img/lot-1.jpg',
        @vitka,
        @evgesha),
       ('Куртка утепленная женская Exxtasy Martigny, размер 42',
        3,
        8999,
        200,
        TIMESTAMPADD(MONTH, -1, NOW()),
        TIMESTAMPADD(WEEK, -1, NOW()),
        'img/lot-5.jpg',
        @evgesha,
        @vitka),
       ('Запчасть для креплений NOW KGP TOOL LESS KIT NYLON S BLACK',
        4,
        2030,
        50,
        TIMESTAMPADD(MONTH, -2, NOW()),
        TIMESTAMPADD(MONTH, -1, NOW()),
        'https://www.kant.ru/upload/iblock/4df/4dfe47ce30dcf18550ba678ed54e5332.JPG',
        @evgesha,
        @vitka);

DELETE
FROM bids;

# create a few bids
INSERT INTO bids (lot_id, amount, owner_id)
SELECT id, 50000, @evgesha
FROM lots
ORDER BY RAND()
LIMIT 1;

INSERT INTO bids (lot_id, amount, owner_id)
SELECT id, 100000, @vitka
FROM lots
ORDER BY RAND()
LIMIT 1;

# get all categories
SELECT *
FROM categories;
# get all latest open lots. Select only name, start_price, image_url, price, number of bids, category name
SELECT lot.id,
       lot.name,
       start_price,
       IFNULL(MAX(bid.amount), start_price) AS price,
       image_url,
       category.name                        AS category_name,
       count(bid.id)                        AS bids_count
FROM lots lot
       LEFT JOIN categories category ON lot.category_id = category.id
       LEFT JOIN bids bid ON lot.id = bid.lot_id
WHERE lot.closed_at IS NULL
GROUP BY lot.id
ORDER BY lot.created_at DESC;
# get lot by id with category name
SET @lot_id = 6;
SELECT lot.id, lot.name, start_price, image_url, category.name AS category_name
FROM lots lot
       JOIN categories category ON lot.category_id = category.id
WHERE lot.id = @lot_id
ORDER BY lot.created_at DESC;
# update lot name by id
UPDATE lots
SET name = 'Маска Salice 605 Darwf'
WHERE id = @lot_id;
# get the latest bids by lot id
SELECT *
FROM bids
WHERE lot_id = @lot_id
ORDER BY created_at DESC;