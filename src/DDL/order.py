import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """


CREATE TABLE order (
    order_id int(11) NOT NULL AUTO_INCREMENT,
    sum int(11) NOT NULL,
    paying_id int(11) NOT NULL,
    paying_status_id int(11) NOT NULL,
    paying_date datetime DEFAULT NULL,
    order_status_id int(11) NOT NULL,
    PRIMARY KEY (`order_id`),
    KEY paying_id_fkey_idx (`paying_id`),
    KEY paying_status_id_fkey_idx (`paying_status_id`),
    KEY order_status_id_fkey_idx (`order_status_id`),
    CONSTRAINT order_status_id_fkey FOREIGN KEY (`order_status_id`) REFERENCES order_status (`order_status_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    CONSTRAINT paying_id_fkey FOREIGN KEY (`paying_id`) REFERENCES paying_type (`paying_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    CONSTRAINT paying_status_id_fkey FOREIGN KEY (`paying_status_id`) REFERENCES paying_status (`paying_status_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()