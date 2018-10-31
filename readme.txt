To duplicate this function, just copy and paste it to another folder:
then:
1.Create a new users DB for new app users.
2.Change your DB to connect to the one fit with your app.

SQL for creating new tables:

CREATE TABLE IF NOT EXISTS `Bible_reading` (
`id` int(8) NOT NULL AUTO_INCREMENT,
`topic` varchar(255) NOT NULL,
`code` varchar(255),
`text` text,
`mark1` text,
`mark2` text,
PRIMARY KEY (`id`)
) ;


CREATE TABLE users ( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
 username VARCHAR(50) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL, 
created_at DATETIME DEFAULT CURRENT_TIMESTAMP );

reference:
https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
https://phppot.com/php/php-crud-with-search-and-pagination/
https://phppot.com/?s=crud+search
