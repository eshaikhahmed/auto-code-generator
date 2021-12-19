function related_data(language,type,rowcount)
{
	// alert('type'+type+' language'+language);
	//alert(rowcount);
	
	if(language=='NET' && type=='NET Insert')
	{
				var seq=0;
				
				
				var data = "<br><div class='syntax'>";
				var columns="";
				var counter=0;
				var procedure_columns="";
				var procedure_values="";
				var procedure_declares="";
				var comma=",";
				var at=",";
				var previous=rowcount-1;
				
				for(k=0;k<rowcount;k++)
				{
					seq=seq+1;
					if($("#deltedstatus"+seq).val()!='D')
					{
						var seqvalue=$("#variable"+seq).val();
					
						columns=columns+'<br>SqlParameter '+seqvalue+' = new SqlParameter();<br>'+seqvalue+'.ParameterName \
						= "@'+seqvalue+'";<br>'+seqvalue+'.Value = emp.'+seqvalue+' \
						;<br> cmd.Parameters.Add('+seqvalue+');';	
					
					
								if(counter==previous)	
								{
									procedure_declares=procedure_declares+"<br>                @"+seqvalue+" varchar(500)";
								}
								else				
								{
									procedure_declares=procedure_declares+"<br>                @"+seqvalue+" varchar(500),";
								}

								if(counter==0)
								{
									procedure_columns=""+seqvalue+""+procedure_columns;
									procedure_values="@"+seqvalue+""+procedure_values;
									 
								}	
								else
								{
									procedure_columns=procedure_columns+""+comma+""+seqvalue+"";
									procedure_values=procedure_values+""+at+"@"+seqvalue+"";
									 
								}
								counter++;			
					}
					
				}
				
					data=data+'  public void Add(Employee emp){ <BR />	\
						string connectionstring = ConfigurationManager.ConnectionStrings["EmployeeContext"].ConnectionString; \
					   <br>// List<Employee> emp = new List<Employee>();   \
					   <br> using (SqlConnection conn = new SqlConnection(connectionstring)) \
					   <br> { \
					   <br> SqlCommand cmd = new SqlCommand("addemployee", conn); \
					   <br> cmd.CommandType = CommandType.StoredProcedure; \
						<br>	'+columns+' \
						<br>    conn.Open();	\
						<br>    cmd.ExecuteNonQuery();	\
					   <br> }	\
			  <br>  }	\
				<br>==============================================================================	\
		<br>		//Stored Procedure \
		<br>		CREATE PROCEDURE addemployee \
		<br>		'+procedure_declares+'	\
		<br>		AS	\
		<br>		BEGIN	\
		<br>		 INSERT INTO Employee('+procedure_columns+') VALUES('+procedure_values+') \
		<br>		END	\
					\
				<div style="background:yellow;color:black;">	\
				Please do change the datatype,object and tablename  with respect to your need in Stored Procedure 	\
				</div>	\
				';
				
				$(".vertical").html(" "+data);
	}		//End If 
	
	if(language=='NET' && type=='NET Insert')
	{

	}
	
	if(language=='NET' && type=='NET Insert Procedure')
	{
			var seq=0;
				
				
				var data = "<br><div class='syntax'>";
				var columns="";
				var counter=0;
				var procedure_columns="";
				var procedure_values="";
				var procedure_declares="";
				var comma=",";
				var at=",";
				var previous=rowcount-1;
				var tablename="";
				var auto_incrementid="";
				var filter_data="";	//Procedure filter parameter
				var parameters=""	//GridDisplay function parameter
				var parameter_bindings=""; //GridDisplay function inside fields mapping with procedure
				var grid_columns="";		
				var codebehind_filters="";
				var codebehind_strings="";
				for(k=0;k<rowcount;k++)
				{
					seq=seq+1;
					if($("#deltedstatus"+seq).val()!='D')
					{
							var seqvalue=$("#variable"+seq).val();
							
							if(counter==previous)	
							{
								procedure_declares=procedure_declares+"<br>@"+seqvalue.toUpperCase()+" varchar(500)";
							}
							else if(counter>=2)				
							{
								procedure_declares=procedure_declares+"<br>@"+seqvalue.toUpperCase()+" varchar(500),";
							 
							}

								
							if(counter==0)	
							{
								tablename=seqvalue;
							}
							else if(counter==1)	
							{
								auto_incrementid=seqvalue;
							}
							else if(counter==2)
							{
								procedure_columns=""+seqvalue+""+procedure_columns;
								procedure_values="@"+seqvalue+""+procedure_values;
								filter_data=filter_data+"<br>IF(@"+seqvalue.toUpperCase()+" IS NOT NULL AND @"+seqvalue.toUpperCase()+"!='')	\
											 <BR>BEGIN	\
											 <BR>SET @SQLQuery = @SQLQuery +' AND "+seqvalue+" LIKE ''%'+@"+seqvalue.toUpperCase()+"+'%''' \
											 <BR>SET @WHERE = @WHERE +' AND "+seqvalue+" LIKE ''%'+@"+seqvalue.toUpperCase()+"+'%'''	\
											 <BR>END<BR> ";
											 
								parameters=parameters+" string "+seqvalue+",";		//GridDisplay function parameter	
								parameter_bindings=parameter_bindings+"cmd.Parameters.AddWithValue(\"@"+seqvalue.toUpperCase()+"\", "+seqvalue+"); <BR>";		
								grid_columns=grid_columns+'<br><telerik:GridBoundColumn DataField="'+seqvalue+'" HeaderText="'+firstToUpperCase(seqvalue)+'" SortExpression="'+seqvalue+'" \
															UniqueName="'+firstToUpperCase(seqvalue)+'"></telerik:GridBoundColumn>';		
															
								codebehind_filters=codebehind_filters+'<br> if ('+firstToUpperCase(tablename)+'.MasterTableView.GetColumnSafe("'+firstToUpperCase(seqvalue)+'").CurrentFilterValue != "")	\
																	   <br> {			\
																	   <br> 	 ViewState["'+seqvalue+'"] = '+firstToUpperCase(tablename)+'.MasterTableView.GetColumnSafe("'+firstToUpperCase(seqvalue)+'").CurrentFilterValue;		\
																	   <br> }			\
																	   <br> else {		\
																	   <br> 	  ViewState["'+seqvalue+'"] = "";		\
																	   <br> }	<br>		\
																	   ';				

								codebehind_strings=codebehind_strings+'<br> string '+seqvalue+'=ViewState["'+seqvalue+'"].ToString(); \
																	  ';											
							}	
							else
							{
								procedure_columns=procedure_columns+""+comma+""+seqvalue+"";
								procedure_values=procedure_values+""+at+"@"+seqvalue.toUpperCase()+"";
								
								filter_data=filter_data+"<br>IF(@"+seqvalue.toUpperCase()+" IS NOT NULL AND @"+seqvalue.toUpperCase()+"!='')	\
											 <BR>BEGIN	\
											 <BR>SET @SQLQuery = @SQLQuery +' AND "+seqvalue+" LIKE ''%'+@"+seqvalue.toUpperCase()+"+'%''' \
											 <BR>SET @WHERE = @WHERE +' AND "+seqvalue+" LIKE ''%'+@"+seqvalue.toUpperCase()+"+'%'''	\
											 <BR>END<BR> "; 
											 
								parameters=parameters+" string "+seqvalue+",";	 	//GridDisplay function parameter	
								parameter_bindings=parameter_bindings+"cmd.Parameters.AddWithValue(\"@"+seqvalue.toUpperCase()+"\", "+seqvalue+"); <BR>";			//GridDisplay function inside fields mapping with procedure 

								grid_columns=grid_columns+'<br><telerik:GridBoundColumn DataField="'+seqvalue+'" HeaderText="'+firstToUpperCase(seqvalue)+'" SortExpression="'+seqvalue+'"   \
															UniqueName="'+firstToUpperCase(seqvalue)+'"></telerik:GridBoundColumn>';


								codebehind_filters=codebehind_filters+'<br> if ('+firstToUpperCase(tablename)+'.MasterTableView.GetColumnSafe("'+firstToUpperCase(seqvalue)+'").CurrentFilterValue != "")	\
																	   <br> {			\
																	   <br> 	 ViewState["'+seqvalue+'"] = '+firstToUpperCase(tablename)+'.MasterTableView.GetColumnSafe("'+firstToUpperCase(seqvalue)+'").CurrentFilterValue;		\
																	   <br> }			\
																	   <br> else {		\
																	   <br> 	  ViewState["'+seqvalue+'"] = "";		\
																	   <br> }	<br>		\
																	   ';			
																	   
								codebehind_strings=codebehind_strings+'<br> string '+seqvalue+'=ViewState["'+seqvalue+'"].ToString(); \
																	  ';																						
			
							}
								counter++;			
								
						
						
					}
					
					
				}
				
				// View 
				var event_name1=firstToUpperCase(tablename);
				
				var  view='<br>	<asp:UpdatePanel ID="updPanel" runat="server">	\
			  <br>		<ContentTemplate>	\
			  <br>		 <telerik:RadAjaxPanel ID="ajaxpnl1" runat="server" LoadingPanelID="RadAjaxLoadingPanel1"	 ClientEvents-OnRequestStart="requestStart" EnableAJAX="true"> \
			  <br>		      <telerik:RadGrid ID="'+event_name1+'" runat="server"   onneeddatasource="'+event_name1+'_NeedDataSource"  \
			  <br> 					AllowPaging="True"    AllowCustomPaging="true"		MasterTableView-ShowFooter="true"   Skin="Simple"  > <br><br>	\
			  <br>					<MasterTableView  AutoGenerateColumns="false" 	CommandItemDisplay="Top" EditMode="PopUp"  		  DataKeyNames="'+auto_incrementid+'" ClientDataKeyNames="'+auto_incrementid+'"	 AllowFilteringByColumn="true" >		\
			  <br>						<br> <CommandItemTemplate>	\
			  <br>							 <table style="width: 100%">																					\
              <br>			                  <tr>																														\
              <br>				                  <td align="left" style="width: 15%;">					\
			  <br>												<asp:LinkButton ID="newrecord" runat="server" CommandName="InitInsert" OnClientClick="return ShowInsertForm();">	\
			  <br>													<img src="../Images/AddRecord.png" alt="" style="padding:10px;height:15px;width:15px" />  Add New '+event_name1+'			\
			 <br>												</asp:LinkButton>							\
			 <br>										  </td>											\
			 <br>											<td align="right" style="width: 81%;">			\
			 <br>																<asp:LinkButton ID="RebindGrid" runat="server" CommandName="RebindGrid" OnClientClick="RadGrid1_ItemCommand">		\
			 <br>																		<img src="../Images/ClearFilter.png" alt=""  style="padding:3px;height:20px;width:20px"/>Clear Filters		\
			 <br>																</asp:LinkButton>			\
			 <br>											</td>		\
			 <br>										<td align="center" style="width: 1%;">		\
			 <br>											|		\
			 <br>										</td>		\
             <br>	                       			 <td align="center" style="width: 2%;">		\
             <br>	                          				 <asp:LinkButton ID="ExportToExcel" runat="server" CommandName="ExportToExcel">		\
             <br>	                              				 <img src="../Images/Excel.jpg" alt="" style="padding:3px;height:30px;width:30px" />		\
             <br>	                            			</asp:LinkButton>			\
             <br>	                      			 </td>									\
             <br>	                        		<td align="center" style="width: 2%;">		\
             <br>	                         				  <asp:LinkButton ID="ExportToPdf" runat="server" CommandName="ExportToPdf">		\
             <br>	                            			  <img src="../Images/pdf.png" alt="" style="padding:3px;height:30px;width:30px" />		\
             <br>	                            				</asp:LinkButton>	\
             <br>	                       			 </td>	\
             <br>	                        		<td align="center" style="width: 2%;">	\
             <br>	                        				    <asp:LinkButton ID="ExportToWord" runat="server" CommandName="ExportToWord">	\
             <br>	                      							  <img src="../Images/XML.png " alt="" style="padding:3px;height:30px;width:30px"  />	\
             <br>	                            				</asp:LinkButton>	\
             <br>	                        		</td>		\
             <br>	                    		</tr>			\
             <br>	               				</table>			\
             <br>	          			 </CommandItemTemplate>		\
			  <br>	 					<br>					\
			  <br>						<Columns> 		<br>	\
			  <br>						'+grid_columns+'						\
			  <br>						</Columns> 	<br><br>	<br>	\
			  <br>					</MasterTableView>	<br>\
			  <br>					 <PagerStyle AlwaysVisible="True" />	\
			  <br>					<ClientSettings EnableRowHoverStyle="true">	</ClientSettings> <br>	\
			  <br>	  <br><br></telerik:RadGrid>	\
			  <br>		  </telerik:RadAjaxPanel>	\
			  <br>		</ContentTemplate>	\
			  <br>	</asp:UpdatePanel>	\
			  <br>	// Business Layer		\	';
			  
			  
			   view=view.replace(/<br>/g,'some');
			   var lt=view.replace(/</g,'&lt;');
			   var gt=lt.replace(/>/g,'&gt;');
			   view=gt.replace(/some/g,'<br>');
			  
			  
			  //Code Behind
			   var codebehind='<br>  private void getGridFilter()			\
							   <br>	{				\
							   <br>			'+codebehind_filters+'		\
							   <br>	}				\
							   <br>  protected void '+event_name1+'_NeedDataSource(object sender, EventArgs e)			\
							   <br>	{			\
							   <br>	 	int pageNo = '+event_name1+'.CurrentPageIndex + 1;		\
							   <br>	 	int pageSize = '+event_name1+'.PageSize;		\
							   <br>	 	int isFetchCount = 1;	 <br>	\
							   <br>		getGridFilter();  		 <br>	\
							   <br>		'+codebehind_strings+'				<br><br>				\
							   <br>		BusinessLayer obj = new BusinessLayer();				\
							   <br>		DataSet ds = new DataSet();							\
							   <br>		'+event_name1+'.DataSource = obj.GridDisplay('+parameters.replace(/string/g,'')+'  pageNo, pageSize, ref isFetchCount);			\
							   <br>		'+event_name1+'.VirtualItemCount = isFetchCount;					\
							   <br>	}				\
								';
			  
			  
			  
		
			   
			  
			   
				data=data+'  \
			  <br>	<span style="color:#d24dff;">  ========================================= Code Behind ============================================= </span>	<br><br>  \
			  <br>		'+codebehind+'	\
			  <br>	<span style="color:#d24dff;"> ========================================= View Design Page ========================================	</span> <br><br>  \
			  <br>		'+view+'		\
			  <br> <span style="color:#d24dff;"> ========================================Code Business Layer	============================================  </span><br><br> 	\
			  <br>	public DataSet GridDisplay('+parameters+' int pageNo, int pageSize, ref int isFetchCount)		\
			  <br>	{		\
			  <br>	  DataLayer obj = new DataLayer();	\
			  <br>	  return obj.GridDisplay('+parameters.replace(/string/g,'')+'  pageNo, pageSize, ref isFetchCount);\
			  <br>	}	<br><br>	\
			  <br> <span style="color:#d24dff;"> ========================================Code DataLayer	============================================  </span> <br><br> 	\
			  <br>	public DataSet GridDisplay('+parameters+' int pageNo, int pageSize, ref int isFetchCount)		\
			  <br>	{				\
			  <br>		try		\
			  <br>		{		\
			  <br>		   cn = new SqlConnection();		\
			  <br>		   cn.ConnectionString = ConStr;	\
			  <br>		   cn.Open();	\
			  <br>		   SqlCommand cmd = new SqlCommand("SHOW_'+event_name1+'", cn);	\
			  <br>		   cmd.CommandType = CommandType.StoredProcedure;	\
			  <br>		   cmd.Parameters.AddWithValue("@PAGENUMBER", pageNo);	\
			  <br>		   cmd.Parameters.AddWithValue("@PAGESIZE", pageSize); 	\
			  <br>		   '+parameter_bindings+'					\
			  <br>		   cmd.Parameters.Add("@ISFETCHCOUNT", SqlDbType.Int).Direction = ParameterDirection.Output; <br><br>	\
			  <br>		   DataSet ds = new DataSet(); \
			  <br>		   SqlDataAdapter sda = new SqlDataAdapter();	\
			  <br>		   sda.SelectCommand = cmd;		\
			  <br>		   sda.Fill(ds);	\
			  <br>		   cmd.ExecuteNonQuery(); <br>	\
			  <br>		   isFetchCount = Convert.ToInt32(cmd.Parameters["@ISFETCHCOUNT"].Value); <br><br>	\
			  <br>		   return ds;	\
			  <br>		}		\
			  <br>		catch (Exception Ex)		\
			  <br>		{		\
			  <br>			 throw Ex;	\
			  <br>		}		\
			  <br>	}		\
			  <br>  	\
			  <br><span style="color:#d24dff;">  ========================================== Stored Procedure ==================================== </span> <br><br> 	\
		<br>		--Stored Procedure \
		<br>		CREATE PROCEDURE SHOW_'+event_name1+' \
		<br>		@PAGENUMBER		INT	 \
		<br>		,@PAGESIZE		INT	 \
		<br>		,@ISFETCHCOUNT INT OUTPUT,	\
				'+procedure_declares+'	\
		<br>		AS	\
		<br>		BEGIN <br><br>	\
		<br>		DECLARE @SQLQuery AS NVARCHAR(1000) ,	\
		<br>		@WHERE AS NVARCHAR(1000),	\
		<br>		@ROWQUERY AS NVARCHAR(1000)	\
		<br>		DECLARE @ParameterDefinition AS NVARCHAR(500)	\
		<br>		DECLARE @ROWCOUNT TABLE(	\
		<br>		COUNTS INT );  \
		<br><br>			 \
		<br> 		SET @WHERE=\'\'	 	\
		<br>		SET @SQLQuery =\' SELECT * FROM  (SELECT CASE WHEN @PAGENUMBER IS NOT NULL THEN ROW_NUMBER() OVER(ORDER BY '+auto_incrementid+' ) ELSE 0 END AS ROWNUM ,* 	\
		<br>		FROM '+tablename+'	\
		<br>		WHERE   1=1 \' 		\
		<br>		-- Filters apply			\
		<br>		'+filter_data+'	\
		<br>		SET @SQLQuery = @SQLQuery +\' ) M  WHERE ROWNUM	between ((ISNULL(@PAGENUMBER,-1) - 1) * ISNULL(@PAGESIZE,1) + 1) AND (ISNULL(@PAGENUMBER,-1) * ISNULL(@PAGESIZE,-1))\'				\
		<br>		SET @ParameterDefinition =\'@PAGENUMBER SMALLINT,		\
		<br>									  @PAGESIZE SMALLINT\' 	<br>	\
		<br>		EXECUTE sp_executesql @SQLQuery, @ParameterDefinition, @PAGENUMBER,@PAGESIZE	\
		<br>		SET @ROWQUERY= \'SELECT COUNT(0)  from '+tablename+' WHERE 1=1\'+ @WHERE	<br>			\
		<br>		print @ROWQUERY	<br>	\
		<br>		INSERT INTO @ROWCOUNT <br>	\
		<br>		EXECUTE sp_executesql @ROWQUERY				\
		<br>		SELECT @ISFETCHCOUNT = COUNTS FROM @ROWCOUNT	\
		<br>		select @ISFETCHCOUNT	\
		<br><br><br>END	\
					\
		<br><br>		<div style="background:yellow;color:black;">	\
				Please do change the procedure name,datatype,object and tablename  with respect to your need in Stored Procedure 	\
				</div>	\
				';
				
				$(".vertical").html(" "+data);
				
				 
	
	}
	
	if(language=='Xamarin' && type=='CS Grid Details')
	{
				var c=1;
				var filter_data="";
				var seq=0;
					for(k=0;k<rowcount;k++)
					{
						seq=seq+1;
						if($("#deltedstatus"+seq).val()!='D')
						{
								var seqvalue=$("#variable"+seq).val();
								//alert(seqvalue);
									filter_data=filter_data+"<br>//==========="+seqvalue+"============<br><br>Label lbl"+seqvalue+" = new Label();  <BR> Label colon"+ seqvalue+" = new Label();  <BR> Label Show"+seqvalue+" = new Label(); <br>	\
											 <BR>lbl"+seqvalue+".Text = \""+ seqvalue +"\"; <br> colon"+seqvalue+".Text = \":\"; <br>  Show"+seqvalue+".SetBinding(Label.TextProperty, \""+seqvalue+"\"); <br>	\
											 <BR> lbl"+seqvalue+".FontSize = font_size;  <br>   Show"+seqvalue+".FontSize = font_size; <br>  \
											 <BR> grid.Children.Add(lbl"+seqvalue+", 0, "+c+");   grid.Children.Add(colon"+seqvalue+", 1, "+c+"); <BR>  grid.Children.Add(Show"+seqvalue+", 2, "+c+");	\
											   ";
								
								c++;
						}
					
					}
					
					data='	int width_lblNew = 100;	<br>	\
								int font_size = 16;	<br>		\
							Grid grid = new Grid(); <BR>	 \
							grid.RowSpacing = 0;		<br><br>	'+filter_data;
							
					$(".vertical").html(" "+data);
				
	}
	
		if(language=='Xamarin' && type=='Xamrin - CS Stack Details')
		{
					var c=1;
					var filter_data="";
					var seq=0;
					var horizontal="";
						for(k=0;k<rowcount;k++)
						{
							seq=seq+1;
							if($("#deltedstatus"+seq).val()!='D')
							{
									var seqvalue=$("#variable"+seq).val();
									//alert(seqvalue);
										filter_data=filter_data+"<br>//==========="+seqvalue+"============<br><br>Label lbl"+seqvalue+" = new Label();  <BR> Label colon"+ seqvalue+" = new Label();  <BR> Label Show"+seqvalue+" = new Label(); <br>	\
												 <BR> lbl"+seqvalue+".Text = \""+ seqvalue +"\"; <br> colon"+seqvalue+".Text = \":\"; <br>  Show"+seqvalue+".SetBinding(Label.TextProperty, \""+seqvalue+"\"); <br>	\
												 <BR> lbl"+seqvalue+".FontSize = font_size;  <br>   Show"+seqvalue+".FontSize = font_size; <br>  \
												 <BR> lbl"+seqvalue+".WidthRequest = width_lblNew; <BR> lbl"+seqvalue+".MinimumWidthRequest = width_lblNew; <BR>	\
												 <BR>   StackLayout horizon"+c+" = new StackLayout()	<BR>\
													{	<BR>\
														Orientation = StackOrientation.Horizontal, <BR>\
														Children = { lbl"+seqvalue+", colon"+ seqvalue+", Show"+seqvalue+" }	<BR> \
													}; <BR><BR><BR> \
												   ";
									if(c==1)
									{
										horizontal="horizon"+c;
									}
									else{
										horizontal=horizontal+" , horizon"+c;
									}
									
									c++;
							}
						
						}
						
						data='	int width_lblNew = 100;	<br>	\
									int font_size = 16;	<br>		\
								 <BR>	 \
									<br><br>	'+filter_data+'	\
									 StackLayout vertical = new StackLayout() <BR>	\
									{		<BR>	\
										Orientation = StackOrientation.Vertical,<BR>	\
										Children = { '+horizontal+'} <BR>	\
									}; <BR>	\
									View = vertical; <BR>\
									';
								
						$(".vertical").html(" "+data);
					
		}
	
	
		if(language=='Xamarin' && type=='Xamrin - XAML Stack Details')
		{
					var c=1;
					var filter_data="";
					var seq=0;
					var horizontal="";
						for(k=0;k<rowcount;k++)
						{
							seq=seq+1;
							if($("#deltedstatus"+seq).val()!='D')
							{
									var seqvalue=$("#variable"+seq).val();
									//alert(seqvalue);
										filter_data=filter_data+"<br><br> &lt;!--==========="+seqvalue+"============ --&gt;<br><br>  &lt;StackLayout       Orientation=\"Horizontal\" &gt; \
										<br>	 &lt;Label x:Name=\"lbl"+seqvalue+"\"  Text=\""+seqvalue+"\" FontSize=\"16\" MinimumWidthRequest=\"100\" WidthRequest=\"130\" /&gt;	\
										<br>	 &lt;Label x:Name=\"colon"+seqvalue+"\"  Text=\":\" FontSize=\"16\" /&gt;	\
										<br>	 &lt;Label x:Name=\"txt"+seqvalue+"\"  Text=\"\" FontSize=\"16\"  /&gt;	\
										<br>  &lt;/StackLayout    &gt; \
												";
									if(c==1)
									{
										horizontal="horizon"+c;
									}
									else{
										horizontal=horizontal+" , horizon"+c;
									}
									
									c++;
							}
						
						}
						
						data='	 	\
								 	\
								 <BR>	 \
									<br><br>	'+filter_data+'	\
									  <BR>	\
								 	<BR>	\
									 	\
									 <BR>	\
								  <BR>	\
									  <BR>\
									';
								
						$(".vertical").html(" "+data);
						
			
		}
	
	
	
		if(language=='Xamarin' && type=='Xamrin - CS Underline Label')
		{
					var c=1;
					var filter_data="";
					var seq=0;
					var horizontal="";
						for(k=0;k<rowcount;k++)
						{
							seq=seq+1;
							if($("#deltedstatus"+seq).val()!='D')
							{
									var seqvalue=$("#variable"+seq).val();
									//alert(seqvalue);
										filter_data=filter_data+"<br><br>//--==========="+seqvalue+"============ --&gt;<br><br>  StackLayout stck"+seqvalue+" = new StackLayout()	<br>\
										{ <br>\
											 Orientation=StackOrientation.Vertical, <br>	\
											Spacing=0, <br>						\
										};		<br><br>	\
											 BoxView box"+seqvalue+" = new BoxView()	<br>\
											{									<br>\
												HeightRequest = 1,				<br>\
												HorizontalOptions=LayoutOptions.FillAndExpand,		<br>\
												VerticalOptions=LayoutOptions.EndAndExpand,		<br>\
												Color=Color.White			<br>\
											};		<br><br>\
											 stck"+seqvalue+".Children.Add(ShowEmail); <br>\
											 stck"+seqvalue+".Children.Add(box"+seqvalue+"); <br><br>\
											 var tap"+seqvalue+" = new TapGestureRecognizer();	<br>\
											tap"+seqvalue+".Tapped += (s, e) =>	<br>\
											{													<br>\
												if (ShowEmail.Text != \"\")						<br>	\
												{													<br>\
													var urlStore = Device.OnPlatform(\"\", \"mailto:\" + ShowEmail.Text,\"mailto:\" + ShowEmail.Text); //iOS,Android,Windows	<br>\
													Device.OpenUri(new Uri(urlStore));						<br>\
												}														<br>\
											};														<br>\
											ShowEmail.GestureRecognizers.Add(tap"+seqvalue+");				<br>		\
										\
										\
												";
									if(c==1)
									{
										horizontal="horizon"+c;
									}
									else{
										horizontal=horizontal+" , horizon"+c;
									}
									
									c++;
							}
						
						}
						
						data='	 	\
								 	\
								 <BR>	 \
									<br><br>	'+filter_data+'	\
									  <BR>	\
								 	<BR>	\
									 	\
									 <BR>	\
								  <BR>	\
									  <BR>\
									';
								
						$(".vertical").html(" "+data);
						
			
		}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}

function doSomething(language,type,rowcount)
{
	rowcount = $('#totalrow').val();
	type = $('#type').val();
	language = $('#lang').val();
	//alert('type'+type+' language'+language);
     
	// $.ajax({
	// 	type: "post",
	// 	url: "related_data.php",
	// 	data: {totalrow:rowcount,lang:language,type:type},
	// 	datatype: "text",
	// 	success: function(data){                
			                 
	// 		 $(".vertical").html(data);
			          
	// 	}
	// });
	return true;
	
}

function firstToUpperCase( str ) {
    return str.substr(0, 1).toUpperCase() + str.substr(1);
}