-- show databases;
use test;

drop table if exists accounts;

create table if not exists accounts
(
id int(5) auto_increment primary key,
active char(5) default 'yes',
role char(20) not null,
username varchar(20) not null unique,
pass char(100) not null,
forname char(20) not null,
surname char(20) not null,
email varchar(50) not null,
created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('admin', 'magand', '$2y$10$Gh3Im3MDUkXx8CAgR6TEZOR9J9hR08G8UMrI25qMvRV1iXNvslK0i', 'Magnus', 'Andersson', 'magnusandersson076@gmail.com'); -- pass
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'Kronan', '$2y$10$n8BQHjTCe.ltgViBMW5q0en2g3V8dupJmlWMJcgXn6MLteOJhAKgq', 'Daniel', 'Kronqvist', 'daniel.kronqvist@gmail.com'); -- kronan
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'bredsjoanna', '$2y$10$fi5RSMbrH5rCEqLkurf1SOI26U0AG2jgqhZn4nbYPfBO2t1V95ej.', 'Anna', 'Eriksson', 'bredsjoanna@gmail.com'); -- fisk
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'mand75', '$2y$10$FZADp/m5yJjXOZVTf/0lFeqi3OAQR/jBxjc1T99z2gOmD8xXKzUTm', 'Maria', 'Nord', 'mand75@hotmail.com'); -- mand
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'mromarboss', '$2y$10$UH8JF1OxvCJ5XmujzMUImewlvWRz2SZcPW861WNScdgILPBj7iYQS', 'Omar', 'Nuur', 'mrnomar_boss@gmail.com'); -- boss
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'tintin', '$2y$10$XgskhnGsTLIczYn4h2djMO1/twDaMXwCTJZFxO9amYykuNeBzGz2C', 'Martin', 'Karlsson', 'jktintin_88@hotmail.com'); -- tintin
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'kr_68', '$2y$10$zL07u41axnE.ei59x7Hrx.LP9hkl2qgUd44CfQEdsZZY0PtJBJMsq', 'Kristina', 'Ratcher', 'ratcher68@hotmail.com'); -- kristina
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'mrsmiss', '$2y$10$fHsLBWbf6kdLs6tRKGfTF.octwVFB.40RHncXCS4LiqTUTDjftGx6', 'Liv', 'Alared', 'lalred83@gmail.com'); -- liv
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'helle', '$2y$10$/QqVJ2693qwjgMhXXMpEOOcykBn80OuBaNnZ4X7s5L1f7oD5/uCW.', 'Helen', 'Henriksson', 'helhaik65@yahoo.se'); -- helle
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'klara', '$2y$10$tTFc1b/FT8QOyMVIpcbZreOtKdiTc2/PGpZkmogGEA6fEZVDWm0Vm', 'Klara', 'Ericsson', 'bredsjoklara@gmail.com'); -- klara
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('admin', 'admin', '$2y$10$Ml94egY/SRVxswtwPlUXbeeoe.t8krAXcb7t0r6U74uXOMtooirBu', 'admin', 'admin', 'admin@admin.se'); -- admin
INSERT INTO accounts (role, username, pass, forname, surname, email) VALUES ('user', 'doe', '$2y$10$GRrdHbpyhiVVdVCRfTh4E.Og72bo8VPj/Fh4HAeapEiSSl10WoS.C', 'doe', 'doe', 'doe@doe.se'); -- doe


select * from accounts;

-- SELECT * FROM accounts where username LIKE 'magand' order by id asc limit 3;

-- select * from accounts where binary username = binary'Magand';

-- show tables;
