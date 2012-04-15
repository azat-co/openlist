<?php
include 'systemconsts.class.php';
include 'model.class.php';
class Service {
	
    private $model;
	/*
    public function __set($name, $value) {
        switch($name)
        {
            case 'username':
            $this->username = $value;
            break;

            case 'password':
            $this->password = $value;
            break;

            case 'dsn':
            $this->dsn = $value;
            break;

            default:
            throw new Exception("$name is invalid");
        }
    }
	*/
	public function init ($dsn,$username,$password) {
		$this->model= new crud();
		$this->model->dsn = $dsn;
		$this->model->username = $username;
		$this->model->password = $password;
		$this->model->rawQuery('SET character_set_results=utf8');
		$this->model->rawQuery('SET NAMES utf8');
	}
	
	// private static $m_pInstance;
    // private function __construct() {
		
		// $this->init(SystemConsts::DSN,SystemConsts::USERNAME,SystemConsts::PASSWORD);
	// }

    // public static function getInstance()    {
        // if (!self::$m_pInstance)        {
            // self::$m_pInstance = new Service();echo '!';
        // }
        // return self::$m_pInstance;
    // } 

	function getInstance ()
    // this implements the 'singleton' design pattern.
    {
        static $instance;        
        if (!isset($instance)) {
            $c = __CLASS__;
            $instance = new $c;
		//	echo '!';
			$instance->init(SystemConsts::DSN,SystemConsts::USERNAME,SystemConsts::PASSWORD);
			//$instance->init(SYS_DB,SYS_USERNAME,SYS_PASSWORD);
        } // if        
        return $instance;       
    } // getInstance

	public function get_city_list () {
		$records = $this->model->rawSelect(SQL_SELECT_CITIES);
		return  $records->fetchAll(PDO::FETCH_ASSOC);		
	}
	public function get_category_list() {		
		$records=$this->model->rawSelect('SELECT COUNT(parent.name)-1 AS lvl, node.id AS id, node.disp_name AS disp_name, node.name AS name FROM '.SystemConsts::DB.'.category AS node, '.SystemConsts::DB.'.category AS parent WHERE node.lft BETWEEN parent.lft AND parent.rgt AND node.active=1 GROUP BY node.name ORDER BY  node.lft ASC');
		return $records->fetchAll(PDO::FETCH_ASSOC);
	}
	public function get_category_list_with_ad_count($city_id) {		
		return $this->model->get_category_list_with_ad_count($city_id);
	}
	public function get_category_path($cat_id) {
		return $this->model->get_category_path($cat_id);
	}
	public function get_city_by_id($city_id) {
		return reset($this->model->dbSelect('city','id',$city_id));		
	}
	public function get_category_by_id($cat_id) {
		return reset($this->model->dbSelect('category','id',$cat_id));		
	}	
	public function get_content_list($content_id) {
		return $this->model->dbSelect('content','id',$content_id);		
	}	
	public function get_content_by_name($name) {
		$result=$this->model->dbSelect('content','name',$name);		
		if (count($result)==1) {
			return $result[0];
		}
		return null;
	}		
	public function get_city_id_by_name($name) {
		$result=$this->model->dbSelect('city','name',$name);		
		if (count($result)==1) {
			return $result[0]['id'];
		}
		return null;	
	}
	public function get_cat_id_by_name($name) {
		$result=$this->model->dbSelect('category','name',$name);		
		if (count($result)==1) {
			return $result[0]['id'];
		}
		return null;	
	}	
	public function get_searchable_field_list($cat_id) {//ONLY SEARCHABLE + VALUES FOR sel TYPE
		$rows = $this->model->get_searchable_field_list($cat_id);
		if (count($rows)>0) {				//do select fields			
			foreach ($rows as $key=>$value) {
				if ($value['type']==TYPE_SELECT) {						
					$rows[$key]['option_list']=$this->model->get_option_list_by_field_id($value['id']);
				}
			}			
			return $rows;	
		}	
		else {
			return null;
		}
	}
	public function get_all_field_list ($cat_id) {		
		$rows = $this->model->get_all_field_list($cat_id);
		if (count($rows)>0) {		//do select fields
			foreach ($rows as $key=>$value) {
				if ($value['type']==TYPE_SELECT) {											
					$rows[$key]['option_list']=$this->model->get_option_list_by_field_id($value['id']);
				}
			}			
			return $rows;	
		}	
		else {
			return null;
		}					
	}
	public function get_ad_list($city_id, $cat_id, $page) {//REGULAR VIEW IN CATEGORY
		$start_limit=($page-1)*(int)CONF_PAGE_LIMIT;			
		return $this->model->get_ad_list($city_id,$cat_id,$start_limit);
	}
	public function get_ad_list_for_rss($city_id, $cat_id) {//RSS
		return $this->model->get_ad_list_for_rss($city_id,$cat_id);
	}	

	public function get_ad_list_by_id_list($ad_id_list, $page) {//FAVORITES!!!
		$start_limit=($page-1)*(int)CONF_PAGE_LIMIT;
		return  $this->model->get_ad_list_by_id_list($ad_id_list,$start_limit);
	}

	public function get_ad_list_by_search($city_id, $cat_id, $search_term,$field_list,$page) {//SEARCH!!!
		$start_limit=($page-1)*(int)CONF_PAGE_LIMIT;
		return $this->model->get_ad_list_by_search($city_id, $cat_id, $search_term,$field_list,$start_limit);
	}
	
	public function get_option_list_by_field_id($field_id) {										
		return $this->model->get_option_list_by_field_id($field_id);
	}
	
	public function get_ad($ad_id) {
		return $this->model->dbSelect('ad','id',$ad_id);		
	}		
	public function get_ad_by_id($ad_id) {
		return reset($this->model->dbSelect('ad','id',$ad_id));		
	}		
	public function get_ad_by_id_pp($ad_id) { //counter for ad views in here
		try {
			$this->model->dbBegin();
			$ad=reset($this->model->dbSelect('ad','id',$ad_id));		
			$counter=(int)$ad['counter']+1;
			$this->model->dbUpdate('ad', 'counter', $counter, 'id', $ad_id);			
			$this->model->dbCommit();
		}
		catch (Exception $e){
			$this->model->dbRollBack();
		}
		return $ad;
//		return reset($this->model->dbSelect('ad','id',$ad_id));		
		/*$result=$this->model->dbSelect('ad','id',$ad_id);
		if (count($result)==1) {
			return $result[0];
		}
		else {
			return null;		
		}*/
	}		
	
	public function get_photo_list ($ad_id) {
		return $this->model->get_photo_list($ad_id);		
	}
	
	public function get_value_list ($ad_id) {
		return $this->model->get_value_list($ad_id);		
	}
	
	public function get_category($cat_id) {
		return $this->model->dbSelect('category','id',$cat_id);		
	}	
	
	
	//UPDATE
	public function insert_new_ad ($values,$photo,$field_list) {
		try {
			$code=$values[0]['code'];
			$email=$values[0]['user_id'];
			$subject=$values[0]['subject'];
			/*$next_id=$this->model->dbSelectNextId('ad','id');	
			//start TRANSACTION
			$this->model->dbBegin();		
			$values[0]['id']=$next_id;
			$this->model->dbInsert(''.SystemConsts::DB.'.ad', $values);
			*/
			$this->model->dbBegin();
			$ad_pk_list=$this->model->dbInsertAI('ad',$values);
			$next_id=reset($ad_pk_list);
			if (isset($photo['name'])&&(!empty($photo['name']))) {		
				//$photo_str=mysql_real_escape_string(file_get_contents($photo['tmp_name']));
				$photo_str=base64_encode(file_get_contents($photo['tmp_name']));
				// $photo_size = $security->secure($_FILES['imgschool']['size']);
				$photo_type = $photo['type'];
				$photo_size = $photo['size'];
				/*
				$next_photo_id=$this->model->dbSelectNextId('photo','id');
				$values = array(array('id'=>$next_photo_id,'photo'=>$photo_str,'type'=>$photo_type,'size'=>$photo_size));
				$this->model->dbInsert(''.SystemConsts::DB.'.photo', $values);
				*/
				$values = array(array('photo'=>$photo_str,'type'=>$photo_type,'size'=>$photo_size));
				$photo_pk_list=$this->model->dbInsertAI('photo', $values);
				$next_photo_id=reset($photo_pk_list);
				
				$values = array(array('ad_id'=>$next_id,'photo_id'=>$next_photo_id));
				$this->model->dbInsert(''.SystemConsts::DB.'.ad_photo', $values);
				
			}
			if (count($field_list)>0) {//do additional fields						
				$values=null;		
				$values=array();
				foreach ($field_list as $field) {		
					if (!empty($field['default'])) {
						$values_row = array('field_id'=>$field['id'], 'ad_id'=>$next_id,'value'=>$field['default']);			
						$values[]=$values_row;
					}
				}
				if (count($values)>0) {
					$this->model->dbInsert(''.SystemConsts::DB.'.value', $values);								
				}
			}
			//COMMIT TRANSACTION
			$this->model->dbCommit();
			//TODO send email
			$data=array('id'=>$next_id, 'code'=>$code,'user_id'=>$email,'subject'=>$subject);
			return $data;
		}
		catch(Exception $e) {
			//ROLLBACK TRANSACTION
			$this->model->dbRollBack();
			throw new Exception( $e->getMessage());
			//return null;
		}
	}
	public function insert_new_crawled_ad ($subject,$text,$city_id, $cat_id) {
		try {
			$this->model->dbBegin();		
			$next_id=$this->model->dbSelectNextId('ad','id');	
			//start TRANSACTION			
			$values=array(array('id'=>$next_id,'subject'=>$subject, 'location'=>'','text'=>$text,'city_id'=>$city_id,'user_id'=>MONSTER_EMAIL,'code'=>md5(uniqid(rand(), true)),'cat_id'=>$cat_id,'verified'=>'1')); 
			echo $this->model->dbInsert(''.SystemConsts::DB.'.ad', $values);
		//	echo $subject;
			//COMMIT TRANSACTION
			$this->model->dbCommit();			
		//	$this->model->dbRollBack();
			//return $data;
		}
		catch(Exception $e) {
			//ROLLBACK TRANSACTION
			$this->model->dbRollBack();
			throw new Exception( $e->getMessage());
			//return null;
		}
	}
	
	public function insert_new_flag ($values) {
		try {
			//$this->model->dbBegin(); //not innoDB
			$this->model->dbInsert(''.SystemConsts::DB.'.flag', $values);		
			//$this->model->dbCommit();
			return true;
		}
		catch (Exception $e) {
			//$this->model->dbRollBack();
			//throw new Exception( $e->getMessage());		
			return false;
		}
	}
	//DELETE
	public function delete_ad($ad_id){		
		return $this->model->dbUpdate('ad', 'active', '0', 'id', $ad_id);	
	}
	public function verify_ad($ad_id){		
		return $this->model->dbUpdate('ad', 'verified', '1', 'id', $ad_id);		
	}
	
	public function save_ad ($ad_id,$value_list,$photo,$field_list,$photo_action) {
		try {							
			$this->model->dbBegin();		//start TRANSACTION
			foreach ($value_list as $k=>$v) {
				$this->model->dbUpdate('ad', $k, $v, 'id', $ad_id);
			}			
			switch ($photo_action) {
				case PHOTO_ACTION_KEEP:					
					break;
				case PHOTO_ACTION_DELETE:
					$this->model->delete_photo($ad_id);
					break;
				case PHOTO_ACTION_CHANGE:
					$this->model->update_photo($ad_id,$photo);
					break;
				case PHOTO_ACTION_NEW:
					if (isset($photo['name'])&&(!empty($photo['name']))) {		
						$photo_str=base64_encode(file_get_contents($photo['tmp_name']));
						$photo_type = $photo['type'];
						$photo_size = $photo['size'];
						$next_photo_id=$this->model->dbSelectNextId('photo','id');
						$values = array(array('id'=>$next_photo_id,'photo'=>$photo_str,'type'=>$photo_type,'size'=>$photo_size));
						$this->model->dbInsert('photo', $values);
						$values = array(array('ad_id'=>$ad_id,'photo_id'=>$next_photo_id));
						$this->model->dbInsert('ad_photo', $values);						
					}
					break;						
				default:
					break;
			}	

			if (count($field_list)>0) {//do additional fields						
				foreach ($field_list as $k=>$v) {		
					if (!empty($v['default'])) {
						$this->model->save_field_value($ad_id,$v['id'],$v['default']);
					}
					else {
						$this->model->remove_field_value($ad_id,$v['id']);
					}
				}
			}

			$this->model->dbCommit(); 			//COMMIT TRANSACTION			
			return true;
		}
		catch(Exception $e) {			//throw new Exception( $e->getMessage());
			//echo $e->getMessage();
			$this->model->dbRollBack();//ROLLBACK TRANSACTION			
			return false;
		}
	}	

}
?>