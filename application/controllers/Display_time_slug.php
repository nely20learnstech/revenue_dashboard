<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Display_time_slug extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model(array('display_time_slug_model', 'Search_model'));
            $this->load->helper('url_helper');
        }

        public function view($slug = NULL, $passed_items = NULL)
        {
            $items = str_replace('%20', ' ', $passed_items);

            $data["store"] = $this->display_time_slug_model->create_slug($slug, $items);            
           
            if(!empty($_POST) OR !empty($_FILES))
            {
                $_SESSION['sauvegarde'] = $_POST;
                $_SESSION['sauvegardeFILES'] = $_FILES;

                $CurrentFile = $_SERVER['PHP_SELF'];
                if(!empty($_SERVER['QUERY_STRING']))
                {
                    $CurrentFile .= '?' . $_SERVER['QUERY_STRING'];

                }

                header('Location: ' .$CurrentFile);
                exit;
            }

            if(isset($_SESSION['sauvegarde']))
            {
                $_POST = $_SESSION['sauvegarde'];
                $_FILES = $_SESSION['sauvegardeFILES'];

                unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);

            }

            // $data = [];
            $text = $this->input->post('Text');
            $selected_item = $this->input->post('Search'); 
            
            if(isset($text))
            {
                    $data['search_result']= $this->Search_model->get_items($text, $selected_item); 
                    if(empty($data['search_result']))
                    {
                        $data['message'] = "Désolé, ce que vous recherchez est malheuresement introuvable!";
                    }
            } 

            // var_dump($data);
            $this->load->view("time_viewer", $data);
        }

        public function fetch_store_data($slug, $passed_items)
        {
            $passed_items = str_replace('%20', ' ', $passed_items);
            $result = $this->display_time_slug_model->get_store_data($slug, $passed_items);
            foreach($result as $row)
            {
                $output[] = array(
                    'total_sell' => $row["total_sales"],
                    'sell_time' => $row["sell_time"]
                );
            }
            echo json_encode($output);
        }

        public function actual_revenue($slug, $passed_items)
        {
            $passed_items = str_replace('%20', ' ', $passed_items);
            $data = $this->display_time_slug_model->store_sales($slug, $passed_items);
            echo json_encode($data["store_revenue"]);
        }

        public function last_week_rate($slug, $passed_items)
        {
            $passed_items = str_replace('%20', ' ', $passed_items);
            $today_sales = $this->display_time_slug_model->today_sales($slug, $passed_items);
            $last_week_revenue = $this->display_time_slug_model->last_week_sales($slug, $passed_items);
                            
            if(!isset($last_week_revenue["total"]))
                $actual_rate = "Pas de ventes effectuées!";
            elseif($last_week_revenue["total"] == 0)
                $actual_rate = 0;
            else
                $actual_rate = (($today_sales["total"] - $last_week_revenue["total"]) / $last_week_revenue["total"]) * 100;  

            echo json_encode($actual_rate);
           
        }

        public function last_month_rate($slug, $passed_items)
        {
            $passed_items = str_replace('%20', ' ', $passed_items);
            $today_sales = $this->display_time_slug_model->today_sales($slug, $passed_items);
            $last_month_revenue = $this->display_time_slug_model->last_month_sales($slug, $passed_items);
               
            if(!isset($last_month_revenue["total"]))
                $actual_rate = "Pas de ventes effectuées!";
            elseif($last_month_revenue["total"] == 0)
                $actual_rate = 0;
            else
                $actual_rate = (($today_sales["total"] - $last_month_revenue["total"])/ $last_month_revenue["total"]) * 100;

            echo json_encode($actual_rate);
        }

        public function last_year_rate($slug, $passed_items)
        {
            $passed_items = str_replace('%20', ' ', $passed_items);
            $today_sales = $this->display_time_slug_model->today_sales($slug, $passed_items);
            $last_year_revenue = $this->display_time_slug_model->last_year_sales($slug, $passed_items);

            if(!isset($last_year_revenue["total"]))
                $actual_rate = "Pas de ventes effectuées!";
            elseif($last_year_revenue["total"] == 0)
                $actual_rate = 0;
            else
                $actual_rate = (($today_sales["total"] - $last_year_revenue["total"])/ $last_year_revenue["total"]) * 100;

            echo json_encode($actual_rate);
        }
    }
?>