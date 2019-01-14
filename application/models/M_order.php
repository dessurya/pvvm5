<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_order extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getdata($roll_id){
		$this->datatables->select('ID,city.Name as namakota,city.Population as populasi,country.Name as namanegara');
        $this->datatables->from('city');
        $this->datatables->join('country', 'city.CountryCode = country.Code');
        $this->datatables->add_column('view', '<a href="world/edit/$1">edit</a> | <a href="world/delete/$1">delete</a>', 'ID');
        return $this->datatables->generate();
	}
	
	public function getdataold($roll_id){
		$query = "
			SELECT
				*
			FROM 
				APWMS_TR_AUTH_TYPE_MENU ATM
			INNER JOIN
				APWMS_TR_MENU TM
				ON ATM.MENU_ID = TM.ID
			WHERE 
				TM.TYPE_MENU = 'P'
				AND ATM.AUTH_TYPE_ID = ".$roll_id."
			ORDER BY TM.SORT_MENU ASC
		";
		$runQuery = $this->db->query($query);
		$arrdata = $runQuery->result_array();
		$menus = "";

		foreach ($arrdata as $list) {
			$menus .= "<li>";
			$list['URL_MENU'] == null ? $menus .= "<a>" : $menus .='<a href="'.site_url().'/'.$list['URL_MENU'].'">';
			$list['ICON'] == null ? "" : $menus .=$list['ICON']." ";
			$menus .= $list['TITLE_MENU'];
			$childs = $this->getChild($list['ID']);
			if (count($childs) >= 1) {
				$menus .= '<span class="fa fa-chevron-down"></span></a>';
				$menus .= '<ul class="nav child_menu">';
				foreach ($childs as $listsd) {
					$menus .= "<li>";
					$menus .='<a href="'.site_url().'/'.$listsd['URL_MENU'].'">';
					$listsd['ICON'] == null ? "" : $menus .=$listsd['ICON']." ";
					$menus .= $listsd['TITLE_MENU'];
					$menus .= '</a>';
					$menus .= "</li>";
				}	
				$menus .= '</ul>';
			}
			else{
				$menus .= "</a>";
			}
			$menus .= "</li>";
		}

		return $menus;
	}
}
?>