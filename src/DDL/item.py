import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """

CREATE TABLE item (
    item_id int(11) NOT NULL AUTO_INCREMENT,
    item_name varchar(256) NOT NULL,
    price int(11) NOT NULL COMMENT 'price >=  0',
    amount int(11) NOT NULL COMMENT 'amount >=  0',
    introduce varchar(512) DEFAULT NULL,
    PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()
