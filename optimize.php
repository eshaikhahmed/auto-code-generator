<html>
<head>

	<link rel="stylesheet" type="text/css" href="css/mystyle.css">
	<link rel="stylesheet" href="css/default.min.css">
	<script src="js/highlight.min.js"></script>
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
					<option>Springboot</option>
				</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
			Type: 
				<select name='typed' id='typed' onchange='setVal(this.value,2);notice();' >
					<option>Select</option>
					<option>CRUD APIs</option>
				</select>
			
				

		</p>
	
		<!--All the search filter is inside the this file -->
		</div>
		<BR>
		<form action='optimize.php' id="toBeTranslatedForm" method="POST">
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
				
				<?php if(isset($_POST['totalrow'])){ 
					
					include 'language_utils.php';
					$codes = getRelatedDatatoPage($_POST['totalrow'], $_POST['lang'], $_POST['type']);
					//echo $codes;
					for($k = 1; $k <= count($codes); $k++) {
					?>
					<div class="code vertical" id="code">
					<span style="text-align:left;background:orange;color:white;border-radius:10px; padding:5px;margin-top:5px;"><?=$codes[$k-1]['filename']?></span> 
					<pre><code class="language-java"><?=$codes[$k-1]['data'];?>
					</code></pre>  
					
					</div>
				<?php }} ?>
		</div>

	
	<script src='js/jquery-1.11.2.js'></script>
	<script src='js/myjavascript.js'></script>
	<script src='js/relateddata.js'></script>
	<script src='js/relatedlogic.js'></script>
	<script>hljs.highlightAll();</script>

</body>


</html>