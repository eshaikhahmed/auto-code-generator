<?php 
$title = "CodeFactory - A tool is for creating Spring Boot APIs";
$header_data = '';
include('header.php');

?>
<br /> 
    <section class="configure-section">   
        <div class="container">
            <h2 class="text-center">
                Configure  
            </h2>
            <div class="form-group">
                <label  class="form-label">Language/Framework</label>
                <select  class="form-control" aria-label="Default select example" name='langd' id='langd' onchange='setVal(this.value,1);'>
                        <option>Select</option>
                        <option>Springboot</option>
                </select>
            </div>

            <div class="form-group">
                <label  class="form-label">Feature</label>
                <select  class="form-control" aria-label="Default select example" name='typed' id='typed' onchange='setVal(this.value,2);notice();'>
                        <option>Select</option>
                        <option>CRUD APIs</option>
                </select>
            </div>

            <div class="mb-3">
                <label  class="form-label">Feature name</label>
                <input type="text" class="form-control" id="feature_nam" name="feature_nam"
                placeholder="Your feature name" onkeyup="onFeature(event)"  />
            </div>

        </div>
    </section>

    <section class="configure-fields">
        <div class="container">
            <h1 class="text-center">Fields</h1>

            <div class="row">
                <div class="col-md-9">
                <input type='text' class="form-control" style='height:50px' name='variables' id='variables' onkeypress="onkey(event)" 
				placeholder='Enter your variables' >
                </div>
                <div class="col-md-3">
                <input class="btn" id='add' style='width:100%;height:50px' type='button' value='Add' >
                </div>
			</div>
            <div class="mb-3">
               
            </div>

            <form action='index.php' id="toBeTranslatedForm" method="POST">
                <div id='main' align="center" >
                    <div id='left'>&nbsp;</div>

                    <div id='center' style='background: #c2d6d6;width:100%;'>&nbsp;
                            <div id='upper'></div>			
                    </div>
                    
                    <div id='right'>&nbsp;</div>
                </div>

                <input type='hidden' name='totalrow' id='totalrow' />
                <input type='hidden' name='lang' id='lang' />
                <input type='hidden' name='type' id='type' />
                <input type='hidden' name='feature_name' id='feature_name' />
                <div class="mb-3">
                    <input type='submit' class="btn"  style='width:100%;height:45px' id='submit' value='Generate Code' />
                </div>
            </form>    
        </div>
    </section>

    <section class="code-section">
        <div class="container">
        <h1 class="text-center">Your Code</h1>
        <?php if(isset($_POST['totalrow'])){ 
					
					include 'language_utils.php';
					$codes = getRelatedDatatoPage($_POST['totalrow'], $_POST['lang'], $_POST['type'], $_POST['feature_name']);
					//echo $codes;
					for($k = 1; $k <= count($codes); $k++) {
					?>
					<div class="code vertical" id="code">
					<span style="background:orange;color:white;border-radius:10px; padding:5px;margin-top:5px;"><?=$codes[$k-1]['filename']?></span> 
					<pre><code class="language-java"><?=$codes[$k-1]['data'];?>
					</code></pre>  
					
					</div>
		<?php }} ?>

        </div>
    </section>
    
    <script src='js/jquery-1.11.2.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src='js/myjavascript.js'></script>
    <script src='js/relateddata.js'></script>
    <script src='js/relatedlogic.js'></script>
    <script>hljs.highlightAll();</script>
   </body>
</html>