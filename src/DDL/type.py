import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """


CREATE TABLE type (
   type_id int(11) NOT NULL AUTO_INCREMENT,
   type_name varchar(256) NOT NULL,
   PRIMARY KEY (`type_id`),
   UNIQUE KEY type_name_UNIQUE (`type_name`)
 ) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()