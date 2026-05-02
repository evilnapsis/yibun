<?php
$opt = $_GET["opt"] ?? "all";
?>

<?php if($opt=="all"):
$categories = CategoryData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Categorías</h1>
                <p class="text-muted mb-0">Clasificación para tus notas, tareas y eventos</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newCategoryModal">
                    <i class="bi bi-tag me-1"></i> Nueva Categoría
                </button>
            </div>
        </div>

        <?php if(count($categories)>0): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Nombre</th>
                                <th>Descripción</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($categories as $c): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-indigo-900"><?php echo $c->name; ?></td>
                                <td class="small text-muted"><?php echo $c->description ?: 'Sin descripción'; ?></td>
                                <td class="pe-4 text-end">
                                    <a href="./?view=categories&opt=edit&id=<?php echo $c->id; ?>" class="btn btn-light btn-sm"><i class="bi bi-pencil"></i></a>
                                    <button class="btn btn-light btn-sm text-danger" onclick="delCategory(<?php echo $c->id; ?>)"><i class="bi bi-trash"></i></button>
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
                        <i class="bi bi-tag fs-1"></i>
                    </div>
                    <h4 class="fw-bold">No hay categorías</h4>
                    <p class="text-muted">Las categorías te ayudan a clasificar mejor tu información.</p>
                    <button class="btn btn-indigo fw-bold text-white px-4" data-coreui-toggle="modal" data-coreui-target="#newCategoryModal">
                        <i class="bi bi-plus-lg me-1"></i> Agregar Categoría
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal: New Category -->
<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nueva Categoría</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-category-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" class="form-control" required placeholder="Ej: Personal, Trabajo, Ideas...">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Opcional..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Guardar Categoría</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-category-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=categories&opt=add', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
}

function delCategory(id){
    if(confirm("¿Deseas eliminar esta categoría?")){
        fetch('index.php?action=categories&opt=del&id='+id)
        .then(res => res.text())
        .then(res => { if(res.trim() === "success"){ window.location.reload(); } });
    }
}
</script>

<?php elseif($opt=="edit"): 
$c = CategoryData::getById($_GET["id"]);
?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Editar Categoría</h1>
                <p class="text-muted mb-0">Actualiza la clasificación</p>
            </div>
            <div class="ms-auto">
                <a href="./?view=categories&opt=all" class="btn btn-light fw-bold px-4">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <form id="update-category-form">
                <input type="hidden" name="id" value="<?php echo $c->id; ?>">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" class="form-control" required value="<?php echo $c->name; ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo $c->description; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Actualizar Categoría</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('update-category-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    fetch('index.php?action=categories&opt=update', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({ icon: 'success', title: '¡Actualizado!', timer: 1000, showConfirmButton: false })
            .then(() => { window.location.href = "./?view=categories&opt=all"; });
        }
    });
}
</script>
<?php endif; ?>
