#假設由USPS運送的追蹤號碼為123456的包裹據報導在事故中被摧毀。查找該顧客的聯繫信息。還要查找該貨物的內容

import mariadb

conn = mariadb.connect(**{
    "user": "411077022",
    "password": "411077022",
    "host": "140.127.74.226",
    "database": "411077022"
})

cursor = conn.cursor()

sql = """

SELECT `user`.name, `user`.mail, `user`.phone
FROM `411077022`.user_order
INNER JOIN `411077022`.`user` ON user_order.`id` = `user`.`id`
WHERE user_order.shipment_trace_code = 123456;



"""

cursor.execute(sql)
conn.commit()

rows = cursor.fetchall()
# print(rows)
for row in rows:
    print(row)

cursor.close()
conn.close()