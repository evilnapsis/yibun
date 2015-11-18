<div class="row">
	<div class="col-md-12">
<a href="./?view=newnote" class="btn btn-default pull-right">Nueva Nota</a>
<h1>Notas</h1>

<form class="form-horizontal" role="form">
<input type="hidden" name="view" value="notes">
        <?php
$pacients = ProjectData::getAll();
$medics = CategoryData::getAll();
        ?>

  <div class="form-group">
    <div class="col-lg-3">
		<div class="input-group">
		  <span class="input-group-addon"><i class="fa fa-search"></i></span>
		  <input type="text" name="q" value="<?php if(isset($_GET["q"]) && $_GET["q"]!=""){ echo $_GET["q"]; } ?>" class="form-control" placeholder="Palabra clave">
		</div>
    </div>
    <div class="col-lg-3">
		<div class="input-group">
		  <span class="input-group-addon"><i class="fa fa-flask"></i></span>
<select name="project_id" class="form-control">
<option value="">PROYECTO</option>
  <?php foreach($pacients as $p):?>
    <option value="<?php echo $p->id; ?>" <?php if(isset($_GET["project_id"]) && $_GET["project_id"]!=""){ echo "selected"; } ?>><?php echo $p->name; ?></option>
  <?php endforeach; ?>
</select>
		</div>
    </div>
    <div class="col-lg-3">
		<div class="input-group">
		  <span class="input-group-addon"><i class="fa fa-th-list"></i></span>
<select name="category_id" class="form-control">
<option value="">CATEGORIA</option>
  <?php foreach($medics as $p):?>
    <option value="<?php echo $p->id; ?>" <?php if(isset($_GET["category_id"]) && $_GET["category_id"]!=""){ echo "selected"; } ?>><?php echo $p->name; ?></option>
  <?php endforeach; ?>
</select>
		</div>
    </div>

    <div class="col-lg-3">
    <button class="btn btn-primary btn-block">Buscar</button>
    </div>

  </div>
</form>

		<?php
$users= array();
if((isset($_GET["q"]) && isset($_GET["project_id"]) && isset($_GET["category_id"]) ) && ($_GET["q"]!="" || $_GET["project_id"]!="" || $_GET["category_id"]!="") ) {
$sql = "select * from event where ";
if($_GET["q"]!=""){
	$sql .= " title like '%$_GET[q]%' and description like '%$_GET[q] %' ";
}

if($_GET["project_id"]!=""){
if($_GET["q"]!=""){
	$sql .= " and ";
}
	$sql .= " project_id = ".$_GET["project_id"];
}

if($_GET["category_id"]!=""){
if($_GET["q"]!=""||$_GET["project_id"]!=""){
	$sql .= " and ";
}

	$sql .= " category_id = ".$_GET["category_id"];
}

		$users = NoteData::getBySQL($sql);

}else{
		$users = NoteData::getAll();

}
		if(count($users)>0){
			// si hay usuarios
			?>
			<table class="table table-bordered table-hover">
			<thead>
			<th>Titulo</th>
			<th>Proyecto</th>
			<th>Categoria</th>
			<th>Creacion</th>
			<th></th>
			</thead>
			<?php
			foreach($users as $user){
				$project = null;
				if($user->project_id!=null){
				$project  = $user->getProject();
				}
				$category = null;
				if($user->category_id!=null){
				$category = $user->getCategory();
				}
				?>
				<tr>
				<td><?php echo $user->title; ?></td>
				<td><?php if($project!=null ){ echo $project->name;} ?></td>
				<td><?php if($category!=null){ echo $category->name; }?></td>
				<td><?php echo $user->created_at; ?></td>
				<td style="width:130px;">
				<a href="index.php?view=editnote&id=<?php echo $user->id;?>" class="btn btn-warning btn-xs">Editar</a>
				<a href="index.php?action=delnote&id=<?php echo $user->id;?>" class="btn btn-danger btn-xs">Eliminar</a>
				</td>
				</tr>
				<?php

			}



		}else{
			echo "<p class='alert alert-danger'>No hay Notas</p>";
		}


		?>


	</div>
</div>