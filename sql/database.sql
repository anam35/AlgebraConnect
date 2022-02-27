CREATE DATABASE IF NOT EXISTS algebracontacts;
USE algebracontacts; 

CREATE TABLE IF NOT EXISTS users
(
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(50) NOT NULL UNIQUE,
	hash VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO users 
    (id, username, hash) 
VALUES 
    (1,"lenpaprocki","sha256:1000:h3V4h7FshnqfHC8i6mfSjhVby9h45XAQ25ewXc3tjeU=:13xZ4ZSzKt7DwuxdSo3Yf9lIdo9PUZvrSLbWRBmnMkY="),
    (2,"roxcampain","sha256:1000:h3V4h7FshnqfHC8i6mfSjhVby9h45XAQ25ewXc3tjeU=:13xZ4ZSzKt7DwuxdSo3Yf9lIdo9PUZvrSLbWRBmnMkY=");


CREATE TABLE IF NOT EXISTS contacts
(
	id INT NOT NULL AUTO_INCREMENT,
	ownerId INT NOT NULL,
	name VARCHAR(255) NOT NULL,
	number VARCHAR(20) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (ownerId) REFERENCES users(id)
);

INSERT INTO contacts 
    (ownerId, name, number) 
VALUES 
    (1,"Leota Dilliard","408-752-3500"),
    (2,"Abel Maclead","631-335-3414"),
    (1,"Kiley Caldarera","310-498-5651"),
    (1,"Veronika Inouye","408-540-1785"),
    (2,"Maryann Royster","518-966-7987"),
    (2,"Willow Kusko","212-582-4976"),
    (2,"Alishia Sergi","212-860-1579"),
    (2,"Jose Stockham","212-675-8570"),
    (1,"Rozella Ostrosky","805-832-6163"),
    (1,"Kanisha Waycott","323-453-2780");