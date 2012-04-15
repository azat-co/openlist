<?php
	class crud{

		private $db;

		public function __set($name, $value)    {
			switch($name)        {
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

		public function __isset($name)    {
			switch($name)        {
				case 'username':
				$this->username = null;
				break;

				case 'password':
				$this->password = null;
				break;
			}
		}

        public function conn()        {			
            isset($this->username);			
            isset($this->password);
            if (!$this->db instanceof PDO)
            {
				//echo '*';
                $this->db = new PDO($this->dsn, $this->username, $this->password);
				//$db = new PDO('mysql:host=localhost; port=3306; dbname=something', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//PDO::ERRMODE_SILENT
            }
        }

        public function dbSelect($table, $fieldname=null, $id=null)        {
            $this->conn();
            $sql = "SELECT * FROM `$table` WHERE `$fieldname`=:id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function rawSelect($sql)    {
            $this->conn();
            return $this->db->query($sql);
        }

        public function rawQuery($sql)    {
            $this->conn();
            $this->db->query($sql);
        }

        public function dbInsert($table, $values)   {
            $this->conn();
            /*** snarg the field names from the first array member ***/
            $fieldnames = array_keys($values[0]);
            /*** now build the query ***/
            $size = sizeof($fieldnames);
            $i = 1;
            $sql = "INSERT INTO $table";
            /*** set the field names ***/
            $fields = '( ' . implode(' ,', $fieldnames) . ' )';
            /*** set the placeholders ***/
            $bound = '(:' . implode(', :', $fieldnames) . ' )';
            /*** put the query together ***/
            $sql .= $fields.' VALUES '.$bound;
            /*** prepare and execute ***/
            $stmt = $this->db->prepare($sql);
            foreach($values as $vals)
            {
                $stmt->execute($vals);
				//		echo '|'.$this->db->lastInsertId().'|';
            }
        }
		
		
        public function dbInsertAI($table, $values)   {//Auto Increment
            $this->conn();             /*** snarg the field names from the first array member ***/
            $fieldnames = array_keys($values[0]);             /*** now build the query ***/
            $size = sizeof($fieldnames);
            $i = 1;
            $sql = "INSERT INTO $table";             /*** set the field names ***/
            $fields = '( ' . implode(' ,', $fieldnames) . ' )';             /*** set the placeholders ***/
            $bound = '(:' . implode(', :', $fieldnames) . ' )';             /*** put the query together ***/
            $sql .= $fields.' VALUES '.$bound;             /*** prepare and execute ***/
            $stmt = $this->db->prepare($sql);
			$pk_list=array();
            foreach($values as $vals)
            {
                $stmt->execute($vals);
				$pk_list[]=$this->db->lastInsertId();
            }
			return $pk_list;
        }
		

        // public function dbUpdate($table, $fieldname, $value, $pk, $id)    {
            // $this->conn();
            // $sql = "UPDATE `$table` SET `$fieldname`='{$value}' WHERE `$pk` = :id";
            // $stmt = $this->db->prepare($sql);
            // $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            // $stmt->execute();
        // }
		
        public function dbUpdate($table, $fieldname, $value, $pk, $id)    {
            $this->conn();          
			$sql = "UPDATE `$table` SET `$fieldname`=:value WHERE `$pk` = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
			$stmt->bindParam(':value', $value, PDO::PARAM_STR);
            $stmt->execute();
        }
		
        public function dbDelete($table, $fieldname, $id)   {
            $this->conn();
            $sql = "DELETE FROM `$table` WHERE `$fieldname` = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
        }
		
		/*MY METHODS*/
        public function dbSelectNextId($table, $fieldname=null)   {
            $this->conn();
            $sql = "SELECT MAX(`$fieldname`) AS MAXID FROM `$table`";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$next_id=$result[0]['MAXID']+1;
            return $next_id;
        }		

		public function dbBegin() {
			return $this->db->beginTransaction();
		}
		
		public function dbRollBack() {
			return $this->db->rollBack();
		}
		
		public function dbCommit() {
			return $this->db->commit();
		}		
		
		public function foundRows()	{
			$rows = $this->db->prepare('SELECT found_rows() AS rows', array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => TRUE));
			$rows->execute();
			$rowsCount = $rows->fetch(PDO::FETCH_OBJ)->rows;
			$rows->closeCursor();
			return $rowsCount;
		}		
		
		public function get_category_list_with_ad_count($city_id) {			
            $this->conn();
			$sql='SELECT COUNT(parent.name)-1 AS lvl, node.id AS id, node.disp_name AS disp_name, node.name AS name, node.description as description, (SELECT COUNT(*) FROM ad WHERE cat_id IN (SELECT node2.id FROM category AS node2, category AS parent2 WHERE node2.lft BETWEEN parent2.lft AND parent2.rgt AND parent2.id=node.id AND parent2.active=1 AND node2.active=1 ) AND city_id=:city_id and verified=1 and active=1 AND DATEDIFF(CURDATE(),date)<:date_limit ORDER BY date DESC )as ad_count FROM category AS node, category AS parent WHERE node.lft BETWEEN parent.lft AND parent.rgt AND node.active=1 GROUP BY node.name ORDER BY  node.lft ASC';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':city_id', $city_id,PDO::PARAM_INT);
			$stmt->bindValue(':date_limit', (int)CONF_DATE_LIMIT,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);			
		}
		
		public function get_category_path($cat_id) {			
            $this->conn();
			$sql='SELECT parent.* FROM category AS parent, category AS node WHERE node.lft BETWEEN parent.lft AND parent.rgt AND node.id=:cat_id AND node.active=1 AND parent.active=1 ORDER BY parent.lft';			
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':cat_id', $cat_id,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);			
		}
		
		public function get_searchable_field_list($cat_id) {			
            $this->conn();
			$sql='SELECT A.* FROM field AS A, field_category AS B WHERE A.searchable=1 AND A.id=B.field_id AND B.cat_id=:cat_id AND A.active=1 ';			
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':cat_id', $cat_id,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);			
		}		
		public function get_option_list_by_field_id($field_id) {			
            $this->conn();
			$sql='SELECT id, disp_name FROM field_option WHERE field_id=:field_id AND active=1 ORDER BY priority ASC';			
			$stmt = $this->db->prepare($sql);
            $stmt->bindValue(':field_id', $field_id,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);			
		}		
		public function get_all_field_list($cat_id) {			
            $this->conn();
			$sql='SELECT field.* FROM field, field_category WHERE field.id=field_category.field_id AND field_category.cat_id=:cat_id AND field.active=1 ';		        
			$stmt = $this->db->prepare($sql);
            $stmt->bindValue(':cat_id', $cat_id,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);			
		}	
		
		public function get_ad_list($city_id,$cat_id,$start_limit) {			
            $this->conn();
			$sql='SELECT SQL_CALC_FOUND_ROWS id, subject, date,location,city_id,  EXISTS (SELECT photo_id FROM ad_photo WHERE ad_id=id) AS has_photo, (SELECT name FROM category WHERE id=cat_id) AS cat_name,(SELECT disp_name FROM category WHERE id=cat_id) AS cat_disp_name, cat_id AS cat_id,(SELECT name FROM city WHERE id=city_id) AS city_name FROM ad WHERE cat_id IN (SELECT node.id FROM category AS node, category AS parent WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.id=:cat_id AND parent.active=1 AND node.active=1 ) AND city_id=:city_id and verified=1 and active=1 AND DATEDIFF(CURDATE(),date)<:date_limit ORDER BY date DESC LIMIT :start_limit, :page_limit ';			
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(':city_id', $city_id,PDO::PARAM_INT);
            $stmt->bindValue(':cat_id', $cat_id,PDO::PARAM_INT);            
			$stmt->bindValue(':start_limit', $start_limit,PDO::PARAM_INT);
            $stmt->bindValue(':page_limit', (int)CONF_PAGE_LIMIT,PDO::PARAM_INT);
			$stmt->bindValue(':date_limit', (int)CONF_DATE_LIMIT,PDO::PARAM_INT);
            $stmt->execute();
            return array($stmt->fetchAll(PDO::FETCH_ASSOC),$this->foundRows());
				
		}		
				
		public function get_ad_list_for_rss($city_id,$cat_id) {			
            $this->conn();			
			$sql='SELECT id, subject, date,location,city_id, text, EXISTS (SELECT photo_id FROM ad_photo WHERE ad_id=id) AS has_photo, (SELECT name FROM category WHERE id=cat_id) AS cat_name,(SELECT disp_name FROM category WHERE id=cat_id) AS cat_disp_name, cat_id AS cat_id,(SELECT name FROM city WHERE id=city_id) AS city_name FROM ad WHERE cat_id IN (SELECT node.id FROM category AS node, category AS parent WHERE node.lft BETWEEN parent.lft AND parent.rgt AND parent.id=:cat_id AND parent.active=1 AND node.active=1 ) AND city_id=:city_id and verified=1 and active=1 AND DATEDIFF(CURDATE(),date)<:date_limit ORDER BY date DESC ';
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(':city_id', $city_id,PDO::PARAM_INT);
            $stmt->bindValue(':cat_id', $cat_id,PDO::PARAM_INT);            
			$stmt->bindValue(':date_limit', (int)CONF_DATE_LIMIT,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);			
		}	
		public function get_ad_list_by_id_list($ad_id_list,$start_limit) {			
            $this->conn();
			$in=array_map(create_function('$k','return ":ad_id".$k." ";'),array_keys($ad_id_list));
			$sql='SELECT SQL_CALC_FOUND_ROWS id, subject, date,location, EXISTS (SELECT photo_id FROM ad_photo WHERE ad_id=id) AS has_photo,(SELECT disp_name FROM category WHERE id=cat_id) AS cat_disp_name, cat_id AS cat_id,(SELECT name FROM category WHERE id=cat_id) AS cat_name,(SELECT name FROM city WHERE id=city_id) AS city_name,(SELECT disp_name FROM city WHERE id=city_id) AS city_disp_name, city_id AS city_id FROM ad WHERE id IN ('.implode(', ',$in).') and verified=1 and active=1  AND DATEDIFF(CURDATE(),date)<:date_limit ORDER BY date DESC LIMIT :start_limit, :page_limit';			
			$stmt = $this->db->prepare($sql);
			foreach ($ad_id_list as $k=>$v) {
				$stmt->bindValue(':ad_id'.$k, $v,PDO::PARAM_INT);
			}
			$stmt->bindValue(':start_limit', $start_limit,PDO::PARAM_INT);
            $stmt->bindValue(':page_limit', (int)CONF_PAGE_LIMIT,PDO::PARAM_INT);
			$stmt->bindValue(':date_limit', (int)CONF_DATE_LIMIT,PDO::PARAM_INT);
            $stmt->execute();
            return array($stmt->fetchAll(PDO::FETCH_ASSOC),$this->foundRows());
				
		}		
		
		public function get_ad_list_by_search($city_id, $cat_id, $search_term,$field_list,$start_limit) {			
			if ($cat_id!=null) {
				$additional_criteria_sql='';
				$additional_criteria_sql.='SELECT ad_id FROM value WHERE ad_id IN (SELECT ad_id FROM value WHERE ';
				$additional_criteria=false;
				$params=array();
				if (is_array($field_list)) {
					foreach ($field_list as $k=>$v) {					
						switch ($v['type']) {
							case TYPE_NUMBER:
								if (isset($v['from'])&&ctype_digit($v['from'])&&$v['from']>=0) {
									$additional_criteria_sql.='  CAST(value AS UNSIGNED)>='.':field_list'.$k.'from'.' AND field_id='.':field_list'.$k.'field_id'.' ';
									$params[':field_list'.$k.'from']=$v['from'];
									$params[':field_list'.$k.'field_id']=$v['id'];
									$additional_criteria=true;						
								}
								if (isset($v['to'])&&ctype_digit($v['to'])&&$v['to']>=0) {
									if ($additional_criteria) {									
										$additional_criteria_sql.=' AND CAST(value AS UNSIGNED)<='.':field_list'.$k.'to'.' ';
										$params[':field_list'.$k.'to']=$v['to'];
									}
									else {
										$additional_criteria_sql.=' CAST(value AS UNSIGNED)<='.':field_list'.$k.'to'.' AND field_id='.':field_list'.$k.'field_id'.' ';
										$params[':field_list'.$k.'to']=$v['to'];
										$params[':field_list'.$k.'field_id']=$v['id'];
										$additional_criteria=true;
									}						
								}
								if ($additional_criteria) {		
									$additional_criteria_sql.=' ) ';
								}
								break;
							case TYPE_SELECT:
								if (isset($v['default'])&&ctype_digit($v['default'])&&$v['default']>=0) {
									if ($additional_criteria) {									
										$additional_criteria_sql.=' AND ad_id IN (SELECT ad_id FROM value WHERE value='.':field_list'.$k.'default'.' AND field_id='.':field_list'.$k.'field_id'.' ';
										$params[':field_list'.$k.'default']=$v['default'];
										$params[':field_list'.$k.'field_id']=$v['id'];
									}
									else {
										$additional_criteria_sql.=' value='.':field_list'.$k.'default'.' AND field_id='.':field_list'.$k.'field_id'.' ';
										$params[':field_list'.$k.'default']=$v['default'];
										$params[':field_list'.$k.'field_id']=$v['id'];
										$additional_criteria=true;
									}						
									$additional_criteria_sql.=' ) ';
								}																					
								break;
							default:
								break;
						}
					}	
				}
			}

			$main_query='SELECT SQL_CALC_FOUND_ROWS  ad.*, EXISTS (SELECT photo_id FROM ad_photo WHERE ad_id=id) AS has_photo,(SELECT name FROM city WHERE id=city_id) AS city_name, (SELECT name FROM category WHERE id=cat_id) AS cat_name,(SELECT disp_name FROM category WHERE id=cat_id) AS cat_disp_name FROM ad WHERE (id LIKE :search_term OR UCASE(subject) LIKE :search_term OR UCASE(location) LIKE :search_term OR UCASE(text) LIKE :search_term ) and active=1 and city_id=:city_id '; //NESTED NODEs rules!
			if ($cat_id!=null) {
				$main_query.=' AND cat_id IN (SELECT node.id FROM category AS parent, category AS node WHERE parent.id=:cat_id AND node.lft BETWEEN parent.lft AND parent.rgt ) '; 
				if ($additional_criteria) {
					$main_query.=' AND id IN ('.$additional_criteria_sql.') '; 
				}
			}			
			$main_query.=' AND verified=1 AND active=1 AND DATEDIFF(CURDATE(),ad.date)<:date_limit ORDER BY ad.date DESC LIMIT :start_limit, :page_limit';	
					
			$this->conn();
			$sql=$main_query;
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(':search_term', '%'.$search_term.'%',PDO::PARAM_STR);
			$stmt->bindValue(':city_id', $city_id,PDO::PARAM_INT);
			if ($cat_id!=null) {
				$stmt->bindValue(':cat_id', $cat_id,PDO::PARAM_INT);
				if ($additional_criteria) {	
					foreach ($params as $k=>$v){
						$stmt->bindValue($k, $v,PDO::PARAM_INT);
					}
					// foreach ($field_list as $k=>$v) {					
						// switch ($v['type']) {
							// case TYPE_NUMBER:
								// if (isset($v['from'])&&ctype_digit($v['from'])&&$v['from']>=0) {
									// $stmt->bindValue(':field_list'.$k.'from', $v['from'],PDO::PARAM_INT);
								// }
								// if (isset($v['to'])&&ctype_digit($v['to'])&&$v['to']>=0) {						
									// $stmt->bindValue(':field_list'.$k.'to', $v['to'],PDO::PARAM_INT);
								// }
								// if ((isset($v['from'])&&ctype_digit($v['from'])&&$v['from']>=0)||(isset($v['to'])&&ctype_digit($v['to'])&&$v['to']>=0)) {
									// $stmt->bindValue(':field_list'.$k.'field_id', $v['id'],PDO::PARAM_INT);
								// }																							
								// break;
							// case TYPE_SELECT:
								// if (isset($v['default'])&&ctype_digit($v['default'])&&$v['default']>=0) {
									// $stmt->bindValue(':field_list'.$k.'default', $v['default'],PDO::PARAM_INT);
									// $stmt->bindValue(':field_list'.$k.'field_id', $v['id'],PDO::PARAM_INT);												
								// }																					
								// break;
							// default:
								// break;
						// }
					// }
				}
			}						
			$stmt->bindValue(':start_limit', $start_limit,PDO::PARAM_INT);
            $stmt->bindValue(':page_limit', (int)CONF_PAGE_LIMIT,PDO::PARAM_INT);
			$stmt->bindValue(':date_limit', (int)CONF_DATE_LIMIT,PDO::PARAM_INT);
            $stmt->execute();
            return array($stmt->fetchAll(PDO::FETCH_ASSOC),$this->foundRows());
		}	
		
		public function get_photo_list($ad_id) {			
            $this->conn();
			$sql='SELECT photo_id FROM ad_photo WHERE ad_id=:ad_id';		
			$stmt = $this->db->prepare($sql);
            $stmt->bindValue(':ad_id', $ad_id,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);			
		}	
		
		public function get_value_list ($ad_id) {			
			$this->conn();
			$sql='SELECT value.field_id, value.ad_id,(CASE WHEN field.type="'.TYPE_SELECT.'" THEN (SELECT field_option.disp_name FROM field_option WHERE field_option.id=value.value AND field_option.field_id=field.id) ELSE 0  END ) as selvalue, value.value as value, field.type AS type, field.disp_name AS disp_name, field.name AS name FROM value, field WHERE value.field_id =field.id AND field.active=1 AND value.ad_id=:ad_id ';		        
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(':ad_id', $ad_id,PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);			
		}	
		
		public function save_field_value($ad_id,$field_id,$value) {
            $this->conn();
            //$sql = 'UPDATE value SET value=:value WHERE ad_id=:ad_id AND field_id=:field_id';
			$sql='INSERT value (ad_id,field_id,value) VALUES (:ad_id,:field_id,:value) ON DUPLICATE KEY UPDATE value=VALUES(value)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':ad_id', $ad_id, PDO::PARAM_INT);
            $stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
            $stmt->bindValue(':value', $value, PDO::PARAM_STR);
            $stmt->execute();		
		}
		
		public function remove_field_value($ad_id,$field_id) {
            $this->conn();
            $sql = 'DELETE FROM value WHERE ad_id = :ad_id AND field_id=:field_id ';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':ad_id', $ad_id, PDO::PARAM_INT);
            $stmt->bindValue(':field_id', $field_id, PDO::PARAM_INT);
            $stmt->execute();			
		}
		
		public function update_photo($ad_id,$photo) {
            $this->conn();
			$sql='UPDATE photo, ad_photo SET photo.photo=:photo_data, photo.type=:photo_type, photo.size=:photo_size WHERE photo.id=ad_photo.photo_id AND ad_photo.ad_id=:ad_id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':ad_id', $ad_id, PDO::PARAM_INT);
            $stmt->bindValue(':photo_data', base64_encode(file_get_contents($photo['tmp_name'])), PDO::PARAM_STR);// PDO::PARAM_LOB
            $stmt->bindValue(':photo_type', $photo['type'], PDO::PARAM_STR);
            $stmt->bindValue(':photo_size',$photo['size'], PDO::PARAM_INT);
            $stmt->execute();		
		}
		
		public function delete_photo($ad_id) {
            $this->conn();
            $sql = 'DELETE photo,ad_photo FROM photo, ad_photo WHERE photo.id=ad_photo.photo_id AND ad_photo.ad_id = :ad_id ';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':ad_id', $ad_id, PDO::PARAM_INT);
            $stmt->execute();			
		}		


	} 
?>