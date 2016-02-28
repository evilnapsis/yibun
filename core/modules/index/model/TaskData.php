<?php
class TaskData {
	public static $tablename = "task";

	public function TaskData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->category_id = "NULL";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function getProject(){ return ProjectData::getById($this->project_id); }
	public function getCategory(){ return CategoryData::getById($this->category_id); }

	public function add(){
		$sql = "insert into ".self::$tablename." (title,description,project_id,category_id,user_id,created_at) ";
		$sql .= "value (\"$this->title\",\"$this->description\",$this->project_id,$this->category_id,$this->user_id,$this->created_at)";
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

// partiendo de que ya tenemos creado un objecto TaskData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set title=\"$this->title\",project_id=$this->project_id,category_id=$this->category_id,description=\"$this->description\" where id=$this->id";
		Executor::doit($sql);
	}

	public function done(){
		$sql = "update ".self::$tablename." set is_done=\"$this->is_done\" where id=$this->id";
		Executor::doit($sql);
	}


	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new TaskData());
	}


	public static function getAll(){
		$sql = "select * from ".self::$tablename." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new TaskData());
	}

	public static function getAllByProjectId($id){
		$sql = "select * from ".self::$tablename." where project_id=$id order by date_at";
		$query = Executor::doit($sql);
		return Model::many($query[0],new TaskData());
	}


	public static function getBySQL($sql){
		$query = Executor::doit($sql);
		return Model::many($query[0],new TaskData());
	}
	
	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where title like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new TaskData());
	}


}

?>