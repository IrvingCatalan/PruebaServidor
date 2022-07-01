<?php
require_once('../lib/Conexion.php');
include('../lib/Funciones.php');
include('../lib/Seguridad.php');

$Tabla['table'] = "EmpleadosPrueba";
$Tabla['columns'] = " '' /*/ Nombre /*/ ApellidoPaterno /*/ ApellidoMaterno /*/ CURP /*/ INE /*/ Telefono /*/ CorreoElectronico "; 
$Tabla['index'] = "id";
$Tabla['condition'] = "";
$Tabla['order'] = " id ASC ";
$Tabla['extra'][0] = "actions";
$Tabla['debug'] = 0;
$Privilegios = array("Leer" => 1, "Crear" => 1, "Actualizar" => 1, "Eliminar" => 1);
$Tabla['Privileges'] = $Privilegios;
$Datos = Encrypt(json_encode($Tabla), $_SESSION['CELA_Aleatorio']);
?>
<!DOCTYPE html>
<html lang="es">
	<?php include '../CELAHead.php'; ?>
	<body class="fixed-nav">
		<div id="wrapper">
			<?php include_once("../CELAMenuVertical.php"); ?>
			<div id="page-wrapper" class="gray-bg">
				<div class="row border-bottom">
					<?php
					include '../CELAMenuHorizontal.php';
					include '../CELAMensajeIndividual.php';
					?>
				</div>
				<div class="wrapper wrapper-content animated fadeInRight">
					<div class="row">
						<div class="col-lg-12">
							<div class="ibox float-e-margins">

								<div class="ibox-title">

									<!-- Titulo del Main -->
									<h5>Empleados Registrados</h5>

									<!-- Botones de Ayuda -->
									<div class="ibox-tools">
										<a class="collapse-link"> <i class="fa fa-chevron-up fa-lg"></i> </a>
										<a data-intro="Ayuda general" data-position="left" href="#" class="btn-help" title="Ayuda"> <i class="fa fa-question-circle fa-lg"></i> </a>
										<a class="close-link" onclick="window.history.back();" title="ir atr&aacute;s"> <i class="fa fa-times fa-lg"></i> </a>
									</div>

								</div>

								<div class="ibox-content">

									<!-- Mensaje de Alerta -->
									<?php
									if (isset($Privilegios['Leer']) && $Privilegios['Leer'] == 1) {
										if (isset($_GET['Status']) && $_GET['Status'] != "ErrorE") {
									?>
											<div class="alert alert-success fade in alert-msn" role="alert">
												<button class="close" data-dismiss="alert" type="button">
													<span aria-hidden="true">&times;</span>
													<span class="sr-only">Close</span>
												</button>
												<?php print ($_GET['Status'] == "SuccessC" ? '<strong><i class="fa fa-check fa-lg"></i>&nbsp; Se registro exitosamente!</strong>&nbsp; El nuevo elemento se registr&oacute; correctamente.' : '') . ($_GET['Status'] == "SuccessA" ? '<strong><i class="fa fa-check fa-lg"></i>&nbsp; Actualizaci&oacute;n exitosa!</strong>&nbsp; El elemento se actualiz&oacute; correctamente.' : '') . ($_GET['Status'] == "SuccessE" ? '<strong><i class="fa fa-check fa-lg"></i>&nbsp; Eliminaci&oacute;n correcta!</strong>&nbsp; El elemento se elimin&oacute;.' : '');
												?>
											</div>
									<?php
										}
										if (isset($_GET['Status']) && $_GET['Status'] == "ErrorE") {
										?>
											<div class="alert alert-danger fade in alert-msn" role="alert">
												<button class="close" data-dismiss="alert" type="button">
													<span aria-hidden="true">&times;</span>
													<span class="sr-only">Close</span>
												</button>
												<strong> <i class="fa fa-times fa-lg"></i>&nbsp; Error al eliminar el elemento:&nbsp; </strong>
												<?php print $_GET['Error']; ?>
											</div>
										<?php
										}
										?>

										<div class="row">
											<div class="col-md-12">

												<!-- Boton de Agregar -->
												<div class="col-md-2 text-left">
													<?php
													if (isset($Privilegios['Crear']) && $Privilegios['Crear'] == 1) {
													?>
														<a data-intro="Insertar nuevo elemento en esta tabla" data-position="bottom" class="btn btn btn-success" title="Agregar" href="EmpleadosPruebaCrear.php"> <i class="fa fa-plus"></i>&nbsp;<span>Agregar</span> </a>
													<?php
													}
													?>
												</div>
												
												<!-- Boton de Editar y Eliminar -->
												<div class="col-md-6 text-left form-inline">
													<?php
													$Label = false;
													if (isset($Privilegios['Actualizar']) && $Privilegios['Actualizar'] == 1) {
													?>
														<a data-intro="Modifica los elementos seleccionados" data-position="top" class="btn btn btn-warning" title="Editar seleccionados" href="#" disabled="disabled" id="Actualizar"> <i class="fa fa-pencil"></i>&nbsp;<span>Editar</span> </a>
													<?php
														$Label = true;
													}
													if (isset($Privilegios['Eliminar']) && $Privilegios['Eliminar'] == 1) {
													?>
														<a data-intro="Elimina todos los elementos seleccionados" data-position="right" title="Eliminar seleccionados" href="#" class="btn btn btn-danger delete" disabled="disabled" id="Eliminar"> <i class="fa fa-trash-o"></i>&nbsp; <span>Eliminar</span> </a>
													<?php
														$Label = true;
													}
													if ($Label == true) {
													?>
														<label>
															&larr; Para los datos seleccionados
														</label>
													<?php
													}
													?>
												</div>

												<!-- Buscador -->
												<div class="col-md-4 text-right">
													<div class="form-group" data-intro="B&uacute;squeda general en esta tabla" data-position="bottom">
														<label class="sr-only" for="Search-Table_CatalogoDocumentos"> Busqueda de empleado </label>
														<div>
															<input id="Search-Table_CatalogoDocumentos" class="form-control DataTableFilter" type="text" placeholder="Buscar..." autocomplete="off">
														</div>
													</div>
												</div>

											</div>
										</div>

										<!-- Tabla de Empleados -->
										<div class="row">
											<div class="table-responsive col-md-12" align="left">
												<table id="Table_CatalogoDocumentos" data-record_length="1000" class="table table-striped table-bordered table-hover datatable" data-records="<?php print $Datos; ?>" data-form="<?php print substr(strrchr($_SERVER['PHP_SELF'], "/"), 1); ?>" data-record_length="-1">
													<thead>
														<tr>
															<th width="2%" title="Seleccionar todos los elementos">
																<div align="center">
																	<label>
																		<input type="checkbox" id="All" data-intro="Selecciona todos los elementos de esta p&aacute;gina" data-position="right" />
																	</label>
																</div>
															</th>
															<!-- <th width="5%" class="sortable">
																<div align="center"> ID</div>
															</th> -->
															<th width="10%" class="sortable">
																<div align="center"> Nombre(s)</div>
															</th>
															<th width="10%" class="sortable">
																<div align="center">Apellido paterno</div>
															</th>
															<th width="10%" class="sortable">
																<div align="center">Apellido materno</div>
															</th>
															<th width="10%" class="sortable">
																<div align="center">CURP</div>
															</th>
															<th width="8%" class="sortable">
																<div align="center">INE</div>
															</th>
															<th width="8%" class="sortable">
																<div align="center">Tel&eacute;fono</div>
															</th>
															<th width="15%" class="sortable">
																<div align="center">Correo electr&oacute;nico</div>
															</th>
														</tr>
													</thead>
													<tbody></tbody>
												</table>
											</div>
										</div>

										<!-- Mostrar Mensaje de Modal de Eliminar -->
										<?php
										if (isset($Privilegios['Eliminar']) && $Privilegios['Eliminar'] == 1) {
										?>
											<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content modal-content-delete">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														</div>
														<div class="modal-body" id="Body"></div>
														<div class="modal-footer">
															<a class="btn btn-default" id="Cancelar" data-dismiss="modal"> Cancelar </a>
															<a class="btn btn-danger" id="Aceptar" href=""> <i class="fa fa-trash-o"></i>&nbsp;Eliminar </a>
														</div>
													</div>
												</div>
											</div>
									<?php
										}
									}
									?>
									
								</div>

							</div>
						</div>
					</div>
				</div>
				<?php include '../CELAPie.php'; ?>
			</div>
		</div>

    	<?php include '../CELAJavascript.php'; ?>
		<script>
        $(document).delegate(".delete", "click", function(e) {
			e.preventDefault();
			var mensaje = '';		
			$(".modal-content-delete").addClass('animated flipInY');
			if ($(this).attr("id") != "Eliminar") {
				mensaje = "&iquest;Realmente desea eliminar el elemento seleccionado?";
				$("#Aceptar").attr('href', $(this).attr('href'));
				//alert("Href: "+$(this).attr('href'));
			} else {
				mensaje = '&iquest;Realmente desea eliminar los elementos seleccionados?';
			}	
			$("#Body").html(mensaje);
			$("#DeleteModal").modal('show');
		});
			
		$('#DeleteModal').on('hide.bs.modal', function (e) {
			$(".modal-content").removeClass('animated');
			$(".modal-content").removeClass('flipInY');
		});
			
		$(document).delegate(".Select", "change", function() {
			GetAllSelect();
		});

		$("#All").change(function() {
			$(".Select").each(function() {
				$(this).prop('checked', $('#All').is(':checked'));
			});
			GetAllSelect();
		});

		function GetAllSelect() {
			var Get = '',
			cont = 0;
			$(".Select").each(function() {
				if ($(this).is(":checked")) {
					var id = $(this).attr("id");
					id = id.split("_");
					Get += 'clave[]=' + id[1] + '&';
					cont++;
				}
			});

			Get = Get.substring(0, Get.length - 1);
			if (Get != '') {
				$.post("../ajaxs_functions.php", {
					funcion : 5,
					Post : Get
				}, function(data) {
					if (cont < 2) {
						var href = "#";
						$("#Actualizar").attr('disabled', 'disabled');
						$("#Eliminar").attr('disabled', 'disabled');
						$("#Aceptar").attr('href', href);
					} else {
						$("#Actualizar").removeAttr('disabled');
						$("#Eliminar").removeAttr('disabled');
						$("#Actualizar").attr('href', 'EmpleadosPruebaAllActualizar.php?' + data);
						$("#Aceptar").attr('href', 'EmpleadosPruebaAllEliminar.php?' + data); //Se activa cuando se seleccionan las casillas
					}
				});
			} else {
				var href = "#";
				$("#Actualizar").attr('disabled', 'disabled');
				$("#Eliminar").attr('disabled', 'disabled');
				$("#Aceptar").attr('href', href);
			}	
		}
		</script>
	</body>
</html>
