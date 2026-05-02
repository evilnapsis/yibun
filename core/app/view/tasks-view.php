<?php
$opt = $_GET["opt"] ?? "all";
$projects = ProjectData::getAll();
$categories = CategoryData::getAll();
?>

<?php if($opt=="all"):
$tasks = TaskData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Tareas</h1>
                <p class="text-muted mb-0">Listado de pendientes y actividades</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newTaskModal">
                    <i class="bi bi-plus-lg me-1"></i> Nueva Tarea
                </button>
            </div>
        </div>

        <?php if(count($tasks)>0): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4" style="width: 50px;"></th>
                                <th>Tarea</th>
                                <th>Proyecto</th>
                                <th>Categoría</th>
                                <th>Fecha</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($tasks as $t): 
                                $p = $t->getProject();
                                $c = $t->getCategory();
                            ?>
                            <tr class="<?php echo $t->is_done ? 'opacity-50 text-decoration-line-through' : ''; ?>">
                                <td class="ps-4">
                                    <input type="checkbox" class="form-check-input" <?php echo $t->is_done ? 'checked' : ''; ?> onclick="toggleTask(<?php echo $t->id; ?>, <?php echo $t->is_done ? 0 : 1; ?>)">
                                </td>
                                <td class="fw-bold text-indigo-900"><?php echo $t->title; ?></td>
                                <td><span class="badge bg-light text-dark fw-normal"><?php echo $p ? $p->name : "Ninguno"; ?></span></td>
                                <td><span class="badge bg-secondary fw-normal"><?php echo $c ? $c->name : "General"; ?></span></td>
                                <td class="small text-muted"><?php echo $t->created_at; ?></td>
                                <td class="pe-4 text-end">
                                    <a href="./?view=tasks&opt=edit&id=<?php echo $t->id; ?>" class="btn btn-light btn-sm"><i class="bi bi-pencil"></i></a>
                                    <button class="btn btn-light btn-sm text-danger" onclick="delTask(<?php echo $t->id; ?>)"><i class="bi bi-trash"></i></button>
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
                        <i class="bi bi-check2-square fs-1"></i>
                    </div>
                    <h4 class="fw-bold">No hay tareas</h4>
                    <p class="text-muted">No tienes tareas pendientes. ¡Agrega una nueva tarea para comenzar!</p>
                    <button class="btn btn-indigo fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newTaskModal">
                        <i class="bi bi-plus-lg me-1"></i> Agregar Tarea
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: New Task -->
<div class="modal fade" id="newTaskModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nueva Tarea</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-task-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">¿Qué hay que hacer? *</label>
                            <input type="text" name="title" class="form-control" required placeholder="Descripción corta">
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
                        <input type="hidden" name="description" value="">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Agregar Tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-task-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=tasks&opt=add', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
}

function toggleTask(id, done){
    fetch('index.php?action=tasks&opt=done&id='+id+'&is_done='+done)
    .then(res => res.text())
    .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
}

function delTask(id){
    if(confirm("¿Deseas eliminar esta tarea?")){
        fetch('index.php?action=tasks&opt=del&id='+id)
        .then(res => res.text())
        .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
    }
}
</script>

<?php elseif($opt=="edit"): 
$t = TaskData::getById($_GET["id"]);
?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Editar Tarea</h1>
                <p class="text-muted mb-0">Actualiza los detalles de la actividad</p>
            </div>
            <div class="ms-auto">
                <a href="./?view=tasks&opt=all" class="btn btn-light fw-bold px-4">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <form id="update-task-form">
                <input type="hidden" name="id" value="<?php echo $t->id; ?>">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción *</label>
                            <input type="text" name="title" class="form-control" required value="<?php echo $t->title; ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Proyecto</label>
                            <select name="project_id" class="form-select">
                                <option value="NULL">-- NINGUNO --</option>
                                <?php foreach($projects as $p): ?>
                                    <option value="<?php echo $p->id; ?>" <?php if($p->id==$t->project_id){ echo "selected"; } ?>><?php echo $p->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Categoría</label>
                            <select name="category_id" class="form-select">
                                <option value="NULL">-- GENERAL --</option>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?php echo $c->id; ?>" <?php if($c->id==$t->category_id){ echo "selected"; } ?>><?php echo $c->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Actualizar Tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('update-task-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=tasks&opt=update', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({ icon: 'success', title: '¡Actualizado!', timer: 1000, showConfirmButton: false })
            .then(() => { window.location.href = "./?view=tasks&opt=all"; });
        }
    });
}
</script>
<?php endif; ?>
