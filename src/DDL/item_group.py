import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """

CREATE TABLE item_group (
    group_name varchar(256) NOT NULL,
    specification_id int(11) NOT NULL,
    group_price int(11) DEFAULT NULL,
    group_amount int(11) NOT NULL,
    KEY specification_id_fkey_idx (`specification_id`),
    CONSTRAINT specification_id_fkey FOREIGN KEY (`specification_id`) REFERENCES specification (`specification_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()
