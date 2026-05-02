<?php
$opt = $_GET["opt"] ?? "all";
$projects = ProjectData::getAll();
$categories = CategoryData::getAll();
?>

<?php if($opt=="all"):
$notes = NoteData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Notas</h1>
                <p class="text-muted mb-0">Gestiona tus apuntes y recordatorios</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newNoteModal">
                    <i class="bi bi-plus-lg me-1"></i> Nueva Nota
                </button>
            </div>
        </div>

        <?php if(count($notes)>0): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Título</th>
                                <th>Proyecto</th>
                                <th>Categoría</th>
                                <th>Fecha</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($notes as $n): 
                                $p = $n->getProject();
                                $c = $n->getCategory();
                            ?>
                            <tr>
                                <td class="ps-4 fw-bold text-indigo-900"><?php echo $n->title; ?></td>
                                <td><span class="badge bg-light text-dark fw-normal"><?php echo $p ? $p->name : "Ninguno"; ?></span></td>
                                <td><span class="badge bg-secondary fw-normal"><?php echo $c ? $c->name : "General"; ?></span></td>
                                <td class="small text-muted"><?php echo $n->created_at; ?></td>
                                <td class="pe-4 text-end">
                                    <a href="./?view=notes&opt=edit&id=<?php echo $n->id; ?>" class="btn btn-light btn-sm"><i class="bi bi-pencil"></i></a>
                                    <button class="btn btn-light btn-sm text-danger" onclick="delNote(<?php echo $n->id; ?>)"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="avatar avatar-xl bg-light text-muted mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px;">
                        <i class="bi bi-journal-x fs-1"></i>
                    </div>
                    <h4 class="fw-bold">No hay notas</h4>
                    <p class="text-muted">Parece que aún no tienes notas registradas. ¡Crea tu primera nota ahora!</p>
                    <button class="btn btn-indigo fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newNoteModal">
                        <i class="bi bi-plus-lg me-1"></i> Agregar Nota
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: New Note -->
<div class="modal fade" id="newNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nueva Nota</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-note-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Título *</label>
                            <input type="text" name="title" class="form-control" required placeholder="Título de la nota">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Proyecto</label>
                            <select name="project_id" class="form-select">
                                <option value="NULL">-- NINGUNO --</option>
                                <?php foreach($projects as $p): ?>
                                    <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Categoría</label>
                            <select name="category_id" class="form-select">
                                <option value="NULL">-- GENERAL --</option>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Contenido de la nota..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Guardar Nota</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-note-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=notes&opt=add', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){ window.location.reload(); }
    });
}

function delNote(id){
    if(confirm("¿Estás seguro?")){
        fetch('index.php?action=notes&opt=del&id='+id)
        .then(res => res.text())
        .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
    }
}
</script>

<?php elseif($opt=="edit"): 
$n = NoteData::getById($_GET["id"]);
?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Editar Nota</h1>
                <p class="text-muted mb-0">Actualiza la información de tu nota</p>
            </div>
            <div class="ms-auto">
                <a href="./?view=notes&opt=all" class="btn btn-light fw-bold px-4">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <form id="update-note-form">
                <input type="hidden" name="id" value="<?php echo $n->id; ?>">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Título *</label>
                            <input type="text" name="title" class="form-control" required value="<?php echo $n->title; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Proyecto</label>
                            <select name="project_id" class="form-select">
                                <option value="NULL">-- NINGUNO --</option>
                                <?php foreach($projects as $p): ?>
                                    <option value="<?php echo $p->id; ?>" <?php if($p->id==$n->project_id){ echo "selected"; } ?>><?php echo $p->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Categoría</label>
                            <select name="category_id" class="form-select">
                                <option value="NULL">-- GENERAL --</option>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?php echo $c->id; ?>" <?php if($c->id==$n->category_id){ echo "selected"; } ?>><?php echo $c->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea name="description" class="form-control" rows="8"><?php echo $n->description; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Actualizar Nota</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('update-note-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=notes&opt=update', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({ icon: 'success', title: '¡Actualizado!', timer: 1000, showConfirmButton: false })
            .then(() => { window.location.href = "./?view=notes&opt=all"; });
        }
    });
}
</script>
<?php endif; ?>
