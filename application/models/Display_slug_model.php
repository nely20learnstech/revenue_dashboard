<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class display_slug_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        // Create slug
        public function create_slug($store_slug)
        {
            $query = $this->db->query("SELECT num_magasin AS store_num, nom_enseigne AS store_type_name, nom_magasin AS store_name, slugify(nom_magasin) AS slug
            FROM magasin
            WHERE slugify(nom_magasin) = '$store_slug'");

            return $query->row_array();
        }

        public function get_store_data($store_slug)
        {
            $query = $this->db->query("SELECT CA AS total_sales, to_char(date_heure_extraction, 'HH24:MI:SS') AS sell_time
            FROM histo_vente
			JOIN magasin ON histo_vente.magasin = magasin.num_magasin            
			WHERE slugify(nom_magasin) = '$store_slug' AND date(date_heure_extraction) = current_date GROUP BY CA, date_heure_extraction");

            return $query->result_array();
        }

        public function store_sales($store_slug)
        {
            $query = $this->db->query("SELECT ROUND(sum(CA),2) AS store_revenue
            FROM histo_vente 
            JOIN magasin ON histo_vente.magasin = magasin.num_magasin   
            WHERE slugify(nom_magasin) = '$store_slug' AND date(date_heure_extraction) = current_date");

            return $query->row_array();
        }

        public function today_sales($store_slug)
        {
            $query = $this->db->query("SELECT CA AS total
            FROM required_sales
			JOIN magasin ON required_sales.magasin = magasin.num_magasin
            WHERE slugify(nom_magasin) = '$store_slug' 
            AND to_char(date_heure_extraction, 'YYYY-MM-DD HH24') = to_char(now(), 'YYYY-MM-DD HH24');");

            return $query->row_array();
        }

        public function last_week_sales($store_slug)
        {
            $query = $this->db->query("SELECT CA AS total
            FROM required_sales
			JOIN magasin ON required_sales.magasin = magasin.num_magasin
            WHERE slugify(nom_magasin) = '$store_slug' 
            AND to_char(date_heure_extraction, 'YYYY-MM-DD HH24') = to_char(now() - interval '1 week', 'YYYY-MM-DD HH24');");

            return $query->row_array();
        }

        public function last_month_sales($store_slug)
        {
            $query = $this->db->query("SELECT CA AS total
            FROM required_sales
			JOIN magasin ON required_sales.magasin = magasin.num_magasin
            WHERE slugify(nom_magasin) = '$store_slug' 
            AND to_char(date_heure_extraction, 'YYYY-MM-DD HH24') = to_char(now() - interval '1 month', 'YYYY-MM-DD HH24');");

            return $query->row_array();
        }        
        
        public function last_year_sales($store_slug)
        {
            $query = $this->db->query("SELECT CA AS total
            FROM required_sales
			JOIN magasin ON required_sales.magasin = magasin.num_magasin
            WHERE slugify(nom_magasin) = '$store_slug' 
            AND to_char(date_heure_extraction, 'YYYY-MM-DD HH24') = to_char(now() - interval '1 year', 'YYYY-MM-DD HH24');");

            return $query->row_array();
        } 
    }
?>