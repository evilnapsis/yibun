<?php
$notes = NoteData::getAll();
$tasks = TaskData::getAll();
$projects = ProjectData::getAll();
$events = EventData::getEvery();
?>
<div class="row mb-4">
  <div class="col-md-12">
    <div class="card border-0 shadow-sm bg-indigo-900 text-white p-4" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);">
      <div class="d-flex align-items-center">
        <div class="avatar avatar-xl bg-white bg-opacity-10 text-white me-4 rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 80px; height: 80px; backdrop-filter: blur(10px);">
          <i class="bi bi-rocket-takeoff fs-1"></i>
        </div>
        <div>
          <h1 class="h3 fw-bold mb-1">Bienvenido a <span class="text-indigo-400">Yibun</span></h1>
          <p class="mb-0 opacity-75">Tu sistema de gestión personal</p>
        </div>
        <div class="ms-auto d-none d-lg-block">
            <div class="bg-white bg-opacity-10 p-3 rounded-pill backdrop-blur">
                <span class="fw-bold"><i class="bi bi-clock me-2"></i> <?php echo date("d M, Y"); ?></span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Notas -->
  <div class="col-6 col-lg-3">
    <div class="card border-0 shadow-sm h-100 overflow-hidden">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="p-3 bg-indigo-100 text-indigo-600 rounded-3">
                <i class="bi bi-journal-text fs-4"></i>
            </div>
        </div>
        <div class="h2 fw-bold mb-1"><?php echo count($notes); ?></div>
        <div class="text-muted small fw-bold text-uppercase tracking-wider">Notas</div>
      </div>
    </div>
  </div>

  <!-- Tareas -->
  <div class="col-6 col-lg-3">
    <div class="card border-0 shadow-sm h-100 overflow-hidden">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="p-3 bg-emerald-100 text-emerald-600 rounded-3" style="background:#d1fae5; color:#059669">
                <i class="bi bi-check2-square fs-4"></i>
            </div>
        </div>
        <div class="h2 fw-bold mb-1"><?php echo count($tasks); ?></div>
        <div class="text-muted small fw-bold text-uppercase tracking-wider">Tareas</div>
      </div>
    </div>
  </div>

  <!-- Proyectos -->
  <div class="col-6 col-lg-3">
    <div class="card border-0 shadow-sm h-100 overflow-hidden">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="p-3 bg-amber-100 text-amber-600 rounded-3" style="background:#fef3c7; color:#d97706">
                <i class="bi bi-kanban fs-4"></i>
            </div>
        </div>
        <div class="h2 fw-bold mb-1"><?php echo count($projects); ?></div>
        <div class="text-muted small fw-bold text-uppercase tracking-wider">Proyectos</div>
      </div>
    </div>
  </div>

  <!-- Eventos -->
  <div class="col-6 col-lg-3">
    <div class="card border-0 shadow-sm h-100 overflow-hidden">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="p-3 bg-rose-100 text-rose-600 rounded-3" style="background:#ffe4e6; color:#e11d48">
                <i class="bi bi-calendar-event fs-4"></i>
            </div>
        </div>
        <div class="h2 fw-bold mb-1"><?php echo count($events); ?></div>
        <div class="text-muted small fw-bold text-uppercase tracking-wider">Eventos</div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4 g-4">
  <div class="col-md-8">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-white border-bottom-0 p-4 d-flex align-items-center">
        <h5 class="fw-bold mb-0">Notas Recientes</h5>
        <a href="./?view=notes" class="ms-auto btn btn-light btn-sm fw-bold">Ver Todas</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted small">
              <tr>
                <th class="ps-4">Título</th>
                <th>Proyecto</th>
                <th>Fecha</th>
                <th class="pe-4"></th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($notes)>0): ?>
                  <?php foreach(array_slice($notes, 0, 5) as $note): 
                      $p = $note->project_id != "NULL" ? $note->getProject() : null;
                  ?>
                  <tr>
                    <td class="ps-4 fw-bold"><?php echo $note->title; ?></td>
                    <td class="small"><?php echo $p ? $p->name : "N/A"; ?></td>
                    <td class="small text-muted"><?php echo $note->created_at; ?></td>
                    <td class="pe-4 text-end">
                        <a href="./?view=editnote&id=<?php echo $note->id; ?>" class="btn btn-light btn-sm"><i class="bi bi-pencil"></i></a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
              <?php else: ?>
                  <tr>
                    <td colspan="4" class="text-center py-5 text-muted italic">No hay notas registradas</td>
                  </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-header bg-white border-bottom-0 p-4">
        <h5 class="fw-bold mb-0">Tareas Pendientes</h5>
      </div>
      <div class="card-body p-0">
          <ul class="list-group list-group-flush">
              <?php 
              $pending_tasks = array_filter($tasks, function($t){ return !$t->is_done; });
              if(count($pending_tasks)>0): 
                  foreach(array_slice($pending_tasks, 0, 8) as $task):
              ?>
              <li class="list-group-item border-0 px-4 py-3 d-flex align-items-center">
                  <div class="me-3">
                      <i class="bi bi-circle text-muted"></i>
                  </div>
                  <div>
                      <div class="fw-bold small"><?php echo $task->title; ?></div>
                      <div class="text-muted" style="font-size: 11px;"><?php echo $task->created_at; ?></div>
                  </div>
              </li>
              <?php endforeach; else: ?>
              <li class="list-group-item border-0 px-4 py-5 text-center text-muted italic">
                  No hay tareas pendientes
              </li>
              <?php endif; ?>
          </ul>
      </div>
      <div class="card-footer bg-white border-top-0 p-4">
          <a href="./?view=tasks" class="btn btn-indigo w-100 fw-bold">Gestionar Tareas</a>
      </div>
    </div>
  </div>
</div>
