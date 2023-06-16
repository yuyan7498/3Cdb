import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """
CREATE TABLE cart (
    id int(11) NOT NULL,
    specification_id int(11) DEFAULT NULL,
    group_name varchar(256) DEFAULT NULL,
    amount int(11) NOT NULL DEFAULT 1,
    cost int(11) NOT NULL DEFAULT 0,
    KEY id_idx (`id`),
    CONSTRAINT id FOREIGN KEY (`id`) REFERENCES user (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()
