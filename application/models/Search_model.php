<?php
    class Search_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();            
        }

        public function get_items($input_text, $item)
        {
            $input_text = trim($input_text);
            $delimiter = ' ';
            $tokens = explode($delimiter, $input_text);

            function buil_array($words)
            {
                $array = [];
                for($i=0; $i < sizeof($words); $i++)
                {
                    $array[$i]=  "'%$words[$i]%' ";        
                }
                return $array;
            }

            $words = buil_array($tokens);
            

            if(!isset($item))
            {
                echo "We have trouble";
            }
            else if($item[0] == "store")
            {
                if(is_numeric($input_text))
                {
                    $query = $this->db->query("SELECT slugify(nom_magasin) AS store_slug                
                    FROM magasin
                    WHERE magasin.num_magasin= $input_text;");  
                }
                else 
                {                
                    $query = $this->db->query("SELECT slugify(nom_magasin) AS store_slug                
                    FROM histo_vente
                    JOIN magasin ON histo_vente.magasin = magasin.num_magasin
                    WHERE CONCAT(adresse, nom_magasin, histo_vente.magasin)
                    ILIKE ALL (ARRAY[".implode(',', $words)."]) 
                    GROUP BY nom_magasin, adresse;");                
                }       
                $records = $query->result_array();   
            
                return $records;   
            }
            elseif($item[0] == "location")
            {
                $query = $this->db->query("SELECT rank() OVER (ORDER BY sum(CA) DESC) store_rank, num_magasin AS store_num, nom_magasin AS store_name, slugify(nom_magasin) AS store_slug, adresse AS address, sum(CA)::bigint AS total_revenue 
                FROM histo_vente
			    JOIN magasin ON histo_vente.magasin = magasin.num_magasin
                WHERE adresse
                ILIKE ANY (ARRAY[".implode(',', $words)."]) 
                AND DATE(date_heure_extraction) = CURRENT_DATE
                GROUP BY num_magasin;");
                $records = $query->result_array();                
               
                return $records;
            }
            elseif($item[0] == "rank")
            {
                   
                if(sizeof($tokens) == 3)
                {
                    if($tokens[1] == '-' or $tokens[1] == 'à')
                        if(is_numeric($tokens[0]) AND is_numeric($tokens[2]))
                        {
                                $query = $this->db->query("SELECT * FROM
                                (SELECT RANK() OVER (ORDER BY sum(CA) DESC) AS store_rank, num_magasin AS store_num, nom_magasin AS store_name, slugify(nom_magasin) AS store_slug, adresse AS address, sum(CA)::bigint AS total_revenue 
                                FROM histo_vente
                                JOIN magasin ON histo_vente.magasin = magasin.num_magasin
                                WHERE DATE(date_heure_extraction) = CURRENT_DATE
                                GROUP BY num_magasin) store_rank WHERE store_rank BETWEEN $tokens[0] AND $tokens[2]");   
                                $records = $query->result_array();  
                                return $records;
                        }
                //    else
                //    {
                //         $rank_error_message = "Veuillez entrer seulement des nombres pour la recheche par rang";
                //         return $rank_error_message;
                //    }
                }
                else if(sizeof($tokens) == 1)
                {
                    if(is_numeric($tokens[0]))
                    {
                        $query = $this->db->query("SELECT * FROM
                        (SELECT RANK() OVER (ORDER BY sum(CA) DESC) AS store_rank,  num_magasin AS store_num, nom_magasin AS store_name, slugify(nom_magasin) AS store_slug, adresse AS address, sum(CA)::bigint AS total_revenue 
                        FROM histo_vente                                
                        JOIN magasin ON histo_vente.magasin = magasin.num_magasin
                        WHERE DATE(date_heure_extraction) = CURRENT_DATE
                        GROUP BY num_magasin) store_rank WHERE store_rank = $input_text");
                        $records = $query->result_array(); 
                        return $records;
                            }
                            // else
                            // {
                            //      echo "Please enter only numbers";
                            // }
                         
                        }
                    // }                    
                    // else
                    // {
                    //     echo "Veuillez entrer au plus 2 chiffres"; 
                    // }
                // }
                // catch(Exception $e)
                // {
                //     echo "Not a number!" . $e;
                // }
                  
                // }
                // else
                // {
                //     echo "Not a number!";
                // }
                
                
            }
            elseif($item[0] == "time")
            {
                $query = $this->db->query("SELECT num_magasin AS store_num, nom_magasin AS store_name, slugify(nom_magasin) AS store_slug, adresse AS address, sum(CA)::bigint AS total_revenue, to_char(date_heure_extraction, 'DD/MM/YYYY HH24:MI:SS') AS sell_time
                FROM required_sales
			    JOIN magasin ON required_sales.magasin = magasin.num_magasin
                WHERE CONCAT(date_heure_extraction)
                ILIKE ANY (ARRAY[".implode(',', $words)."])
                GROUP BY num_magasin, date_heure_extraction
                ORDER BY date_heure_extraction");
                $records = $query->result_array();               
               
                return $records;
            }
            else
            {                  
                $query = $this->db->query("SELECT rank() OVER (ORDER BY sum(CA) DESC) store_rank, num_magasin AS store_num, nom_magasin AS store_name, slugify(nom_magasin) AS store_slug, adresse AS address,
                sum(CA)::bigint AS total_revenue 
                FROM histo_vente
			    JOIN magasin ON histo_vente.magasin = magasin.num_magasin
                WHERE CONCAT(nom_magasin, num_magasin, adresse, date_heure_extraction) 
                ILIKE ALL (ARRAY[".implode(',', $words)."])
                AND DATE(date_heure_extraction) = CURRENT_DATE
                GROUP BY num_magasin, adresse;");
                $records = $query->result_array();    

                if(empty($records))  
                {
                    $query = $this->db->query("SELECT rank() OVER (ORDER BY sum(CA) DESC) store_rank, num_magasin AS store_num, nom_magasin AS store_name, slugify(nom_magasin) AS store_slug, adresse AS address,
                    sum(CA)::bigint AS total_revenue 
                    FROM histo_vente
                    JOIN magasin ON histo_vente.magasin = magasin.num_magasin
                    WHERE CONCAT(nom_magasin, num_magasin, adresse, date_heure_extraction) 
                    ILIKE ANY (ARRAY[".implode(',', $words)."])
                    AND DATE(date_heure_extraction) = CURRENT_DATE
                    GROUP BY num_magasin, adresse;");                     
                } 
                $records = $query->result_array();           
                return $records;
            }                 
        }
}       
?>