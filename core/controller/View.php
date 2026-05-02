<?php


// 13 de Abril del 2014
// View.php
// @brief Una vista corresponde a cada componente visual dentro de un modulo.

class View {
	/**
	* @function load
	* @brief la funcion load carga una vista correspondiente a un modulo
	**/	
	public static function load($view){
		// Module::$module;
		if(!isset($_GET['view'])){
			include "core/app/view/".$view."-view.php";
		}else{

			if(View::isValid()){
				$can_view = true;
				if(isset($_SESSION["user_id"])) {
					$u = UserData::getById($_SESSION["user_id"]);
					// En Yibun original no hay permisos granulares, por ahora permitimos todo
				}

				if($can_view) {
					include "core/app/view/".$_GET['view']."-view.php";
				} else {
					View::Error("<div class='alert alert-danger fw-bold'><i class='bi bi-shield-lock me-2'></i> 403 ACCESO DENEGADO</div> <p class='text-muted small'>Su perfil no cuenta con permisos para ver este módulo.</p> <a href='./' class='btn btn-primary btn-sm'>Regresar al inicio</a>");
				}
			}else{
				View::Error("<b>404 NOT FOUND</b> View <b>".$_GET['view']."</b> folder !! - <a href='http://evilnapsis.com/legobox/help/' target='_blank'>Help</a>");
			}
		}
	}

	/**
	* @function isValid
	* @brief valida la existencia de una vista
	**/	
	public static function isValid(){
		$valid=false;
		if(isset($_GET["view"])){
			if(file_exists($file = "core/app/view/".$_GET['view']."-view.php")){
				$valid = true;
			}
		}
		return $valid;
	}

	public static function Error($message){
		print $message;
	}

}



?>