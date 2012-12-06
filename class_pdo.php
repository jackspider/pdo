<?php
/*
 * @author:jack
 * @date:2012-12-06
 * @desc :PHP 操作 pdo的类
*/
ini_set('display_errors',1);
class dbPdo{
	
	private $db;

	function __construct($dbType,$host,$dbName,$user,$password,$charset='utf8',$port=3306){
		$this->db = new PDO($dbType.':host='.$host.';dbname='.$dbName.';port='.$port.'', $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \''.$charset.'\'')); 

	}

	/*
	 * 往单表里面添加记录
	*/
	public function add($table,$data){
		$sql = null;
		foreach($data as $key=>$val){
			$sql .= $sql==null ? $key.'=\''.$val.'' : ' , '.$key.'=\''.$val.'' ;
		}
		return $this->db->exec("INSERT INTO $table $sql  ");
	}

	/*
	* 根据ID 查询一条记录
	*/
	public function getOne($table,$id,$field='id'){
		$rs = $this->db->query("SELECT * FROM ".$table."  WHERE $field=".$id);
		$rs->setFetchMode(PDO::FETCH_ASSOC);	
		return $rs->fetch();
	}

	/*
	 * 根据ID 删除一条记录
	*/
	public function delOne($table,$id,$field='id'){
		return $this->db->exec("DELETE FROM  $table where $field='$id' ");
	}

	/*
	 * 查询记录
	*/
	public function search($sql){
		$rs = $this->db->query($sql);
		$rs->setFetchMode(PDO::FETCH_ASSOC);	
		return $rs->fetchAll();
	}

}

header('Content-type:text/html;charset=utf-8');

$db = new dbPdo('mysql','localhost','phpcms_0715','root','123456',$charset='utf8',$port=3306);
$data = $db->search("SELECT * FROM v9_cxk_class limit 0,10 ");
print_R($data);

$dzdb = new dbPdo('mysql','localhost','dz_0715','root','123456',$charset='utf8',$port=3306);
$userData = $dzdb->search("SELECT * FROM pre_common_member order by uid desc limit 0,10 ");
print_R($userData);