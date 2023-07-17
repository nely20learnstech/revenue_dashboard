<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Chart_models extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        // S2M global data

        public function society_revenue()
        {
            $query = $this->db->query("SELECT ROUND(sum(CA), 2) as total_sales
            FROM histo_vente WHERE DATE(date_heure_extraction) = CURRENT_DATE;");
            return $query->row_array();
        }

        public function get_store_data()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales, magasin FROM histo_vente WHERE DATE(date_heure_extraction) = CURRENT_DATE GROUP BY magasin, CA ORDER BY magasin;");

            return $query->result_array();
        }

        public function get_jumbo_score_data()
        {
            $query = $this->db->query("SELECT ROUND(sum(CA), 2) as total_sales, histo_vente.magasin  AS store
            FROM histo_vente
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin
            WHERE id_enseigne = 1 AND DATE(date_heure_extraction) = CURRENT_DATE
			GROUP BY histo_vente.magasin;");

            return $query->result_array();
        }

        public function get_score_data()
        {
            $query = $this->db->query("SELECT ROUND(sum(CA), 2) as total_sales, histo_vente.magasin  AS store
            FROM histo_vente
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin
            WHERE id_enseigne = 2 AND DATE(date_heure_extraction) = CURRENT_DATE
			GROUP BY histo_vente.magasin;");

            return $query->result_array();
        }

        public function get_super_maki_data()
        {
            $query = $this->db->query("SELECT ROUND(sum(CA), 2) as total_sales, histo_vente.magasin AS store
            FROM histo_vente
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin
            WHERE id_enseigne = 3 AND DATE(date_heure_extraction) = CURRENT_DATE
			GROUP BY histo_vente.magasin;");

            return $query->result_array();
        }

        // Stores chart

        public function get_maki_chart_data()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sell, to_char(date_heure_extraction, 'HH24:MI:SS') AS sell_time
            FROM histo_vente 
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin
            WHERE DATE(date_heure_extraction) = CURRENT_DATE AND id_enseigne = 3
            GROUP BY date_heure_extraction
            ORDER BY date_heure_extraction ASC;");
            return $query->result_array();
        }

        public function get_score_chart_data()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sell, to_char(date_heure_extraction, 'HH24:MI:SS') AS sell_time
            FROM histo_vente 
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin
            WHERE DATE(date_heure_extraction) = CURRENT_DATE AND id_enseigne = 2
            GROUP BY date_heure_extraction
            ORDER BY date_heure_extraction ASC;");
            return $query->result_array();
        }

        public function get_jumboScore_chart_data()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sell, to_char(date_heure_extraction, 'HH24:MI:SS') AS sell_time
            FROM histo_vente 
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin
            WHERE DATE(date_heure_extraction) = CURRENT_DATE AND id_enseigne = 1
            GROUP BY date_heure_extraction
            ORDER BY date_heure_extraction ASC;");
            return $query->result_array();
        }

        public function stores_data()
        {
            $query = $this->db->query("SELECT nom_enseigne, ROUND(sum(CA), 2) as total_sales
            FROM histo_vente
			JOIN magasin ON magasin.num_magasin = histo_vente.magasin
            WHERE DATE(date_heure_extraction) = CURRENT_DATE
			GROUP BY nom_enseigne;");
            return $query->result_array();
        }

        public function total_revenue()
        {
            $query = $this->db->query("SELECT ROUND(sum(CA), 2) as total_sales
            FROM histo_vente WHERE DATE(date_heure_extraction) = CURRENT_DATE;");
            return $query->result_array();
        }

        public function maki_total_sales()
        {
            $query = $this->db->query("SELECT ROUND(sum(CA), 2) as total_sales
            FROM histo_vente
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin
            WHERE id_enseigne = 3 AND DATE(date_heure_extraction) = CURRENT_DATE;");
            return $query->row_array();
        }
        
        public function score_total_sales()
        {
            $query = $this->db->query("SELECT ROUND(sum(CA), 2) as total_sales 
            FROM histo_vente 
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin
            WHERE id_enseigne = 2 AND DATE(date_heure_extraction) = CURRENT_DATE;");

            return $query->row_array();
        }
        
        public function jumbo_score_total_sales()
        {
            $query = $this->db->query("SELECT ROUND(sum(CA), 2) as total_sales 
            FROM histo_vente
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin
            WHERE id_enseigne = 1 AND DATE(date_heure_extraction) = CURRENT_DATE;");

            return $query->row_array();
        }

        // Society growth rates
        public function today_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now(), 'YYYY-MM-DD HH24');");
            return $query->result();
        }

        public function last_week_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 week', 'YYYY-MM-DD HH24');");
            return $query->result();
        }

        public function last_month_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 month', 'YYYY-MM-DD HH24');");
            return $query->result();
        }

        public function last_year_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 year', 'YYYY-MM-DD HH24');");
            return $query->result();
        }

        // Score data

        public function score_rank()
        {
            $query = $this->db->query("SELECT rank() OVER (ORDER BY sum(CA) DESC) AS store_rank, num_magasin AS store_num , nom_magasin AS store_name, slugify(nom_magasin) AS store_slug, adresse, ROUND(sum(CA), 2) AS total_revenue 
            FROM histo_vente
			JOIN magasin ON histo_vente.magasin = magasin.num_magasin
            WHERE id_enseigne = 2 AND DATE(date_heure_extraction) = CURRENT_DATE
            GROUP BY num_magasin, adresse;");

            return $query->result_array();
        }

        public function score_revenue()
        {
            $query = $this->db->query("SELECT ROUND(sum(CA), 2) as total_sell 
            FROM histo_vente
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin 
            WHERE id_enseigne = 2 AND DATE(date_heure_extraction) = CURRENT_DATE;");

            return $query->result_array();
        }

        public function score_today_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now(), 'YYYY-MM-DD HH24') AND id_enseigne = 2;");

            return $query->result();
        }

        public function score_last_week_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 week', 'YYYY-MM-DD HH24') AND id_enseigne = 2;");

            return $query->result();
        }

        public function score_last_month_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 month', 'YYYY-MM-DD HH24') AND id_enseigne = 2");

            return $query->result();
        }

        public function score_last_year_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 year', 'YYYY-MM-DD HH24') AND id_enseigne = 2");

            return $query->result();
        }

        // Maki data

        public function maki_rank()
        {
            $query = $this->db->query("SELECT rank() OVER (ORDER BY sum(CA) DESC) AS store_rank, num_magasin AS store_num , nom_magasin AS store_name, slugify(nom_magasin) AS store_slug, adresse, ROUND(sum(CA), 2) AS total_revenue 
            FROM histo_vente
			JOIN magasin ON histo_vente.magasin = magasin.num_magasin
            WHERE DATE(date_heure_extraction) = CURRENT_DATE AND magasin.num_magasin BETWEEN 49 AND 110
            GROUP BY num_magasin, adresse;");

            return $query->result_array();
        }

        public function maki_revenue()
        {
            $query = $this->db->query("SELECT ROUND(sum(CA), 2) as total_sell 
            FROM histo_vente
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin 
            WHERE id_enseigne = 3 AND DATE(date_heure_extraction) = CURRENT_DATE;");

            return $query->result_array();
        }

        public function maki_today_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now(), 'YYYY-MM-DD HH24') AND id_enseigne = 3;");

            return $query->result();
        }

        public function maki_last_week_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 week', 'YYYY-MM-DD HH24') AND id_enseigne = 3;");

            return $query->result();
        }

        public function maki_last_month_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 month', 'YYYY-MM-DD HH24') AND id_enseigne = 3;");

            return $query->result();
        }

        public function maki_last_year_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 year', 'YYYY-MM-DD HH24') AND id_enseigne = 3;");

            return $query->result();
        }

        // Jumbo Score data

        public function jumbo_score_rank()
        {
            $query = $this->db->query("SELECT rank() OVER (ORDER BY sum(CA) DESC) AS store_rank, num_magasin AS store_num , nom_magasin AS store_name, slugify(nom_magasin) AS store_slug, adresse, ROUND(sum(CA), 2) AS total_revenue 
            FROM histo_vente
			JOIN magasin ON histo_vente.magasin = magasin.num_magasin
            WHERE id_enseigne = 1 AND DATE(date_heure_extraction) = CURRENT_DATE 
            GROUP BY num_magasin, adresse;");

            return $query->result_array();
        }

        public function jumbo_score_revenue()
        {
            $query = $this->db->query("SELECT ROUND(sum(CA), 2) as total_sell 
            FROM histo_vente
            JOIN magasin ON magasin.num_magasin = histo_vente.magasin 
            WHERE id_enseigne = 1 AND DATE(date_heure_extraction) = CURRENT_DATE;");

            return $query->result_array();
        }

        public function jumbo_score_today_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now(), 'YYYY-MM-DD HH24') AND id_enseigne = 1;");

            return $query->result();
        }

        public function jumbo_score_last_week_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 week', 'YYYY-MM-DD HH24') AND id_enseigne = 1");

            return $query->result();
        }

        public function jumbo_score_last_month_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 month', 'YYYY-MM-DD HH24') AND id_enseigne = 1");

            return $query->result();
        }

        public function jumbo_score_last_year_sales()
        {
            $query = $this->db->query("SELECT sum(CA) AS total_sales
            FROM required_sales 
            JOIN magasin ON required_sales.magasin = magasin.num_magasin 
            WHERE to_char(date_heure_extraction, 'YYYY-MM-DD HH24')
            = to_char(now() - interval '1 year', 'YYYY-MM-DD HH24') AND id_enseigne = 1");

            return $query->result();
        }

        // Store Rank data

        public function store_rank()
        {
            $query = $this->db->query("SELECT rank() OVER (ORDER BY sum(CA) DESC) AS store_rank, num_magasin AS store_num , nom_magasin AS store_name, slugify(nom_magasin) AS store_slug, adresse, ROUND(sum(CA), 2) AS total_revenue 
            FROM histo_vente
			JOIN magasin ON histo_vente.magasin = magasin.num_magasin
            WHERE DATE(date_heure_extraction) = CURRENT_DATE
            GROUP BY num_magasin, adresse;");

            return $query->result_array();        
        }
        
    }
?>