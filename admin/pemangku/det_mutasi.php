<?php
include_once("../../php/include_all.php");

$idpns = $_GET['id_pns'];

$per = get_data("select p.id_pns, p.kode_jabatan, p.nama, p.nip, j.nama_jabatan, p.alamat, p.notelp, p.tempat_lahir, p.tanggal_lahir, p.id_golongan from skp_pns p, skp_jabatan j where j.kode_jabatan=p.kode_jabatan and p.id_pns=".$idpns);

          

echo "<table class='table-mut'>
		<tr>
			<td>Nama</td><td>:</td><td>".$per['nama']."</td>
		</tr>
		<tr>
			<td>NIP</td><td>:</td><td>".$per['nip']."</td>
		</tr>
		<tr>
			<td>Jabatan</td><td>:</td><td>".$per['nama_jabatan']."</td>
		</tr>
		<tr>
			<td>Alamat</td><td>:</td><td>".$per['alamat']."</td>
		</tr>
		<tr>
			<td>No Telepon</td><td>:</td><td>".$per['notelp']."</td>
		</tr>
		<tr>
			<td>Tempat Lahir</td><td>:</td><td>".$per['tempat_lahir']."</td>
		</tr>
		<tr>
			<td>Tanggal Lahir</td><td>:</td><td>".$per['tanggal_lahir']."</td>
		</tr>";
	
		if($per['id_golongan']!=null){
			$gol = get_data("select keterangan, nama_golongan from skp_golongan where id_gol=".$per['id_golongan']);
			echo "<tr>
				<td>Golongan</td><td>:</td><td>".$gol['nama_golongan']."</td><td>".$gol['keterangan']."</td>
			</tr>";
		}else {
			echo "<td>Golongan</td><td>:</td><td></td>";
		
		}
		
 echo "	
	
	</table>
	<form id='mutasi'>
	<table class='mut'>
		 <input type='hidden' name='act' value='input_mutasi'>
		 <input type='hidden' id='kode_jabAwl' name='kode_jabAwl' value='".$per['kode_jabatan']."'>
		 <input type='hidden' id='id_pns' name='id_pns' value='$idpns'>
		<tr><td><b>Mutasi</b></td><td></b>:</b></td></tr>
		<tr>
			<td><select name='mut' id='mut' onchange='mutasiskpd()' onclick='mutasiskpd()'>
                            	<option >-Pilih SKPD-</option>";
                         
                                $gol = get_datas ("select * from skp_skpd where nama not like '%admin%' order by id ");
								foreach ($gol as $gol){
								 echo "
                                <option value=".$gol['id'].">". $gol['nama']."</option>";
                                
								}
								 echo "
                            </select></td>
			<td><select name='jabb' id='jabb'>
					 <option value='0' id='jabatankos'> Tidak ada </option> 
			</select></td>
		</tr>
		</table>
	</form>
	<table align='right'>
                    <tr>
                        <td>
                            <a class='btn btn-primary btn-small btn-simpan-mutasi'><div id='loaderr'></div>&nbsp;Simpan</a><span id='result'></span>
                        </td>
                    </tr>
            </table>
	" ;         

?>
<script>
function mutasiskpd(){
	var skpd = $('#mut').val();
		source ="admin/pemangku/mutasi.php?code=jab&skpd="+skpd;
		var tes = $.get(source);
		tes.done(function(datas){
			$('#jabb').html(datas);
		});
}

 
</script>