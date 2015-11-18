<?php

$task = TaskData::getById($_GET["task_id"]);
$task->is_done = isset($_GET["is_done"])?1:0;
$task->done();

?>