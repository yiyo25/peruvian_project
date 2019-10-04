<tr>
	<td width="20%">Nro. Vuelo:</td>
    <td width="20%">
    	<input type="text" id="nrovuelo<?php echo $id;?>" class="k-input k-textbox" value="<?php echo $numvuelo;?>" style="width:180px;" disabled="disabled" />
	</td>
    <td width="20%">Origen:</td>
    <td width="20%">
    	<input type="text" id="origen<?php echo $id;?>" class="k-input k-textbox" value="<?php echo $origen;?>" style="width:180px;" disabled="disabled" />
	</td>
    <td width="20%">Destino:</td>
    <td width="20%">
    	<input type="text" id="destino<?php echo $id;?>" class="k-input k-textbox" value="<?php echo $destino;?>" style="width:180px;" disabled="disabled"/>
	</td>
</tr>
<tr>
	<td width="20%">Hora Inicio:</td>
    <td width="20%">
    	<input type="text" id="hi<?php echo $id;?>" class="k-input k-textbox" value="<?php echo $horini;?>" style="width:180px;" <?php if($orden==1){ }else{ echo 'disabled="disabled"'; }?>/>
	</td>
    <td width="20%">Hora Final:</td>
    <td width="20%">
    	<input type="text" id="hf<?php echo $id;?>" class="k-input k-textbox" value="<?php echo $horfin;?>" style="width:180px;" disabled="disabled"/>
	</td>
    <td width="20%"></td>
</tr>
<script type="text/javascript">
	<?php	if($orden==1){?>
				masked('#hi<?php echo $id;?>','00:00',calculoHora);
				$('#hi<?php echo $id;?>').focus();
	<?php 	}?>
	function calculoHora(){
		var	id		=	<?php echo $id;?>;
		var interm	=	horasaminutos('00:30');
		var horas	=	new Array();
		for(ch=1;ch<=id-1;ch++){
			horas[ch]	=	horasaminutos($('#hf'+ch).val())-horasaminutos($('#hi'+ch).val());
		}
		var horaslength=	horas.length-1;
		for(ph=id;ph<=(id-1)*2;ph++){
			if(ph==id){
				$('#hf'+ph).val(minutosahoras(horasaminutos($('#hi'+ph).val())+horas[horaslength]));
			}else{
				idopc	=	ph-1;
				$('#hi'+ph).val(minutosahoras(horasaminutos($('#hf'+idopc).val())+interm));
				$('#hf'+ph).val(minutosahoras(horasaminutos($('#hi'+ph).val())+horas[horaslength]));
			}
			horaslength--;
		}
	}
	function horasaminutos(hora){
		vhora	=	hora.split(":");
		hhora	=	parseInt(vhora[0])*60;
		mhora	=	parseInt(vhora[1]);
		return	hhora+mhora;		
	}
	function minutosahoras(minutos){
		hhtotal	=	zerrofill(parseInt(minutos/60),2)
		mhtotal	=	zerrofill(minutos%60,2);
		return hhtotal+":"+mhtotal;
	}
	function zerrofill(str, max){
		str	=	str.toString();
		return str.length < max ? zerrofill("0" + str, max) : str;
	}
</script>