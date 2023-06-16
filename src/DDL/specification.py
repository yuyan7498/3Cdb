import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """


CREATE TABLE specification (
    specification_id int(11) NOT NULL AUTO_INCREMENT,
    specification_name varchar(256) NOT NULL,
    specification_price int(11) DEFAULT NULL,
    specification_amount int(11) NOT NULL,
    item_id int(11) NOT NULL,
    PRIMARY KEY (`specification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()