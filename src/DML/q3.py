#查找高雄市每家店鋪都缺貨的產品。

import mariadb

conn = mariadb.connect(**{
    "user": "411077022",
    "password": "411077022",
    "host": "140.127.74.226",
    "database": "411077022"
})

cursor = conn.cursor()

sql = """

SELECT item.`item_name`
FROM `411077022`.stock
INNER JOIN `411077022`.item ON stock.`item_id` = item.`item_id`
WHERE stock.`stock_amount` = 0 AND stock.`stock_address` LIKE '%高雄市%'
GROUP BY item.`item_name`;



"""

cursor.execute(sql)
conn.commit()

rows = cursor.fetchall()
# print(rows)
for row in rows:
    print(row)

cursor.close()
conn.close()