<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class display_time_slug_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        // Create slug
        public function create_slug($store_slug, $search_items)
        {
            $query = $this->db->query("SELECT num_magasin AS store_num, nom_enseigne AS store_type_name, nom_magasin AS store_name,
            slugify(nom_magasin) AS slug, to_char(date_heure_extraction, 'DD/MM/YYYY HH24:MI:SS') as date_heure_extraction
            FROM magasin
            JOIN required_sales ON required_sales.magasin = magasin.num_magasin
            WHERE slugify(nom_magasin) = '$store_slug' AND to_char(date_heure_extraction, 'DD-MM-YYYY HH24:MI:SS') = '$search_items'");
            return $query->row_array();
        }

        // Get every store data
        public function get_store_data($store_slug, $search_items)
        {
            $query = $this->db->query("SELECT CA AS total_sales, to_char(date_heure_extraction, 'HH24:MI:SS') AS sell_time
            FROM required_sales
			JOIN magasin ON required_sales.magasin = magasin.num_magasin            
			WHERE slugify(nom_magasin) = '$store_slug' AND date(date_heure_extraction) = '$search_items' GROUP BY CA, date_heure_extraction");

            return $query->result_array();
        }

        public function store_sales($store_slug, $search_items)
        {
            $query = $this->db->query("SELECT ROUND(sum(CA),2) AS store_revenue
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin   
            WHERE slugify(nom_magasin) = '$store_slug' AND to_char(date_heure_extraction, 'DD-MM-YYYY HH24:MI:SS') = '$search_items'");

            return $query->row_array();
        }

        // Data for growth rates 

        public function today_sales($store_slug, $search_items )
        {
            $query = $this->db->query("SELECT CA AS total
            FROM required_sales
			JOIN magasin ON required_sales.magasin = magasin.num_magasin
            WHERE slugify(nom_magasin) = '$store_slug' 
            AND to_char(date_heure_extraction, 'YYYY-MM-DD HH24') = to_char('$search_items'::timestamp , 'YYYY-MM-DD HH24');");

            return $query->row_array();
        }

        public function last_week_sales($store_slug, $search_items)
        {
            $query = $this->db->query("SELECT CA AS total
            FROM required_sales
			JOIN magasin ON required_sales.magasin = magasin.num_magasin
            WHERE slugify(nom_magasin) = '$store_slug' 
            AND to_char(date_heure_extraction, 'YYYY-MM-DD HH24') = to_char('$search_items'::timestamp - interval '1 week', 'YYYY-MM-DD HH24');");

            return $query->row_array();
        }

        public function last_month_sales($store_slug,$search_items )
        {
            $query = $this->db->query("SELECT CA AS total
            FROM required_sales
			JOIN magasin ON required_sales.magasin = magasin.num_magasin
            WHERE slugify(nom_magasin) = '$store_slug' 
            AND to_char(date_heure_extraction, 'YYYY-MM-DD HH24') = to_char('$search_items'::timestamp  - interval '1 month', 'YYYY-MM-DD HH24');");

            return $query->row_array();
        }        
        
        public function last_year_sales($store_slug,$search_items )
        {
            $query = $this->db->query("SELECT CA AS total
            FROM required_sales
			JOIN magasin ON required_sales.magasin = magasin.num_magasin
            WHERE slugify(nom_magasin) = '$store_slug' 
            AND to_char(date_heure_extraction, 'YYYY-MM-DD HH24') = to_char('$search_items'::timestamp  - interval '1 year', 'YYYY-MM-DD HH24');");

            return $query->row_array();

        } 
    }
?>