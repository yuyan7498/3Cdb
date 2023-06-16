import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """
CREATE TABLE bank (
    bank_id int(11) NOT NULL AUTO_INCREMENT,
    bank_code varchar(256) NOT NULL,
    bank_name varchar(256) NOT NULL,
    PRIMARY KEY (`bank_id`),
    UNIQUE KEY bank_code_UNIQUE (`bank_code`)
    )ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

"""

cursor.execute(sql)
conn.commit()

cursor.close()
conn.close()
