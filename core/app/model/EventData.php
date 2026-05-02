<?php
class EventData extends Extra {
	public static $tablename = "event";

	public $id;
	public $title;
	public $description;
	public $date_at;
	public $time_at;
	public $category_id;
	public $user_id;
	public $project_id;
	public $created_at;

	public function __construct(){
		$this->title = "";
		$this->description = "";
		$this->date_at = "";
		$this->time_at = "";
		$this->category_id = "NULL";
		$this->project_id = "NULL";
		$this->created_at = "NOW()";
	}

	public function getProject(){ 
		if($this->project_id!="" && $this->project_id!="NULL"){ return ProjectData::getById($this->project_id); }
		return null;
	}
	public function getCategory(){ 
		if($this->category_id!="" && $this->category_id!="NULL"){ return CategoryData::getById($this->category_id); }
		return null;
	}
	public function getUser(){ return UserData::getById($this->user_id); }

	public function add(){
		$sql = "insert into ".self::$tablename." (title,description,project_id,date_at,time_at,category_id,user_id,created_at) ";
		$sql .= "value (\"$this->title\",\"$this->description\",$this->project_id,\"$this->date_at\",\"$this->time_at\",$this->category_id,$this->user_id,$this->created_at)";
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
		$sql = "update ".self::$tablename." set title=\"$this->title\",project_id=$this->project_id,category_id=$this->category_id,date_at=\"$this->date_at\",time_at=\"$this->time_at\",description=\"$this->description\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		if($id==null || $id==""){ return null; }
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new EventData());
	}

	public static function getEvery(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new EventData());
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." where date(date_at)>=date(NOW()) order by date_at";
		$query = Executor::doit($sql);
		return Model::many($query[0],new EventData());
	}

	public static function getAllByProjectId($id){
		$sql = "select * from ".self::$tablename." where project_id=$id order by date_at";
		$query = Executor::doit($sql);
		return Model::many($query[0],new EventData());
	}

	public static function getBySQL($sql){
		$query = Executor::doit($sql);
		return Model::many($query[0],new EventData());
	}

	public static function getOld(){
		$sql = "select * from ".self::$tablename." where date(date_at)<date(NOW()) order by date_at";
		$query = Executor::doit($sql);
		return Model::many($query[0],new EventData());
	}
	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where title like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new EventData());
	}
}
?>
