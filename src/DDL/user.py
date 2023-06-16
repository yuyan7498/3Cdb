import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """


CREATE TABLE user (
   id int(11) NOT NULL AUTO_INCREMENT,
   name varchar(256) NOT NULL,
   mail varchar(256) NOT NULL,
   phone varchar(256) NOT NULL,
   bank_id int(11) DEFAULT NULL,
   bank_account varchar(256) DEFAULT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY mail_UNIQUE (`mail`),
   KEY bank_id_idx (`bank_id`),
   CONSTRAINT bank_id_fkey FOREIGN KEY (`bank_id`) REFERENCES bank (`bank_id`) ON DELETE SET NULL ON UPDATE CASCADE
 ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()