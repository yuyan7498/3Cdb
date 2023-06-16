import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """


CREATE TABLE stock (
    stock_id int(11) NOT NULL AUTO_INCREMENT,
    item_id int(11) NOT NULL,
    import_time datetime NOT NULL DEFAULT current_timestamp(),
    stock_amount int(11) NOT NULL,
    manufacturer_id int(11) NOT NULL,
    stock_address varchar(256) NOT NULL,
    PRIMARY KEY (`stock_id`),
    KEY item_id_idx (`item_id`),
    KEY manufacturer_id_idx (`manufacturer_id`),
    CONSTRAINT item_id FOREIGN KEY (`item_id`) REFERENCES item (`item_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    CONSTRAINT manufacturer_id FOREIGN KEY (`manufacturer_id`) REFERENCES manufacturer (`manufacturer_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()