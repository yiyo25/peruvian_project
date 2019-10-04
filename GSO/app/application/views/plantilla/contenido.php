<div id="contenido">
<? phpinfo();?>
	<table align="center" border=1>
		<tr>
			<td> Id Curso </td>
			<td>Nombre Curso</td>
			<td>Curso Vigencia</td>
			<td>Estado</td>
		</tr>
		<? foreach ($cursos as $lista):?>
		<tr>
			<td><?= $lista->id_curso?></td>
			<td><?= $lista->nombre_curso?></td>
			<td><?= $lista->curso_vigencia?></td>
			<td><?= $lista->estado?></td>
		</tr>
		<? endforeach?>
   </table>
</div>