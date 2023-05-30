<?php

use \Psr\Container\ContainerInterface;
use \Slim\Views\PhpRenderer;

class homecontroller extends Controller
{

    public function register($data){
        $home = new home($this->container->db);
        $result_account = $home->post_account($data);
        $result_user = $home->post_store_buyer($data);
        $result_account_role = $home->post_account_role($data);
        if ($result_account === $result_user && $result_account === $result_account_role){
            return $result_account;
        }else{
            return $result_account;
        }
    }

    public function check_table_status($request, $response, $args){
        $data = $request->getQueryParams();
        $home = new home($this->container->db);
        $result = $home->get_tables_statu($data);
        return $this->responseJson($response, $result);

    }

    public function get_food_kind($request, $response, $args){
        $data = $request->getQueryParams();
        $home = new home($this->container->db);
        $result = $home -> get_kind($data);
        return $this->responseJson($response, $result);
    }

    public function post_new_kind($request, $response, $args){
        $data = $request->getParsedBody();
        $home = new home($this->container);
        $result = $home->post_kind($data);
        return $this->responseJson($response, $result);
    }

    public function patch_kind($request, $response, $args){
        $data = $request->getParsedBody();
        $home = new home($this->container);
        $result = $home->patch_kind($data);
        return $this->responseJson($response, $result);
    }

    public function delete_kind($request, $response, $args){
        $data = $request->getParsedBody();
        $home = new home($this->container);
        $result = $home->delete_kind($data);
        return $this->responseJson($response, $result);
    }

    public function retrieve_menu_info($request, $response, $args){
        $data = $request->getQueryParams();
        $home = new home($this->container->db);
        $result = $home -> get_menu($data);
        if(array_key_exists("kind_id", $data)) return $this->responseJson($response, array_shift($result));
        return $this->responseJson($response, $result);
    }

    public function retrieve_specify_food($request, $response, $args){
        $data = $request->getQueryParams();
        $home = new home($this->container->db);
        $result = $home -> get_singal_dish($data);
        return $this->responseJson($response, $result);
    }

    public function post_new_food($request, $response, $args){
        $data = $request->getParsedBody();
        $home = new home($this->container);
        $result = $home->post_food($data);
        return $this->responseJson($response, $result);
    }


}