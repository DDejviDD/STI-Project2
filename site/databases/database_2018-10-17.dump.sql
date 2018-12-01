----
-- phpLiteAdmin database dump (https://bitbucket.org/phpliteadmin/public)
-- phpLiteAdmin version: 1.9.6
-- Exported: 11:17pm on October 17, 2018 (UTC)
-- database file: /usr/share/nginx/databases/database.sqlite
----
BEGIN TRANSACTION;

----
-- Table structure for messageSent
----
CREATE TABLE messageSent (
                    sender TEXT, 
                    receiver TEXT,
                    idMessage INTEGER,
                    FOREIGN KEY (sender) REFERENCES users(login) ON DELETE CASCADE,
                    FOREIGN KEY (receiver) REFERENCES users(login) ON DELETE CASCADE,
                    FOREIGN KEY (idMessage) REFERENCES message(time) ON DELETE CASCADE);

----
-- Table structure for users
----
CREATE TABLE 'users' (
                    login TEXT PRIMARY KEY, 
                    password TEXT, 
                    valid INTEGER,'role' INTEGER);

----
-- Data dump for users, a total of 2 rows
----
INSERT INTO "users" ("login","password","valid","role") VALUES ('admin','d033e22ae348aeb5660fc2140aec35850c4da997','1','0');
INSERT INTO "users" ("login","password","valid","role") VALUES ('user','12dea96fec20593566ab75692c9949596833adc9','1','1');

----
-- Table structure for messages
----
CREATE TABLE messages (
                    id INTEGER PRIMARY KEY, 
                    title TEXT, 
                    message TEXT, 
                    time TEXT);

;
COMMIT;
