import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """


CREATE TABLE user_order (
   id int(11) NOT NULL,
   order_id int(11) NOT NULL,
   shipment_trace_code varchar(256) DEFAULT NULL,
   KEY id_idx (`id`),
   KEY order_id_fkey_idx (`order_id`),
   CONSTRAINT id_fkey FOREIGN KEY (`id`) REFERENCES user (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT order_id_fkey FOREIGN KEY (`order_id`) REFERENCES order (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()