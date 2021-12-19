<html>
<head>

	<link rel="stylesheet" type="text/css" href="css/mystyle.css">
</head>

<body>
				<div id="notice">
				 
				</div>
				<div align="center" id="search">

				<input type='text' name='variables' id='variables' onkeypress="onkey(event)" 
				placeholder='Enter your variables' style='width:400px;height:30px' >
				 <input id='add' style='width:10%;height:35px' type='button' value='Add' >
		<br>
			<p id='lfirst'>
			<strong>Select Language: 
				<select name='langd' id='langd' onchange='setVal(this.value,1);'>
					<option>Select</option>
					<option>CodeIgnitor</option>
					<option>Java</option>
					<option>Javascript</option>-->
					<option>NET</option>
					<option>Android</option>
					<option>Xamarin</option>
				</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
			Type: 
				<select name='typed' id='typed' onchange='setVal(this.value,2);notice();' >
					<option>Select</option>
					<!--<option>forloopnormal</option>
					<option>forloopadb</option>	
					<option>insertquery</option>
					<option>updatequery</option>
					<option>validation</option>
					<option>Adb Query Code</option>
					<option>insert with query</option>		
					<option>Ajax</option>	-->
					<option>Simple Form</option>	
					<option>Android - Complete Page</option>
					<option>Android - Make EditText</option>
					<option>NET Retrieve</option>	
					<option>NET Insert</option>	
					<option>NET Insert Procedure</option>
					<option>CS Grid Details</option>
					<option>Xamrin - CS Stack Details</option>
					<option>Xamrin - CS Underline Label</option>
					<option>Xamrin - XAML Stack Details</option>
				</select>
			
				

		</p>
	
		<!--All the search filter is inside the this file -->
		</div>
		<BR>
		<form action='home.php' id="toBeTranslatedForm" method="POST">
		<input type='hidden' name='totalrow' id='totalrow' />
		<input type='hidden' name='lang' id='lang' />
		<input type='hidden' name='type' id='type' />
			<p>
			<input type='submit' id='submit' value='Submit' />
		</p>
		<div id='main' align="center" >
			<div id='left'>&nbsp;</div>

			<div id='center' style='background: #c2d6d6;'>&nbsp;
					<div id='upper'></div>			
			</div>
			
			<div id='right'>&nbsp;</div>
		</div>
		</form>
		<p></p>


		<div class="example">
		<h1 align="center">You Code</h3>

				<div class="vertical" id="code">
				  <?php 
						if(isset($_POST['totalrow'])){
							include 'related_data.php';
							echo getRelatedDatatoPage($_POST['totalrow'], $_POST['lang'], $_POST['type']);
						}
				  
				  ?>
				</div>

		</div>


	<script src='js/jquery-1.11.2.js'></script>
	<script src='js/myjavascript.js'></script>
	<script src='js/relateddata.js'></script>
	<script src='js/relatedlogic.js'></script>
	

</body>


</html>