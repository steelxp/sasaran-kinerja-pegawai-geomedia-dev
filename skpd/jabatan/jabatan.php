<?php
session_start();
if (@$_POST['open'] != 'please') {
    exit;
}
include_once('../../php/include_all.php');
//include_once ('../../php/postgre.php');
?>
<div class="widget-header widget-header-flat ">
    <h5><i class="icon-calendar"></i>Daftar Jabatan</h5>
</div>
<div id="modalwin" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <header class="modal-header"> 
        <a href="#" class="close geo-clear" data-dismiss="modal">x</a>
        <h3>Input Jabatan</h3>
    </header>

    <div class="modal-body">
        <form id="formjabatan">
            <input type="hidden" name="act" value="jabatan_simpan">
            <input type="hidden" id="id" name="id" value="0"> 
			<input type="hidden" id="id_skpd" name="id_skpd" value="<? echo SKP_ID; ?>">
            <table class="table-form">
                <tbody>
                    <tr>
                        <td>Induk Jabatan</td>
                        <td>:</td>
                        <td>
                            <select  name="id_induk" id="id_induk" onchange="data()">
                                <option value="0" id="idindukk">-Pilih Induk-</option> 
                                <?php
                                $induk = get_datas ("select * from skp_jabatan where unit_kerja='".SKP_ID."' order by kode_jabatan");
								foreach ($induk as $induk){
								?>
                                <option value="<? echo $induk['idjab']?>"><? echo $induk['nama_jabatan']?></option>
                                <?php
                                }
								?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>
                            <select  name="id_jabatan" id="id_jabatan">
                                <option value="0" id='idjabatan'> pilih salah satu </option> 
                                <option value="Jabatan Struktural"> Jabatan Struktural </option> 
                                <option value="Jabatan Fungsional Umum"> Jabatan Fungsional Umum </option> 
                                <option value="Jabatan Fungsional Tertentu"> Jabatan Fungsional Tertentu</option> 
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Jabatan</td>
                        <td>:</td>
                        <td><div id="nmjab" name='nmjab'></div><td>
                        
                    </tr>
                    <tr>
                        <td>Kode Jabatan</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="kodejab" id="kodejab"  />
                        </td>
                    </tr>

                    <tr>
                        <td>Unit Organisasi</td>
                        <td>:</td>
                        <td><div id='unitOr' name="unitOr"></div></td><!--td id='eslon'></td-->
                    </tr>
				
			 	
                    <!--tr>
    <td>Ikhtisar Jabatan</td>
    <td>:</td>
    <td>
        <textarea class="input-xlarge" name="ikhtisar" id="ikhtisar"  />
    </td>
</tr!-->
			 
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <a class="btn btn-primary btn-small btn-simpan-jabatan "><div id="loader"></div>&nbsp;Simpan</a><span id="result"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
<div class="box-content">
    <table class="table table-bordered geo-table table-hover" width="100%">
        <thead>
            <tr>
                <th class="center" width="3%">No</th>
                <th class="center" width="12%">Kode Jabatan</th> 
                <th class="center" width="33%">Nama Jabatan</th>
                <th class="center" width="20%">Unit Organisasi</th>
            </tr>
        </thead>
        <tbody id="tampilJabatan">
        <?php 
		$no=1;
		$t_jab = get_datas ("select j.kode_jabatan, j.nama_jabatan, u.nama_unit from skp_jabatan j, skp_unit_eselon u where u.id_unit=j.unit_organisasi and j.unit_kerja=".SKP_ID." order by j.kode_jabatan");
		foreach ($t_jab as $jab){
		?>
        	<tr>
            	<td><?php echo $no;?></td>
                <td><?php echo $jab['kode_jabatan'];?></td>
                <td><?php echo $jab['nama_jabatan'];?></td>
                <td><?php echo $jab['nama_unit'];?></td>
            </tr>
        <?php
		$no++;
        }
		?>
        </tbody>
    </table>    
</div>
<script>
    var url = 'skpd/jabatan/save_jabatan.php';
    var rslt = $('#result'); 
	
   function data(){
		var skpd = $('#id_skpd').val();
		var kode = $('#id_induk').val();
	    var post = $.post(url,{act:'get_kode', kode:kode, skpdd:skpd});
        post.done(function(data){
            //$('#kodejab').html(data);
            document.getElementById('kodejab').value=data;
        });
	}	
	
	function emb(a){
		var rum = a;
		console.log(a);
		var post = $.post('skpd/jabatan/embel.php',{rum:rum});
		post.done(function(data){
			$('#embel').html(data);
		});
	}
	
    $('#id_jabatan').change(function(){
        var jabatan = $('#id_jabatan').val();
        var skp = $('#id_skpd').val();
        var td = $('#unitOr');  
		var namajab = $('#nmjab');
        if(jabatan == 'Jabatan Struktural'){
            td.html("<td><input type='hidden' name='id_unit' id='id_unit' value='0'><input type='text' name='unit' id='unit'  class='span3'/></td><td><select name='eslon' id='eslon' class=span2><option value='0'>Pilih Golongan</option><option value='IIB'>IIB</option><option value='IIIA'>IIIA</option><option value='IIIB'>IIIB</option><option value='IVA'>IVA</option><option value=IVB>IVB</option></select></td>");
			namajab.html("<input type='text' name='nama' id='nama'  />");
        }else{
            var post = $.post(url,{act :'rlJabatan', skp : skp});
            post.done(function(rse){
				var data = rse.split('__');
                td.html(data[0]); 
				namajab.html(data[1]);
            });            
        }
	});
	
    $('.btn-simpan-jabatan').click(function(){      
        var btn = $(this);
        var load = $('#loader');
        load.addClass('icon-spinner icon-spin icon-2x white');
        
        var form = $('#formjabatan');
        var data = form.serializeArray();
        var post = $.post(url,data);
        post.done(function(res){
			var result = res.split('__');
            if(result.length==3){
                if(result[0]=='success'){
                    rslt.html('<font color="green">data tersimpan </font>');
                    setTimeout(function(){
                        rslt.html('');
                    }, 1500);
					
					
                
                    var tbody = $('#tampilJabatan');
                    tbody.html(result[2]);
					init();
                    $("#id").val("0");
					document.getElementById('id_induk').value='0';
					document.getElementById('kodejab').value='';
					document.getElementById('id_jabatan').value='0'; 
					$('#nmjab').html('');
					$('#unitOr').html('');     
					load.removeClass('icon-spinner icon-spin icon-2x white');         
					$('#modalwin').modal('hide');
                }else{
                    rslt.html('<font color="red">'+res+'</font>');
                }
            }else{
                rslt.html('<font color="red">'+res+'</font>');
            }
            
            btn.removeClass('btn-info').addClass('btn-primary');
           
        });
    
    });
	
	$('.btn-tambah').click(function(){
		var skpd = $('#skpd').val();
		var tulis = $('td#tulisan');
		$(this).attr('href','0');
		if(skpd == 0){
			tulis.html("<font color='red'>Pilih SKPD terlebih dahulu</font>");	
		}else{ 
			tulis.html(" ");
			$(this).attr('href','#modalwin');
			$('#id').val('0');
			var idinduk = $('#id_skpd').val();
			var post = $.post(url,{act:'get_induk',idindukk:idinduk});
				post.done(function(data){
					$('#id_induk').html(data);
				});
			document.getElementById('nama').value='';
			document.getElementById('kodejab').value='';
			document.getElementById('idjabatan').selected=true;
		}

	});
    
	
	
    function init(){
        $('.bt-edit-jabatan').click(function(){
			var id = this.name;
            var form = $('#formjabatan');
            var post = $.post(url,{act:'ubah_jabatan',id:id});            
            post.done(function(res){
                var value = res.split('__');
                $('#id').val(value[0]);
                $('#nmjab').html(value[8]);
				form.find('select[name="embel"]').val(value[10]);
				form.find('select[name="rumpun"]').val(value[9]);
                form.find('input[name="kodejab"]').val(value[2]);
				form.find('select[name="id_induk"]').val(value[3]);
				form.find('select[name="id_skpd"]').val(value[4]);
				form.find('select[name="id_jabatan"]').val(value[6]);
				$("#unitOr").html(value[7]);
				/*if (value[6]=='Jabatan Fungsional Umum'){
					form.find('select[name="unitorgnisasi"]').val(value[5]);
					alert(value[5]);
				}*/
				//alert(value[7]);
			 });
        });
        
        $('.bt-hapus-jabatan').click(function(){
			var btn = $(this);
            var pid = this.name;
            var load = $(this);
            load.html('<div class="icon-spinner icon-spin icon-2x white"></div>');
            bootbox.confirm("Anda akan menghapus jabatan ini?", function(hsl){
                if(hsl==true){
                    if(pid!=0){
                        var post = $.post(url,{act:"hapus_skpd",id:pid});
                        post.done(function(res){
                            var hasil = res.split('__');
                            //alert(hasil.length);
                            if(hasil.length == 2){
                                if(hasil[0] == 'success'){
                                  //  rslt.html('<font color="green">Data Telah Dihapus...</font>');
                                  //  setTimeout(function(){
                                  //      rslt.html('');
                                  //  }, 1500);
                                    var tbody = $('#tampilJabatan');
                                    tbody.html(hasil[1]);
                                    init();
                                    //btn.parent().parent().remove();
                                }
                            }
                        });
                        load.html('<i class="icon-trash icon-white"></i>Hapus');
                    }
                }else{
                    load.html('<i class="icon-trash icon-white"></i>Hapus');
                }
            });
        });
        
    }
    init();
	/*
$(".geo-clear").change(function(){
	$('#id').val('0');
		var idinduk = $('#id_skpd').val();
		var post = $.post(url,{act:'get_induk',idindukk:idinduk});
			post.done(function(data){
				$('#id_induk').html(data);
			});
      	document.getElementById('nama').value='';
	//	document.getElementById('idindukk').selected=true;
		document.getElementById('kodejab').value='';
		document.getElementById('idjabatan').selected=true;
})*/
  
</script>