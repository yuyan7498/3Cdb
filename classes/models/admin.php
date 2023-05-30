<?php
use \Psr\Container\ContainerInterface;

class admin extends Model
{
    public function retrieve_account_password($data) {
        $sql = "SELECT employee_id, account, password
        FROM `employee`
        WHERE account = :account AND password = :password";
        $sth = $this->container->db->prepare($sql);
        $sth->execute($data);
        return $sth->fetch();
    }

    public function get_picture($data) {
        $sql = "SELECT \"file.\".file_name
            FROM product.item_file
            LEFT JOIN product.\"file\" ON item_file.file_id = \"file\".file_id
            WHERE item_file.file_id = :file_id
            ";

        $sth = $this->container->db->prepare($sql);
        $sth->execute($data);
        $result = $sth->fetchColumn(0);
        return $result;
    }

    public function post_photo($data) {
        $values = [
            'file_client_name' => '',
            'file_name' => ''
        ];

        foreach ($values as $key => $value) {
            if (array_key_exists($key, $data)) {
                $values[$key] = $data[$key];
            }
        }

        $file_sql = "INSERT INTO product.file
            (file_client_name, file_name)
            OUTPUT Inserted.file_id
            VALUES (:file_client_name, :file_name)
            ";

        $file_sth = $this->container->db->prepare($file_sql);

        if (!$file_sth->execute($values)) {
            return [
                "status" => "failure",
                "message" => "新增失敗"
            ];
        }

        $file_id = $file_sth->fetch(PDO::FETCH_ASSOC);

        $data['file_id'] = $file_id;

        $item_file_sql = "INSERT INTO product.item_file
                        (item_id, file_id)
                        VALUES (:item_id, :file_id);";

        $item_file_sth = $this->container->db->prepare($item_file_sql);
        if ($item_file_sth->execute($values)) {
            $status = [
                "status" => "success",
                "message" => "新增成功"
            ];
        } else {
            $status = [
                "status" => "failure",
                "message" => "新增失敗"
            ];
        }
        return $status;
    }

    public function delete_photo($data) {
        $sql = "DELETE FROM product.file
            WHERE file.file_id = :file_id";
        
        $sth = $this->container->db->prepare($sql);
        if ($sth->execute($data)) {
            $status = [
                "status" => "success",
                "message" => "刪除成功"
            ];
        } else {
            $status = [
                "status" => "failure",
                "message" => "刪除失敗"
            ];
        }
        return $status;
    }
}