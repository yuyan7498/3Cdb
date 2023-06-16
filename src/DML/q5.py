#查找未按照承諾時間交付的套餐。

import mariadb

conn = mariadb.connect(**{
    "user": "411077022",
    "password": "411077022",
    "host": "140.127.74.226",
    "database": "411077022"
})

cursor = conn.cursor()

sql = """

SELECT item_order.`group_name`
FROM `411077022`.user_order
INNER JOIN `411077022`.item_order ON item_order.`order_id` = user_order.`order_id`
INNER JOIN `411077022`.`order` ON `order`.`order_id` = user_order.`order_id`
WHERE DATE_ADD(`order`.set_time, INTERVAL 7 DAY) < now()
  AND `order`.`order_status_id` = 1
  AND user_order.`shipment_trace_code` IS NULL;



"""

cursor.execute(sql)
conn.commit()

rows = cursor.fetchall()
# print(rows)
for row in rows:
    print(row)

cursor.close()
conn.close()