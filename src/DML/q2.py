#

import mariadb

conn = mariadb.connect(**{
    "user": "411077015",
    "password": "411077015",
    "host": "140.127.74.226",
    "database": "411077015"
})

cursor = conn.cursor()

sql = """

SELECT buyer_account, SUM(price*amount) AS total_spent
FROM `411077005`.sales_record
LEFT JOIN `411077005`.shipment ON sales_record.shipping_tracking_number = shipment.shipping_tracking_number
LEFT JOIN `411077005`.commodity ON shipment.commodity_name = commodity.name
WHERE sale_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND lost <> 1
GROUP BY buyer_account
ORDER BY total_spent DESC
LIMIT 1;

"""

cursor.execute(sql)
conn.commit()

rows = cursor.fetchall()
# print(rows)
for row in rows:
    print(row)

cursor.close()
conn.close()