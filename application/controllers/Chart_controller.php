<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Chart_controller extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper(array('url', 'form'));
            $this->load->model(array('Chart_models', 'Search_model'));
        }

        public function home_contains()        
        {    
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
            
            $this->load->view('home');              
        }

        public function show_result_search()
        {
            // $data = [];
            $text = $this->input->post('query');
            $selected_item = $this->input->post('btn'); 
            
            if(isset($text))
            {
                $data['search_result']= $this->Search_model->get_items($text, $selected_item); 
                if(empty($data['search_result']))
                {
                    $data['message'] = "Désolé, ce que vous recherchez est malheuresement introuvable!";
                }   
            }

            echo json_encode($data);
        }

        public function fetch_society_data()
        {
            // S2M store and revenue
            $store_revenue = $this->Chart_models->get_store_data();
            // Society global revenue 
            $society_total_revenue = $this->Chart_models->society_revenue();

            // stores and revenue from different store types
            $jumboScore_store_revenue = $this->Chart_models->get_jumbo_score_data();  
            $score_store_revenue = $this->Chart_models->get_score_data(); 
            $maki_store_revenue = $this->Chart_models->get_super_maki_data(); 

            // global revenue from different store types
            $maki_total_revenue = $this->Chart_models->maki_total_sales();
            $score_total_revenue = $this->Chart_models->score_total_sales();
            $jumbo_score_total_revenue = $this->Chart_models->jumbo_score_total_sales();


            foreach($jumboScore_store_revenue as $row)
            {
                $sales = $row["total_sales"];
                $store_num = $row["store"];
                $society_revenue = $society_total_revenue["total_sales"];
                $JumboScore_revenue = $jumbo_score_total_revenue["total_sales"];

                if($society_revenue !=0)
                {
                    $store_rate = $sales / $society_revenue * 100;
                }
                else
                {
                    $store_rate = 0;
                }

                if($JumboScore_revenue!=0)
                {
                    $jumbo_rate = $sales / $JumboScore_revenue * 100;
                }
                else
                {
                    $jumbo_rate = 0;
                }
        
                $output1[] = array(
                    'jumboScore_revenue' => $sales,
                    'jumboScore_store_num' => $store_num,
                    'store_rate' =>  $store_rate,
                    'jumboScore_sales_rate' =>  $jumbo_rate,                      
                );
            }

            foreach($score_store_revenue as $row)
            {
                $sales = $row["total_sales"];
                $store_num = $row["store"];
                $society_revenue = $society_total_revenue["total_sales"];
                $score_revenue = $score_total_revenue["total_sales"];

                if($society_revenue !=0)
                {
                    $store_rate = $sales / $society_revenue * 100;
                }
                else
                {
                    $store_rate = 0;
                }

                if($score_revenue!=0)
                {
                    $score_rate = $sales / $score_revenue * 100;
                }
                else
                {
                    $score_rate = 0;
                }
        
                $output2[] = array(
                    'score_revenue' => $sales,
                    'score_store_num' => $store_num,
                    'store_rate' =>  $store_rate,
                    'score_sales_rate' =>  $score_rate,                      
                );
            }

            foreach($maki_store_revenue as $row)
            {
                $sales = $row["total_sales"];
                $store_num = $row["store"];
                $society_revenue = $society_total_revenue["total_sales"];
                $maki_revenue = $maki_total_revenue["total_sales"];

                if($society_revenue !=0)
                {
                    $store_rate = $sales / $society_revenue * 100;
                }
                else
                {
                    $store_rate = 0;
                }

                if($maki_revenue!=0)
                {
                    $maki_rate = $sales / $maki_revenue * 100;
                }
                else
                {
                    $maki_rate = 0;
                }
        
                $output3[] = array(
                    'maki_revenue' => $sales,
                    'maki_store_num' => $store_num,
                    'store_rate' =>  $store_rate,
                    'maki_sales_rate' =>  $maki_rate                      
                );
            }
 
            $output = array($output1 , $output2, $output3); 
            echo json_encode($output);
        }

        public function home_data()
        {
            $global_revenue=  $this->Chart_models->total_revenue();   
            foreach($global_revenue as $row)
            {
                $output[] = array(
                    'total_sell' => $row["total_sales"], 
                );
            }  
            
            echo json_encode($output);
        }

        public function last_week_rate()
        {  
            $today_sales  = $this->Chart_models->today_sales();
            $last_week_sales = $this->Chart_models->last_week_sales();   
            
            foreach($last_week_sales as $row)
            {
                $week_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

            if($week_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
            }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $week_sales) / $week_sales ) * 100
                );
            }            
           
            echo json_encode($actual_rate);                   
        }

        public function last_month_rate()
        {  
            $today_sales  = $this->Chart_models->today_sales();
            $last_month_sales = $this->Chart_models->last_month_sales();   
            
            foreach($last_month_sales as $row)
            {
                $month_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

        
            if($month_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
            }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $month_sales) / $month_sales ) * 100
                );
            }          
           
            echo json_encode($actual_rate);                   
        }

        public function last_year_rate()
        {  
            $today_sales  = $this->Chart_models->today_sales();
            $last_year_sales = $this->Chart_models->last_year_sales();   
            
            foreach($last_year_sales as $row)
            {
                $year_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

    
            if($year_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
            }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $year_sales) / $year_sales ) * 100
                );
            }
                
            echo json_encode($actual_rate);
        }     

        public function fetch_score_data()
        {
            $result = $this->Chart_models->get_score_chart_data();
            foreach($result as $row)
            {
                $output[] = array(
                    'total_sell' => $row["total_sell"],
                    'sell_time' => $row["sell_time"]
                );
            }
            echo json_encode($output);
        }

        public function fetch_maki_data()
        {
            $result = $this->Chart_models->get_maki_chart_data();
            foreach($result as $row)
            {
                $output[] = array(
                    'total_sell' => $row["total_sell"],                    
                    'sell_time' => $row["sell_time"]
                );
            }
            echo json_encode($output);
        }

        public function fetch_jumboScore_data()
        {
            $result = $this->Chart_models->get_jumboScore_chart_data();
            foreach($result as $row)
            {
                $output[] = array(
                    'total_sell' => $row["total_sell"],                    
                    'sell_time' => $row["sell_time"]
                );
            }
            echo json_encode($output);
        }

        public function fetch_piechart_data()
        {
            $result = $this->Chart_models->stores_data();
            foreach($result as $row)
            {
                $output[] = array(
                    'store_type' => $row["nom_enseigne"],                    
                    'total_sales' => $row["total_sales"]
                );
            }
            echo json_encode($output);
        }


        // Score Methods
        public function score_contains()
        {    
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

            $data = [];
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
            $this->load->view('score', $data);
        }

        public function score_data()
        {
            $revenue = $this->Chart_models->score_revenue();
            foreach($revenue as $row)
            {
                $output[] = array(
                    'total_sell' => $row["total_sell"], 
                );
            }  
            
            echo json_encode($output);
        }

        public function score_last_week_rate()
        {  
            $today_sales  = $this->Chart_models->score_today_sales();
            $last_week_sales = $this->Chart_models->score_last_week_sales();   
            
            foreach($last_week_sales as $row)
            {
                $week_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

            if($week_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
            }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $week_sales) / $week_sales ) * 100
                );
            }         

            echo json_encode($actual_rate);                   
        }

        public function score_last_month_rate()
        {  
            $today_sales  = $this->Chart_models->score_today_sales();
            $last_month_sales = $this->Chart_models->score_last_month_sales();   
            
            foreach($last_month_sales as $row)
            {
                $month_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

            if($month_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
            }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $month_sales) / $month_sales ) * 100
                );
            }
                    
            echo json_encode($actual_rate);                   
        }

        public function score_last_year_rate()
        {  
            $today_sales  = $this->Chart_models->score_today_sales();
            $last_year_sales = $this->Chart_models->score_last_year_sales();   
            
            foreach($last_year_sales as $row)
            {
                $year_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

            if($year_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
            }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $year_sales) / $year_sales ) * 100
                );
            }
                
         
            echo json_encode($actual_rate);
        }                   

        public function score_table()
        {
            $rank = $this->Chart_models->score_rank(); 
            foreach($rank as $row)
            {
                $output[] = array(
                    'store_rank' => $row["store_rank"], 
                    'store_num' => $row["store_num"],
                    'store_name' => $row["store_name"],
                    'store_slug' => $row["store_slug"],
                    'address' => $row["adresse"],                    
                    'total_revenue' => $row["total_revenue"],
                );
            }  
            
            echo json_encode($output);
        }

        // Maki controller methods

        public function maki_contains()
        {

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

            $data = [];
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

            $this->load->view('maki', $data);
        }

        public function maki_data()
        {
            $revenue = $this->Chart_models->maki_revenue();
            foreach($revenue as $row)
            {
                $output[] = array(
                    'total_sell' => $row["total_sell"], 
                );
            }  
            
            echo json_encode($output);
        }

        public function maki_last_week_rate()
        {  
            $today_sales  = $this->Chart_models->maki_today_sales();
            $last_week_sales = $this->Chart_models->maki_last_week_sales();   
            
            foreach($last_week_sales as $row)
            {
                $week_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

            if($week_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
            }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $week_sales) / $week_sales ) * 100
                );
            }                
           
            echo json_encode($actual_rate);                   
        }

        public function maki_last_month_rate()
        {  
            $today_sales  = $this->Chart_models->maki_today_sales();
            $last_month_sales = $this->Chart_models->maki_last_month_sales();   
            
            foreach($last_month_sales as $row)
            {
                $month_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

            if($month_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
            }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $month_sales) / $month_sales ) * 100
                );
            }
            
           
            echo json_encode($actual_rate);                   
        }

        public function maki_last_year_rate()
        {  
            $today_sales  = $this->Chart_models->maki_today_sales();
            $last_year_sales = $this->Chart_models->maki_last_year_sales();   
            
            foreach($last_year_sales as $row)
            {
                $year_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

            if($year_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
            }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $year_sales) / $year_sales ) * 100
                );
            }     
           
            echo json_encode($actual_rate);                   
        }

        public function maki_table()
        {
            $rank = $this->Chart_models->maki_rank(); 
            foreach($rank as $row)
            {
                $output[] = array(
                    'store_rank' => $row["store_rank"], 
                    'store_num' => $row["store_num"],
                    'store_name' => $row["store_name"],
                    'store_slug' => $row["store_slug"],
                    'address' => $row["adresse"],                    
                    'total_revenue' => $row["total_revenue"],
                );
            }  
            
            echo json_encode($output);
        }

        // Jumbo Score methods

        public function jumboScore_contains()
        {
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

            $data = [];
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

            $this->load->view('jumbo_score', $data);
        }

        public function jumboScore_data()
        {
            $revenue = $this->Chart_models->jumbo_score_revenue();
            foreach($revenue as $row)
            {
                $output[] = array(
                    'total_sell' => $row["total_sell"], 
                );
            }  
            
            echo json_encode($output);
        }

        public function jumbo_score_last_week_rate()
        {  
            $today_sales  = $this->Chart_models->jumbo_score_today_sales();
            $last_week_sales = $this->Chart_models->jumbo_score_last_week_sales();   
            
            foreach($last_week_sales as $row)
            {
                $week_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

            if($week_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
                }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $week_sales) / $week_sales ) * 100
                );
            }                 
           
            echo json_encode($actual_rate);                   
        }

        public function jumbo_score_last_month_rate()
        {  
            $today_sales  = $this->Chart_models->jumbo_score_today_sales();
            $last_month_sales = $this->Chart_models->jumbo_score_last_month_sales();   
            
            foreach($last_month_sales as $row)
            {
                $month_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

            if($month_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
            }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $month_sales) / $month_sales ) * 100
                );
            }
            
            echo json_encode($actual_rate);                   
        }

        public function jumbo_score_last_year_rate()
        {  
            $today_sales  = $this->Chart_models->jumbo_score_today_sales();
            $last_year_sales = $this->Chart_models->jumbo_score_last_year_sales();   
            
            foreach($last_year_sales as $row)
            {
                $year_sales = $row->total_sales;
            }

            foreach($today_sales as $row)
            {
                $t_sales = $row->total_sales;
            }            

            if($year_sales==0)
            {
                $actual_rate[] =
                array(
                    'rate' => "Pas de ventes effectuées!"
                );
            }
            else
            {
                $actual_rate[]= array(
                    'rate' => (($t_sales - $year_sales) / $year_sales ) * 100
                );
            }      
           
            echo json_encode($actual_rate);                   
        }

        public function jumboScore_table()
        {
            $rank = $this->Chart_models->jumbo_score_rank(); 
            foreach($rank as $row)
            {
                $output[] = array(
                    'store_rank' => $row["store_rank"], 
                    'store_num' => $row["store_num"],
                    'store_name' => $row["store_name"],
                    'store_slug' => $row["store_slug"],
                    'address' => $row["adresse"],                    
                    'total_revenue' => $row["total_revenue"],
                );
            }  
            
            echo json_encode($output);
        }


        // Store rank methods
        public function storerank_contains()
        {
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

            $data = [];
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

            $this->load->view('storerank', $data);
        }

        public function store_table()
        {
            $rank = $this->Chart_models->store_rank(); 
            foreach($rank as $row)
            {
                $output[] = array(
                    'store_rank' => $row["store_rank"], 
                    'store_num' => $row["store_num"],
                    'store_name' => $row["store_name"],
                    'store_slug' => $row["store_slug"],
                    'address' => $row["adresse"],                    
                    'total_revenue' => $row["total_revenue"],
                );
            }  
            
            echo json_encode($output);
        }
    }

?>