<?php
class SearchModel extends Model{
	public function index(){
		// Sanitize POST array
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		prettyPrint($post);
		if($post['search-term'] !=''){
			$keyword = $post['search-term'];
			$this->query('(SELECT id, first_name, last_name, "person" as type FROM person_details WHERE first_name LIKE "' . 
           $keyword . '%" OR last_name LIKE "' . $keyword .'%") 
           UNION
           (SELECT id, person_id, email, "email" as type FROM email_addresses WHERE email LIKE "' . 
           $keyword . '%" OR person_id LIKE "' . $keyword .'%") ');
			$res = $this->resultSet();
			//$this->query('SELECT id, first_name, last_name FROM person_details WHERE ');
			if($res >= 0){
				return $res;
			}else {
				return 0;
			}
		}
		return;
	}
}