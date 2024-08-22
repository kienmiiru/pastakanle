CREATE TABLE users (
    user_id int NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_banned boolean DEFAULT false,
    PRIMARY KEY (user_id)
);

CREATE TABLE pastes (
    paste_id int NOT NULL AUTO_INCREMENT,
    paste_code varchar(5),
    title varchar(255) NOT NULL,
    content text NOT NULL,
    user_id int NULL,
    date_created timestamp DEFAULT CURRENT_TIMESTAMP,
    last_edited timestamp NULL,
    expires_at timestamp NULL,
    deleted_at timestamp NULL,
    visibility int DEFAULT 0,
    PRIMARY KEY (paste_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
