<?php
use \Psr\Container\ContainerInterface;

class home extends Model
{
    public function get_tables_statu($data){
        $sql = "SELECT `table_status`.`table_id`, `table`.`table_number`, `table_status`.`status_id`, `status`.`status` 
                FROM (`table_status` 
                LEFT JOIN `table` ON `table_status`.`table_id` = `table`.`table_id`) 
                LEFT JOIN `status` ON `table_status`.`status_id` = `status`.`table_status_id` ORDER BY table_id ASC;
        ";
        $sth = $this->container->db->prepare($sql);
        $sth->execute($data);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get_kind($data){
        $sql = "SELECT * FROM `kind` ";
        $sth = $this->container->db->prepare($sql);
        $sth->execute($data);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function post_kind($data){
        $sql = "INSERT INTO `kind`(`kind_name`) 
                VALUES (:kind_name)";
        $sth = $this->container->db->prepare($sql);
        if ($sth->execute($data)) {
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

    public function patch_kind($data){
        $sql = "UPDATE `kind` 
                SET `kind_name` = :kind_name 
                WHERE `kind_id` = :kind_id";

        $sth = $this->container->db->prepare($sql);
        if ($sth->execute($data)) {
            $status = [
                "status" => "success",
                "message" => "修改成功"
            ];
        } else {
            $status = [
                "status" => "failure",
                "message" => "修改失敗"
            ];
        }
        return $status;
    }

    public function delete_kind($data){
        $sql = "DELETE FROM `kind` 
                WHERE `kind_id` = :kind_id";
        
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

    public function get_menu($data){
        $pre_defined_values = [
            'cur_page' => 1,
            'size' => 5
        ];

        foreach ($data as $key => $value) {
            $pre_defined_values[$key] = $value;
        }
        $length = $pre_defined_values['size'] * $pre_defined_values['cur_page'];
        $start = $length - $pre_defined_values['size'];
        $pre_defined_values["length"] = $length;
        $pre_defined_values["start"] = $start;
        unset($pre_defined_values["cur_page"]);
        unset($pre_defined_values["size"]);

        $where_condition = "";
        if (array_key_exists('item_id', $data)) {
            $where_condition = "WHERE `item_kind`.`kind_id` = :`kind_id`";
            $pre_defined_values["kind_id"] = $data["kind_id"];
        }

        $sql = "SELECT * 
            FROM
            (
                SELECT `item_kind`.`kind_id`, `kind`.`kind_name`, `item_kind`.`item_id`, `item`.`item_name`, `item`.`price`,
                        ROW_NUMBER() OVER (ORDER BY item_import.item_id ASC) AS rownum
                FROM (`item_kind` 
                LEFT JOIN `kind` ON `item_kind`.`kind_id` = `kind`.`kind_id`) 
                LEFT JOIN `item` ON `item_kind`.`item_id` = `item`.`item_id`
                {$where_condition}
                LIMIT :length
            )AS divide
            WHERE divide.rownum > :start
        ";

        $sth = $this->container->db->prepare($sql);
        $sth->execute($pre_defined_values);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get_singal_dish($data){
        $sql = " SELECT * FROM `item` 
                 WHERE `item_id` = :item_id 
        ";
        $sth = $this->container->db->prepare($sql);
        $sth->execute($data);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function post_food($data){
        $values = [
            'item_id' => '',
            'item_name' => '',
            'price' => ''
        ];

        foreach ($values as $key => $value) {
            if (array_key_exists($key, $data)) {
                $values[$key] = $data[$key];
            }
        }

        $sql = "INSERT INTO `item`(`item_name`, `price`) 
                VALUES (:item_name, :price)
                WHERE `item_id` = :item_id";

        $sth = $this->container->db->prepare($sql);
        if ($sth->execute($values)) {
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

    public function post_account($data){
        $sql_account = "SELECT account
            FROM public.account
            WHERE account = $data[account]
        ";
        $temp = $this->container->db->prepare($sql_account);
        $temp->execute();
        if ($temp === null) {
            $sql = "INSERT INTO public.account(account, password)
                VALUES ($data[account], $data[password])
            ";

            $stmt = $this->container->db->prepare($sql);
            $stmt->execute();
            return ['status'=> 1];
        }
        
        return ['status'=> 409];
    }

    public function post_store_buyer($data){
        $sql_account = "SELECT account
            FROM public.account
            WHERE account = $data[account]
        ";
        $temp = $this->container->db->prepare($sql_account);
        $temp->execute();
        if ($temp === null) {
            if ($data['role_id'] == 1) {
                $sql_store = "INSERT INTO public.store
                    (store_name, address)
                    VALUES ($data[store_name], $data[address])";
            
                $store_stmt = $this->container->db->prepare($sql_store);
                $store_stmt->excute();
                return "true";
            }else{
                $sql_buyer = "INSERT INTO public.buyer
                    (name, phone)
                    VALUES (name, phone)";
                
                $buyer_stmt = $this->container->db->prepare($sql_buyer);
                $buyer_stmt->excute();
                return "true";

            }
        }
    }
    public function post_account_role($data){
        $sql_account = "SELECT account
            FROM public.account
            WHERE account = $data[account]
        ";
        $temp = $this->container->db->prepare($sql_account);
        $temp->execute();
        if ($temp === null) {
            if ($data['role_id'] === 1) {
                $sql_user = "SELECT store_id
                    FROM public.store
                    WHERE store_name == $data[store_name] AND address == $data[address]
                ";

                $user_id = $this->container->db->prepare($sql_user);
                $user_id->excute();
            } else {
                $sql_user = "SELECT buyer_id
                    FROM public.buyer
                    WHERE name == $data[name] AND phone == $data[phone]
                ";
                
                $user_id = $this->container->db->prepare($sql_user);
                $user_id->excute();
            }
            
            $sql_account_role = "INSERT INTO public.account_role
                (role_id, 'store_id/buyer_id')
                VALUES ($data[role_id], $user_id)
            ";

            $account_role_stmt = $this->container->db->prepare($sql_account_role);
            $account_role_stmt->excute();
            return "true";


        }
    }

}