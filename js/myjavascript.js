var rowcount=0;
	$(document).ready(function()
	{		
		$('#variables').focus();
			$('#add').click(function(){

				//alert('hello'+$('#variables').val());
				test=$('#variables').val();
				combine=test.split(" ");
				if(combine.length>1)
				{
						var k=0;
						for(k=0;k<combine.length;k++)
						{
								rowcount++;
								test=combine[k];
								previous=$('#center').html();

								newadd='<input type="hidden" name="deltedstatus'+rowcount+'" id="deltedstatus'+rowcount+'" />';	
								newadd=newadd+'<span class="completebox" id="deletedid'+rowcount+'"><span>'+test+'</span>';
								newadd=newadd+'<input type="hidden" name="variable'+rowcount+'" id="variable'+rowcount+'"  value="'+test+'"/>';
								newadd=newadd+'&nbsp;<input type="button" class="buttonshape" value="X" id="button'+rowcount+'" onclick="besttry('+rowcount+')" /></span>';

								$('#upper').append(newadd);	
						}
				}
				else if(test!='')
				{				
					rowcount++;
			
					previous=$('#center').html();

					newadd='<input type="hidden" name="deltedstatus'+rowcount+'" id="deltedstatus'+rowcount+'" />';	
					newadd=newadd+'<span class="completebox" id="deletedid'+rowcount+'"><span>'+test+'</span>';
					newadd=newadd+'<input type="hidden" name="variable'+rowcount+'" id="variable'+rowcount+'"  value="'+test+'"/>';
					newadd=newadd+'&nbsp;<input type="button" class="buttonshape" value="X" id="button'+rowcount+'" onclick="besttry('+rowcount+')" /></span>';

					$('#upper').append(newadd);	
				}
				$('#variables').val('');
				$('#variables').focus();
				$('#totalrow').val(rowcount);	
			});

	});

	

	function onkey(e)
	{
		
		var evtobj = window.event? event : e
      if (evtobj.keyCode == 13 && evtobj.ctrlKey)  //on pressing ctrl+Enter
      	{
      		//alert("Ctrl+Enter");
      		$('form').submit();

      	}	
		else if(evtobj.keyCode == 13) {
		        $('#add').click();
			}
	}
	function besttry(btn)
	{

		
		$('#deletedid'+btn).remove();
		$('#deltedstatus'+btn).val('D');
		
	}
	function setVal(val,seq)
	{
		selectedvalue=val;
		if(seq==1)
		{
			$('#lang').val(selectedvalue);
		}
		else
		{	
			$('#type').val(selectedvalue);
		}
	}