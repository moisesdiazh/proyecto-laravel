CREATE DATABASE IF NOT EXISTS laravel_master;

USE laravel_master;

CREATE TABLE users(
id             int(255) AUTO_INCREMENT not null,
role           varchar(20),
name           varchar(100),
surname        varchar(200),
nick           varchar(100),
email          varchar(100),
password       varchar(255),
image          varchar(255),
created_at     datetime,
updated_at     datetime,
remember_token varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;


INSERT INTO users VALUES(NULL, 'user','Gabriel', 'Diaz', 'Gabo', 'gabo@gmail.com', 1234, null, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user','Juan', 'Hernandez', 'Juancho', 'juan@gmail.com', 12345, null, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user','Jonathan', 'Diaz Hernandez', 'Jon', 'jon@gmail.com', 123467, null, CURTIME(), CURTIME(), NULL);

CREATE TABLE IF NOT EXISTS images( 
id             int(255) AUTO_INCREMENT not null,
user_id        int(255),
image_path     varchar(255),
description    text,
created_at     datetime,
updated_at     datetime,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

INSERT INTO images VALUES(NULL, 1, 'test.jpg', 'descripcion1', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 3, 'test1.jpg', 'descripcion2', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 2, 'test2.jpg', 'descripcion3', CURTIME(), CURTIME());


CREATE TABLE comments(
id             int(255) AUTO_INCREMENT not null,
user_id        int(255),
image_id       int(255),
content        text,
created_at     datetime,
updated_at     datetime,
CONSTRAINT pk_comments PRIMARY KEY(id),
CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO comments VALUES(NULL, 3, 1, 'qlqlqlq', CURTIME(), CURTIME());
INSERT INTO comments VALUES(NULL, 2, 3, 'una loquera vle', CURTIME(), CURTIME());
INSERT INTO comments VALUES(NULL, 1, 2, 'que lacreo chamita', CURTIME(), CURTIME());


CREATE TABLE IF NOT EXISTS likes(
id             int(255) AUTO_INCREMENT not null,
user_id        int(255),
image_id       int(255),
created_at     datetime,
updated_at     datetime,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO likes VALUES(NULL, 3, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 2, 3, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 1, 2, CURTIME(), CURTIME());
