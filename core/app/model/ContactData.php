<?php
class ContactData extends Extra {
	public static $tablename = "contact";

	public $id;
	public $name;
	public $lastname;
	public $email;
	public $address;
	public $phone;
	public $image;
	public $is_active;
	public $created_at;

	public function __construct(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->address = "";
		$this->phone = "";
		$this->image = "";
		$this->is_active = 1;
		$this->created_at = "NOW()";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (name,lastname,address,phone,email,image,is_active,created_at) ";
		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->address\",\"$this->phone\",\"$this->email\",\"$this->image\",$this->is_active,$this->created_at)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",lastname=\"$this->lastname\",address=\"$this->address\",phone=\"$this->phone\",email=\"$this->email\",image=\"$this->image\",is_active=$this->is_active where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		if($id==null || $id==""){ return null; }
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new ContactData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ContactData());
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%' or lastname like '%$q%' or email like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new ContactData());
	}
}
?>
