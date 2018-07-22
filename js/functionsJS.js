

	function autofillArtikal(art,i,doc){
		var artikal = art.value;
		
		
		if(doc == "ulaz"){ //Ako je poziv funkcije iz "ULAZ"

			//Jedinica mere
			var xhr = new XMLHttpRequest();
			xhr.open("get", "artikal.php?artikal="+artikal+"&zahtev=jedinica_mere", false);
			xhr.send();
			var odgovor = xhr.responseText;
			if(odgovor!==""){
				document.getElementById("mera"+i).value = odgovor; 
			}
			
			//Stanje
			var xhr = new XMLHttpRequest();
			xhr.open("get", "artikal.php?artikal="+artikal+"&zahtev=stanje", false);
			xhr.send();
			var odgovor = xhr.responseText;
			if(odgovor!==""){
				document.getElementById("stanje"+i).innerHTML = odgovor; 
			}
		} 	
		
		$( "#kolicina"+i ).focus();
	}
	
	
	
	
	
	function createNewInput(i){
		var p = Number(i);  // broj predhodnog inputa
		i=Number(i)+1;  // broj trenutnog inputa
		var s = Number(i)+1;
		
		$('#tabela tr:nth-child('+ p +') ').each(function() {
			
			var predhodniArtikal = $(this).find('td:eq(1) input').val(); //vrednost u predhodnom inputu
			var sledeciArtikal = $('#tabela tr:nth-child('+ i +') ').find('td:eq(1) input').val(); //vrednost u sledecem inputu
			var sledeciArtikal2 = $('#tabela tr:nth-child('+ s +') ').find('td:eq(1) input').val(); //vrednost u drugom sledecem inputu
			
	//		alert(predhodniArtikal + " / " + sledeciArtikal + " / " + sledeciArtikal2);
			
			if (predhodniArtikal != "" && sledeciArtikal == "" && sledeciArtikal2 != ""){ // ako predhodni input nije prazan izpisuje se novi input

				var cell1 =  '<td class="col col-lg-1">'+i+'</td>';
				var cell2 =  '<td class="col col-lg-5"><input class="awesomplete"  name="artikal'+i+'"  id="artikal'+i+'"  onblur="autofillArtikal(this,'+"'"+i+"','ulaz'"+')" onfocus="createNewInput('+"'"+i+"'"+')" list="artikli" value="" style="font-size:12.5px;" size="36"></td>';
				var cell3 = '<td class="col col-lg-2"><input type="input" id="mera'+i+'" name="mera'+i+'" size="2"></td>';
				var cell4 = '<td class="col col-lg-2" id="stanje'+i+'"></td>';
				var cell5 = '<td class="col col-lg-2"> <input type="text" name="kolicina'+i+'" id="kolicina'+i+'" size="2" value=""> &nbsp <input type="checkbox" name="zaduzenje'+i+'" value="1"> </td>';
				
				$('#tabela tr:nth-child('+ i +')').after('<tr class="row" id="tr'+i+'"> '+cell1+cell2+cell3+cell4+cell5+'</tr>');
				var last_num = Number($('#number_of_rows').val()); //broj trenutnih inputa
				var new_num = last_num + 1;
				$('#number_of_rows').val(new_num);
			}

		});	
	}


	// AJAX za filter
	function ajax_filter(kategorija,kriterijum,vrednost){
		
		if(vrednost == "[object HTMLInputElement]"){
			var vrednost = vrednost.value;
		}
		
		if(kriterijum=="br_fakture" || kriterijum=="datum" || kriterijum=="id_fakture" || kriterijum=="napomena"){
			var id = vrednost; //uzima se vrednost input polja
		}else{
			var id = $('#'+kriterijum).find("option[value='"+vrednost+"']").attr('data-id'); //id selektovanog "option"-a
		}
		
//		alert(kategorija+"/"+kriterijum+"/"+id);
		
		$(".del").remove(); //brisanje prethodnih rezultata

		var xhr = new XMLHttpRequest();
		xhr.open("get", "filter.php?kategorija="+kategorija+"&kriterijum="+kriterijum+"&id="+id, false);
		xhr.send();
		var odgovor = xhr.responseText;
		if(odgovor!==""){
//			$("#rezultat").html(odgovor); 
			$('#tabela tr:last').after(odgovor);
		}
	}
	
	
	function autofillEdit(kriterijum,rows,vrednost){
		if(vrednost == "[object HTMLInputElement]"){
			var vrednost = vrednost.value;
		}
		
		if(kriterijum=="br_fakture" || kriterijum=="datum" || kriterijum=="id_fakture"){
			var id = vrednost; //uzima se vrednost input polja
		}else{
			var id = $('#'+kriterijum).find("option[value='"+vrednost+"']").attr('data-id'); //id selektovanog "option"-a
		}
		
		alert(kriterijum+"/"+rows+"/"+id+"/"+vrednost);
	}
//END ARHIVA-------------------------------------------------------------------------------------------------------









