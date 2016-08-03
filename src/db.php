CREATE TABLE Item (
        id INT AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        description TEXT NOT NULL,
        stored SMALLINT NOT NULL,
        PRIMARY KEY (id)
        );

CREATE TABLE User (
        id INT AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        surname VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
        );

CREATE TABLE Admin (
        id INT AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
        );

CREATE TABLE Messages (
        id INT AUTO_INCREMENT,
        text TEXT NOT NULL,
        user_id INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY(id) REFERENCES Admin(id),
        FOREIGN KEY(user_id) REFERENCES User(id)
        );

CREATE TABLE `Order` (
        id INT AUTO_INCREMENT,
        status INT NOT NULL,
        user_id INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY(user_id) REFERENCES User(id),
        FOREIGN KEY(status) REFERENCES Status(id)
        );

CREATE TABLE Product_Order (
        item_id INT NOT NULL,
        order_id INT NOT NULL,
        quant INT(100),
        FOREIGN KEY (item_id) REFERENCES Item(id),
        FOREIGN KEY (order_id) REFERENCES `Order`(id)
        );

CREATE TABLE Status (
        id INT AUTO_INCREMENT,
        status_name VARCHAR(30),
        PRIMARY KEY(id)
        );
        
CREATE TABLE Pictures (
        id INT AUTO_INCREMENT,
        item_id INT NOT NULL,
        file_path TEXT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (item_id) REFERENCES Item(id)
);