import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """

CREATE TABLE item_type (
    item_id int(11) NOT NULL,
    type_id int(11) NOT NULL,
    KEY item_id_fkey_idx (`item_id`),
    KEY type_id_fkey_idx (`type_id`),
    CONSTRAINT item_id_fkey FOREIGN KEY (`item_id`) REFERENCES item (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT type_id_fkey FOREIGN KEY (`type_id`) REFERENCES type (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()