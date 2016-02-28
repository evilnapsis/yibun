<?php 
$reservation = NoteData::getById($_GET["id"]);
$pacients = ProjectData::getAll();
$medics = CategoryData::getAll();
?>
  <script src="res/tinymce/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
<div class="row">
	<div class="col-md-10">
	<h4>Editar Nota</h4>
	<br>
<form class="form-horizontal" role="form" method="post" action="./?action=updatenote">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Titulo</label>
    <div class="col-lg-10">
      <input type="text" name="title" value="<?php echo $reservation->title; ?>" required class="form-control" id="inputEmail1" placeholder="Titulo">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Descripcion</label>
    <div class="col-lg-10">
    <textarea class="form-control" rows="15" name="description" placeholder="Descripcion"><?php echo $reservation->description;?></textarea>
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Proyecto</label>
    <div class="col-lg-4">
<select name="project_id" class="form-control">
<option value="">-- SELECCIONE --</option>
  <?php foreach($pacients as $p):?>
    <option value="<?php echo $p->id; ?>" <?php if($p->id==$reservation->project_id){ echo "selected"; }?>><?php echo $p->name; ?></option>
  <?php endforeach; ?>
</select>
    </div>
    <label for="inputEmail1" class="col-lg-2 control-label">Categoria</label>
    <div class="col-lg-4">
<select name="category_id" class="form-control">
<option value="">-- SELECCIONE --</option>
  <?php foreach($medics as $p):?>
    <option value="<?php echo $p->id; ?>" <?php if($p->id==$reservation->category_id){ echo "selected"; }?>><?php echo $p->name; ?></option>
  <?php endforeach; ?>
</select>
    </div>

  </div>
  <div class="form-group">
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="id" value="<?php echo $reservation->id; ?>">
      <button type="submit" class="btn btn-default">Actualizar Nota</button>
    </div>
  </div>
</form>

	</div>
</div>