import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """

CREATE TABLE item_order (
    specification_id int(11) DEFAULT NULL,
    group_name varchar(256) DEFAULT NULL,
    amount int(11) NOT NULL,
    order_id int(11) NOT NULL,
    KEY specification_id_idx (`specification_id`),
    KEY order_id_idx (`order_id`),
    KEY group_name_fkey_idx (`group_name`),
    CONSTRAINT order_id FOREIGN KEY (`order_id`) REFERENCES order (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT specification_id FOREIGN KEY (`specification_id`) REFERENCES specification (`specification_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()