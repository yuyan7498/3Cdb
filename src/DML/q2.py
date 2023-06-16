#查找過去一年中按銷售金額計算的前2個產品。

import mariadb

conn = mariadb.connect(**{
    "user": "411077022",
    "password": "411077022",
    "host": "140.127.74.226",
    "database": "411077022"
})

cursor = conn.cursor()

sql = """

SELECT CONCAT(item.`item_name`, specification.`specification_name`) AS `item_name`,
       (item_order.`amount` * specification.`specification_amount` * item.`price`) AS `item_cost`
FROM `411077022`.item_order
LEFT JOIN `411077022`.item_group ON item_group.`group_name` = item_order.`group_name`
LEFT JOIN `411077022`.specification ON item_order.`specification_id` = specification.`specification_id`
LEFT JOIN `411077022`.item ON specification.`item_id` = item.`item_id`
LEFT JOIN `411077022`.order ON item_order.`order_id` = `order`.`order_id`
WHERE `order`.paying_status_id = 2
  AND `order`.paying_date >= '2022-01-01 00:00:00'
  AND `order`.paying_date < '2023-01-01 00:00:00'
GROUP BY `item_name`, item_group.`group_name`, `item_cost`
ORDER BY `item_cost` DESC
LIMIT 2;


"""

cursor.execute(sql)
conn.commit()

rows = cursor.fetchall()
# print(rows)
for row in rows:
    print(row)

cursor.close()
conn.close()