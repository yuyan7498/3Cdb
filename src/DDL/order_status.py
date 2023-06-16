import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """


CREATE TABLE order_status (
    order_status_id int(11) NOT NULL AUTO_INCREMENT,
    order_status_name varchar(256) NOT NULL,
    PRIMARY KEY (`order_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()