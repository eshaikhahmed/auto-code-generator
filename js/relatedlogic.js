function related_logic()
{
	var language=$("#langd").val();
	var types=$("#typed").val();
	var totalrows=$("#totalrow").val();
	if(language!='Select' && types!='Select' && totalrows!='')
	{	
		 
		related_data(language,types,totalrows);
		 
		clearrowcount();
	}
	
}

function clearrowcount()
{
	var rowcounts=$("#totalrow").val();
	var l=0
	for(k=0;k<rowcounts;k++)
	{
		l=l+1;
		besttry(l)
	}
	$("#totalrow").val('');
}


function notice()
{   var language=$("#langd").val();
    var type=$("#typed").val();
	var notice=''
	if(language=='NET' && type=='NET Insert Procedure')
	{
		notice='<br>-	First variable is <span style="color:red;">tablename</span> \
				<br>-	Second variable is <span style="color:red;">auto incrementid of tablename</span>';
	}
	
	$("#notice").html(" "+notice);
}