#查找過去一年中以價格計算購買金額最高的客戶。

import mariadb

conn = mariadb.connect(**{
    "user": "411077022",
    "password": "411077022",
    "host": "140.127.74.226",
    "database": "411077022"
})

cursor = conn.cursor()

sql = """

SELECT `name`, MAX(`sum`)
FROM (
  SELECT user_order.`id`, user.`name`, SUM(`order`.`sum`) AS `sum`
  FROM `411077022`.user_order
  INNER JOIN `411077022`.user ON user_order.`id` = user.`id`
  INNER JOIN `411077022`.`order` ON `order`.`order_id` = user_order.`order_id`
  WHERE `order`.paying_status_id = 2
    AND `order`.paying_date >= '2022-01-01 00:00:00'
    AND `order`.paying_date < '2023-01-01 00:00:00'
  GROUP BY user_order.`id`, user.`name`
) AS the_most_spend_user;



"""

cursor.execute(sql)
conn.commit()

rows = cursor.fetchall()
# print(rows)
for row in rows:
    print(row)

cursor.close()
conn.close()