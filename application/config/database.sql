CREATE DATABASE signxt DEFAULT CHARACTER SET UTF8;

use wecanstudio

CREATE TABLE users(
  id INT PRIMARY KEY auto_increment,
  name VARCHAR(20) NOT NULL ,
  description VARCHAR(200),
  sex VARCHAR(10) NOT NULL ,
  group_name INT NOT NULL ,
  phone VARCHAR(20) NOT NULL ,
  imgurl VARCHAR(100),
  position INT DEFAULT 0,
  sign_date TIME ,
  status INT DEFAULT 0
);

CREATE TABLE sign(
  id INT PRIMARY KEY auto_increment,
  sign_date TIME ,
  user_id INT NOT NULL ,
  FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE book(
  id INT PRIMARY KEY auto_increment,
  bookname VARCHAR(100) NOT NULL ,
  user_id INT NOT NULL ,
  status INT DEFAULT 1,
  FOREIGN KEY(user_id) REFERENCES users(id)
);


CREATE TABLE keys_num(
  id INT PRIMARY KEY auto_increment,
  user_id INT NOT NULL ,
  status INT DEFAULT 0,
  FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE please(
  id INT PRIMARY KEY auto_increment,
  num VARCHAR(100) NOT NULL,
  status INT DEFAULT 1
);