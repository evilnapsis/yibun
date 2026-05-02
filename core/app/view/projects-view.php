<?php
$opt = $_GET["opt"] ?? "all";
?>

<?php if($opt=="all"):
$projects = ProjectData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Proyectos</h1>
                <p class="text-muted mb-0">Organiza tus metas y trabajos</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newProjectModal">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Proyecto
                </button>
            </div>
        </div>

        <?php if(count($projects)>0): ?>
        <div class="row g-4">
            <?php foreach($projects as $p): 
                $notes_count = count(NoteData::getAllByProjectId($p->id));
                $tasks_count = count(TaskData::getAllByProjectId($p->id));
            ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-3">
                                <i class="bi bi-kanban fs-4"></i>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" data-coreui-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item small fw-bold" href="./?view=projects&opt=edit&id=<?php echo $p->id; ?>"><i class="bi bi-pencil me-2 text-indigo-600"></i> Editar</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item small fw-bold text-danger" href="#" onclick="delProject(<?php echo $p->id; ?>)"><i class="bi bi-trash me-2"></i> Eliminar</a></li>
                                </ul>
                            </div>
                        </div>
                        <h5 class="fw-bold text-indigo-900 mb-2"><?php echo $p->name; ?></h5>
                        <p class="text-muted small mb-4"><?php echo $p->description ?: 'Sin descripción'; ?></p>
                        
                        <div class="d-flex gap-3">
                            <div class="small">
                                <span class="fw-bold text-indigo-600"><?php echo $notes_count; ?></span> <span class="text-muted">Notas</span>
                            </div>
                            <div class="small">
                                <span class="fw-bold text-emerald-600"><?php echo $tasks_count; ?></span> <span class="text-muted">Tareas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="avatar avatar-xl bg-light text-muted mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px;">
                        <i class="bi bi-kanban fs-1"></i>
                    </div>
                    <h4 class="fw-bold">No hay proyectos</h4>
                    <p class="text-muted">Comienza a organizar tu trabajo creando un proyecto.</p>
                    <button class="btn btn-indigo fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newProjectModal">
                        <i class="bi bi-plus-lg me-1"></i> Crear Proyecto
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: New Project -->
<div class="modal fade" id="newProjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nuevo Proyecto</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-project-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nombre del Proyecto *</label>
                            <input type="text" name="name" class="form-control" required placeholder="Nombre del proyecto">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="De qué trata este proyecto..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Crear Proyecto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-project-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=projects&opt=add', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
}

function delProject(id){
    if(confirm("¿Deseas eliminar este proyecto? Se perderán las asociaciones con notas y tareas.")){
        fetch('index.php?action=projects&opt=del&id='+id)
        .then(res => res.text())
        .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
    }
}
</script>

<?php elseif($opt=="edit"): 
$p = ProjectData::getById($_GET["id"]);
?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Editar Proyecto</h1>
                <p class="text-muted mb-0">Actualiza la información del proyecto</p>
            </div>
            <div class="ms-auto">
                <a href="./?view=projects&opt=all" class="btn btn-light fw-bold px-4">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <form id="update-project-form">
                <input type="hidden" name="id" value="<?php echo $p->id; ?>">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo $p->name; ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo $p->description; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Actualizar Proyecto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('update-project-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=projects&opt=update', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({ icon: 'success', title: '¡Actualizado!', timer: 1000, showConfirmButton: false })
            .then(() => { window.location.href = "./?view=projects&opt=all"; });
        }
    });
}
</script>
<?php endif; ?>
