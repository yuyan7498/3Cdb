import mariadb


try:
    
    conn = mariadb.connect(**{
        "user": "411077015",
        "password": "411077015",
        "host": "140.127.74.226",
        "database": "411077015"
        })
    conn.close()
    print('連接成功')

except mariadb.Error as e:
    print(f"連接失敗: {e}")
