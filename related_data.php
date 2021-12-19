<?php


function getRelatedDatatoPage($totalrow=0,$lang='',$type='')
{
		$seq=0 ;//is to get values sequence wise
		$seqvalue=0;//is the value of every sequene
		$data=''; //	All the related data that we want to print will come into this variable

		
	if($lang=='CodeIgnitor')
	{	
		include('code_ignitor.php');
		$data = getData($totalrow, $lang, $type);
		
	}//End Main If


	if($lang=='Android' && $type=='Android - Make EditText')
	{	
		
		//$data .= "for(\$k=0;\$k<\$total_rows;\$k++)<br>";
		$data = "<br><div class='syntax'>";
		$init_vars = "private EditText";
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
				$seqvalue=$_REQUEST['variable'.$seq];
				$data.=" ".$seqvalue." = findViewById(R.id.".$seqvalue.");<br>"	;
				$init_vars.=" ".$seqvalue.",";
			}//End inner if
		} //End For Loop
		$data.= $init_vars;
		$data.= "</div>";
	
	}//End Main If

	if($lang=='Android' && $type=='Android - Complete Page')
	{	
		$table_namewe = "Road";
		$xml_element = '';
		$java_model_var = '';
		$java_model_get_set_var = '';
		$java_textview_adapter = "";
		$java_init_textview_adapter = '';
		$java_set_textview_adapter = '';
		$java_activity_json = '';
		$java_activity_set = '';
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
				$seqvalue=$_REQUEST['variable'.$seq]; 
				$xml_element .= '<TextView
									android:id="@+id/'.$seqvalue.'"
									android:layout_width="wrap_content"
									android:layout_height="wrap_content"
								 />
								 ';
				$java_model_var .= 'private String '.$seqvalue.';
			';
				$java_model_get_set_var .= '
				public String get'.ucfirst($seqvalue).'(){
					return '.$seqvalue.';
				}

				public void set'.ucfirst($seqvalue).'(String '.$seqvalue.'){
					this.'.$seqvalue.' = '.$seqvalue.'; 
				}
			';
				$java_textview_adapter .= 'TextView '.$seqvalue.';
			';
				$java_init_textview_adapter .= ''.$seqvalue.' = itemView.findViewById(R.id.'.$seqvalue.');
			';
			 
				$java_set_textview_adapter .= ''.$seqvalue.'.setText(""+searchProductModel.get'.ucfirst($seqvalue).'());
				';

				$java_activity_json .= 'String '.$seqvalue.' = jsonItem.optString("'.$seqvalue.'");
				';

				$java_activity_set .= ' model.set'.ucfirst($seqvalue).'('.$seqvalue.');
				';

				
			}//End inner if
		} //End For Loop


		$java_model_page = '
		<xmp>
		**************************************************************************************************************
		Java Model
		---
		package com.java.model;
		public class '.$table_namewe.'_Model {
			 '.$java_model_var.'

			private String layoutType;
			public String getLayoutType() {
				return layoutType;
			}
		
			public void setLayoutType(String layoutType) {
				this.layoutType = layoutType;
			}

			'.$java_model_get_set_var.'
		}</xmp>
		';

		$java_adapter_page = '	<xmp>
		**************************************************************************************************************
		Adapter
		---
		package com.java.adapter;

		import android.app.Activity;
		import android.view.LayoutInflater;
		import android.view.View;
		import android.view.ViewGroup;
		import android.widget.Button;
		import android.widget.ImageView;
		import android.widget.TextView;

		import androidx.cardview.widget.CardView;
		import androidx.core.content.ContextCompat;
		import androidx.recyclerview.widget.RecyclerView;

		import com.bumptech.glide.Glide;
		import com.bumptech.glide.Priority;
		import com.bumptech.glide.load.engine.DiskCacheStrategy;
		import com.java.constant.AppConstants;
		import com.java.model.'.$table_namewe.'_Model;
		import com.java.util.Constant;
		import com.knowtechnical.parbhanimarket.R;
		import java.util.ArrayList;

		public class '.$table_namewe.'_Adapter extends RecyclerView.Adapter<'.$table_namewe.'_Adapter.'.$table_namewe.'ViewHolder>{

			private ArrayList<'.$table_namewe.'_Model> xxModelArrayList;
			private Activity activity;

			OnLoadMoreListener loadMoreListener;
			boolean isLoading = false, isMoreDataAvailable = true;

			public '.$table_namewe.'_Adapter(Activity activity, ArrayList<'.$table_namewe.'_Model> data)   {
				this.activity = activity;
				this.xxModelArrayList = data;
			}

			@Override
			public '.$table_namewe.'ViewHolder onCreateViewHolder(ViewGroup viewGroup, int viewType) {
				View itemview = null;

				if(viewType == 1) {
					itemview = LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.adapter_plot, viewGroup, false);
				}else{
					itemview = LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.row_load, viewGroup, false);
				}

				final '.$table_namewe.'ViewHolder viewHolder = new '.$table_namewe.'ViewHolder(itemview);
				// Click event
				itemview.setOnClickListener(new View.OnClickListener() {
					@Override
					public void onClick(View v) {
						int position = viewHolder.getAdapterPosition();
						'.$table_namewe.'_Model xxModel = xxModelArrayList.get(position);

					}
				});

				return viewHolder;
			}

			@Override
			public int getItemViewType(int position) {
				if(xxModelArrayList.get(position).getLayoutType().equals(AppConstants.NORMAL_TYPE)){
					return 1;
				}else{
					return 2;
				}
			}

			@Override
			public void onBindViewHolder('.$table_namewe.'ViewHolder orderHistoryViewHolder, int position) {
				if(position >= getItemCount()-1 && isMoreDataAvailable && !isLoading && loadMoreListener != null){
					isLoading = true;
					loadMoreListener.onLoadMore();
				}

				if(xxModelArrayList.get(position).getLayoutType().equalsIgnoreCase(AppConstants.NORMAL_TYPE))
					orderHistoryViewHolder.bindOrderPharmacy(xxModelArrayList.get(position), position);
			}

			@Override
			public int getItemCount() {
				return xxModelArrayList.size();
			}

			public class '.$table_namewe.'ViewHolder extends RecyclerView.ViewHolder {
				'.$java_textview_adapter.'
				CardView mainCardLayout;

				Button plotHeart;
				'.$table_namewe.'ViewHolder(View itemView) {
					super(itemView);

					'.$java_init_textview_adapter.'
				}

				void bindOrderPharmacy(final  '.$table_namewe.'_Model searchProductModel, int position)
				{

					'.$java_set_textview_adapter.'
				/* plotHeading.setText(""+searchProductModel.getHeading());
				plotType.setText(""+searchProductModel.getType());
				Glide.with(activity)
						.load(Constant.IMAGE_LOAD_URL + searchProductModel.getImage_path())
						.asBitmap().skipMemoryCache(false)
						.diskCacheStrategy(DiskCacheStrategy.ALL)
						.priority(Priority.IMMEDIATE)
						.placeholder(ContextCompat.getDrawable(activity, R.drawable.app_icon))
						.into(plotImage);
					plotHeart.setOnClickListener(v -> {

					});*/
				}


    		}

			public void refreshList(){
				notifyDataSetChanged();
				isLoading = false;
			}

			public interface OnLoadMoreListener{
				void onLoadMore();
			}

			public void setMoreDataAvailable(boolean moreDataAvailable) {
				isMoreDataAvailable = moreDataAvailable;
			}

			public void setLoadMoreListener(OnLoadMoreListener loadMoreListener) {
				this.loadMoreListener = loadMoreListener;
			}

		}
		</xmp>		';
		$xml_page = '
		<xmp>
		**************************************************************************************************************
		XML
		---
		<?xml version="1.0" encoding="utf-8"?>
		<androidx.cardview.widget.CardView xmlns:android="http://schemas.android.com/apk/res/android"
			android:id="@+id/mainCardLayout"
			android:layout_height="wrap_content"
			android:layout_width="match_parent"
			xmlns:app="http://schemas.android.com/apk/res-auto" 
			app:cardElevation="5dp"
			android:layout_margin="5dp"
			android:layout_marginRight="1dp"
			android:foreground="?android:attr/selectableItemBackground"
			android:clickable="true">
			<LinearLayout
				android:layout_width="match_parent"
				android:layout_height="wrap_content"
				android:orientation="vertical">
				'.$xml_element.'
			</LinearLayout>
			</androidx.cardview.widget.CardView>

			*****************************************
			activity xml
			------
			<androidx.recyclerview.widget.RecyclerView
			android:id="@+id/listRecylce"
			android:layout_width="match_parent"
			android:layout_height="match_parent"
			android:layout_below="@+id/propertyText"
			android:layout_marginBottom="@dimen/dimen_10dp"
			/>

		</xmp>';

		$php_page = "
		<xmp>
		**************************************************************************************************************
		PHP API
		---
		public function ".$table_namewe."_POST(){
			\$response = array();
			\$where = array();
			\$results = \$this->ApiMdl->view_data('$table_namewe', \$where);
			\$response['data'] = \$results;
			\$response['status'] = 'success';
			\$response['count'] = count(\$results);
			\$response['scroll_more'] = count(\$results) == 100;
			\$response['next'] = 10;
			\$this->response(\$response);
		}</xmp>
		";

		$java_activity = '
		<xmp>
		**************************************************************************************************************
		Android Activity
		---
		package com.knowtechnical.parbhanimarket;

		import androidx.appcompat.app.AppCompatActivity;
		import androidx.appcompat.widget.Toolbar;
		import androidx.recyclerview.widget.DefaultItemAnimator;
		import androidx.recyclerview.widget.GridLayoutManager;
		import androidx.recyclerview.widget.RecyclerView;

		import android.app.Activity;
		import android.content.Intent;
		import android.net.Uri;
		import android.os.Bundle;
		import android.util.Log;
		import android.view.View;
		import android.widget.TextView;

		import com.android.volley.DefaultRetryPolicy;
		import com.android.volley.RequestQueue;
		import com.android.volley.toolbox.StringRequest;
		import com.java.adapter.'.$table_namewe.'_Adapter;
		import com.java.constant.AppConstants;
		import com.java.database.DataBaseHelper;
		import com.java.model.'.$table_namewe.'_Model;
		import com.java.util.Constant;
		import com.java.util.SingletonRequestQueue;

		import org.json.JSONArray;
		import org.json.JSONException;
		import org.json.JSONObject;

		import java.util.ArrayList;
		import java.util.HashMap;
		import java.util.Map;

		import static com.android.volley.Request.Method.POST;

		public class RealEstateListActivity extends AppCompatActivity {
			RecyclerView listRecylce;
			'.$table_namewe.'_Adapter listAdapter;
			ArrayList<'.$table_namewe.'_Model> adapterArrayList = new ArrayList<>();

			String next_page = "1";
			Boolean scroll_more = false; 

			String mobileNo = "";

			@Override
			protected void onCreate(Bundle savedInstanceState) {
				super.onCreate(savedInstanceState);
				setContentView(R.layout.activity_real_estate_list);

				Init();
			}

			private void Init() {


				listRecylce = findViewById(R.id.listRecylce);


				listAdapter = new '.$table_namewe.'_Adapter(this, adapterArrayList);
				listRecylce.setLayoutManager(new GridLayoutManager(this, 2));
				listRecylce.setItemAnimator(new DefaultItemAnimator());
				listRecylce.setAdapter(listAdapter);

				/*listAdapter.setLoadMoreListener(new '.$table_namewe.'_Adapter.OnLoadMoreListener() {

					@Override
					public void onLoadMore() {

						listRecylce.post(new Runnable() {
							@Override
							public void run() {
								int index = adapterArrayList.size() - 1;
								loadMore(index);// a method which requests remote data
							}
						});
						//Calling loadMore function in Runnable to fix the
						// java.lang.IllegalStateException: Cannot call this method while RecyclerView is computing a layout or scrolling error
					}
				});*/

				HashMap hashMap=new HashMap();
				hashMap.put("page", "1");
				getPlotList(hashMap);
			}

			public void loadMore(int index){

				if(scroll_more) {
					'.$table_namewe.'_Model product = new '.$table_namewe.'_Model();
					product.setLayoutType(AppConstants.LOAD_TYPE);
					adapterArrayList.add(product);
					listAdapter.notifyItemInserted(adapterArrayList.size() - 1);

					HashMap params = new HashMap();
					params.put("page", next_page);

					RequestQueue queue = SingletonRequestQueue.getInstance(this).getRequestQueue();
					StringRequest stringRequest = new StringRequest(POST, Constant.PLOT_API, response -> {

						Log.d("loadMore", response);

						try {
							loadMorePage(response);
						} catch (JSONException e) {

							//remove loading view
							adapterArrayList.remove(adapterArrayList.size() - 1);
							listAdapter.refreshList();

							Log.d("OfferError", "" + e);
						}

					}, volleyError -> {

						//remove loading view
						adapterArrayList.remove(adapterArrayList.size() - 1);
						listAdapter.refreshList();

						Log.d("OfferError", "" + volleyError);
					}
					) {
						@Override
						protected Map<String, String> getParams() {
							return params;
						}

						@Override
						public Map<String, String> getHeaders() {
							HashMap<String, String> headers = new HashMap<>();
							headers.put("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
							return headers;
						}
					};

					stringRequest.setRetryPolicy(new DefaultRetryPolicy(
							Constant.VolleyTime,
							DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
							DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
					queue.add(stringRequest);
				}

			}

			private void getPlotList(Map<String,String> params) {

				Log.d("getPlotList", Constant.PLOT_API+" : "+params);

				//Show user some operation is going on.

				RequestQueue queue = SingletonRequestQueue.getInstance(this).getRequestQueue();
				StringRequest stringRequest = new StringRequest(POST, Constant.PLOT_API, response ->  {

					Log.d("getPlotList",response);

					try {
						listingPage(response);
					} catch (JSONException e) {
						Log.d("getPlotList", ""+e);
					}

				}, volleyError -> {
					Log.d("getPlotList", ""+volleyError);
				}
				)
				{
					@Override
					protected Map<String, String> getParams() {
						return params;
					}

					@Override
					public Map<String, String> getHeaders() {
						HashMap<String, String> headers = new HashMap<>();
						headers.put("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
						return headers;
					}
				};

				stringRequest.setRetryPolicy(new DefaultRetryPolicy(
						Constant.VolleyTime,
						DefaultRetryPolicy.DEFAULT_MAX_RETRIES,
						DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
				queue.add(stringRequest);

			}

			private void listingPage(String response) throws JSONException {
				Activity activity = this;
				if(activity != null && new JSONObject(response).optJSONArray("data")!=null && new JSONObject(response).optJSONArray("data").length()>0)
				{
					DataBaseHelper db=new DataBaseHelper(activity);
					JSONObject jsonObj = new JSONObject(response);
					next_page = jsonObj.optString("next");
					scroll_more = jsonObj.optBoolean("scroll_more");

					JSONArray products = new JSONObject(response).optJSONArray("data");
					for (int i = 0; i < products.length(); i++) {
						JSONObject jsonItem = products.getJSONObject(i);

						'.$table_namewe.'_Model model = new '.$table_namewe.'_Model();

						'.$java_activity_json.'
						'.$java_activity_set.'

						model.setLayoutType(AppConstants.NORMAL_TYPE);
						adapterArrayList.add(model);
					}

					listAdapter.notifyDataSetChanged();

			 

					//new ProductPage().execute();
		//            hideProgressNotification();

				} else {
		//            showNoProductFound();
				}

		//        hideProgressNotification();

			}

			private void loadMorePage(String response) throws JSONException {

				JSONObject jsonObj = new JSONObject(response);

				//Removing load
				if(jsonObj != null && jsonObj.optString("status") != null && jsonObj.optString("status").equals("success")) {
					next_page = jsonObj.optString("next");
					scroll_more = jsonObj.optBoolean("scroll_more");
					listAdapter.setMoreDataAvailable(scroll_more);

					//remove loading view
					adapterArrayList.remove(adapterArrayList.size() - 1);
					listAdapter.refreshList();
				}

				if(new JSONObject(response).optJSONArray("data")!=null && new JSONObject(response).optJSONArray("data").length()>0)
				{
					JSONArray products = new JSONObject(response).optJSONArray("data");

					for (int i = 0; i < products.length(); i++) {
						JSONObject jsonItem = products.getJSONObject(i);

						'.$table_namewe.'_Model model = new '.$table_namewe.'_Model();
						
						'.$java_activity_json.'
						'.$java_activity_set.'
					
						model.setLayoutType(AppConstants.NORMAL_TYPE);
						adapterArrayList.add(model);
					}


					listAdapter.refreshList();


				} else {
		//            showNoProductFound();
				}

			}

		}</xmp>
		';

		//$data .= "for(\$k=0;\$k<\$total_rows;\$k++)<br>";
		$data .= $xml_page;
		$data .= $java_model_page;
		$data .= $java_adapter_page;
		$data .= $php_page;
		$data .= $java_activity;

		$data .= "<br><div class='syntax'>";
		$init_vars = "private EditText";
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
				$seqvalue=$_REQUEST['variable'.$seq];
				$data.=" ".$seqvalue." = findViewById(R.id.".$seqvalue.");<br>"	;
				$init_vars.=" ".$seqvalue.",";
			}//End inner if
		} //End For Loop
		$data.= $init_vars;
		$data.= "</div>";
	
	}//End Main If



	if($lang=='PHP' && $type=='forloopadb')
	{	

		$data .= "for(\$k=0;\$k<\$total_rows;\$k++)<br>";
		$data .= "{<br><div class='syntax'>";
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
				$seqvalue=$_REQUEST['variable'.$seq];
				$data.="\$".$seqvalue."=\$adb->query_result(\$result,\$k,'".$seqvalue."');<br>"	;
							
			}//End inner if
		} //End For Loop
		$data.= "</div>}";
	
	}//End Main If


	//INSERTQUERY PHP
	if($lang=='PHP' && $type=='insertquery')
	{	

		$data .= "<br><div class='syntax'>";
		$comma=',';
		$counter=0;
		$columns='';
		$columns_values='';
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
				

				$seqvalue=$_REQUEST['variable'.$seq];
				if($counter==0)
				{
					$columns="".$seqvalue."".$columns;
					$columns_values=".\$".$seqvalue.".\"'".$columns_values;
				}	
				else
				{
					$columns=$columns."".$comma."".$seqvalue."";
					$columns_values="".$columns_values."".$comma."'\".\$".$seqvalue.".\"'";

				}
				$counter++;
							
			}//End inner if
		} //End For Loop
		$data .= "\"INSERT INTO tablename(".$columns.") VALUES('\"".$columns_values.")\";";	

		$data.= "</div>";
	
	}//End Main If
	//END INSERQUERY PHP


	//UPDATEQUERY PHP
	if($lang=='PHP' && $type=='updatequery')
	{	

		$data .= "<br><div class='syntax'>";
		$comma=',';
		$counter=0;
		$columns='';
		$columns_values='';
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
				

				$seqvalue=$_REQUEST['variable'.$seq];
				if($counter==0)
				{
					$columns="".$seqvalue."= '\".\$".$seqvalue.".\"' <BR>";
					$columns_values=".\$".$seqvalue.".\"'".$columns_values;
				}	
				else
				{
					$columns=$columns."".$comma."".$seqvalue."='\".\$".$seqvalue.".\"' <BR>";
					$columns_values="".$columns_values."".$comma."'\".\$".$seqvalue.".\"'";

				}
				$counter++;
							
			}//End inner if
		} //End For Loop
		$relid="\".\$relid.\"";
		$data .= "\"UPDATE tablename SET ".$columns." 
					WHERE relid='".$relid."' \";";	

		$data.= "</div>";
	
	}//End Main If
	//END UPDATEQUERY PHP

	if($lang=='Javascript' && $type=='validation')
	{	

		$data .= "<br><div class='syntax'>";
		$colon=':';
		$counter=0;
		$columns='';
		$columns_values='';
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
					$seqvalue=$_REQUEST['variable'.$seq];
					if($counter==0)
					{
					$columns="".$seqvalue."".$colon."'".$seqvalue."'".$columns;
					//$columns_values="".$columns_values."".$comma."'\".\$".$seqvalue.".\"'";
					}
					else
					{
						$columns=$columns.",".$seqvalue."".$colon."'".$seqvalue."'";
					}
					$counter++;
			
				
							
			}//End inner if
		} //End For Loop
		$data .= "&nbsp;var variables={".$columns."};<br>";	
		$data .="&nbsp;var alerts=0;<br>
					for (var key in variables) <br>
					{<br>
				        &nbsp;var value = variables[key];<br>
						&nbsp;var element=document.getElementById(value);<br>
						<div style='padding-left:1%;'>	
						if(element!=window.undefined)<br>
						{<br>
						&nbsp;&nbsp;if(document.getElementById(value).value=='')<br>
						&nbsp;&nbsp;{
							 &nbsp;&nbsp;alert('You alert your message');<br>
							 &nbsp;&nbsp;document.getElementById(value).focus();<br>
							 &nbsp;&nbsp;alerts=alerts+1;<br>
							 &nbsp;&nbsp;break;<br>
						&nbsp;&nbsp;}<br>
						}
						else<br>
						{<br>
							&nbsp;alert('Element '+value+' is not defined');<br>
						}<br>
						</div>
				     }<br>
					if(alerts>0)<br>
					{<br>
						&nbsp;return false;<br>	
					}<br>
					else if(alerts==0)<br>
					{
						&nbsp;return true;<br>
					}";	

		$data.= "</div>";
	
	}


	if($lang=='Javascript' && $type=='Ajax')
	{	

		$data .= "<br><div class='syntax'>";
		$colon='=';
		$counter=0;
		$columns='';
		$columns_values='';
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
					$seqvalue=$_REQUEST['variable'.$seq];
					if($counter==0)
					{
					$columns="".$seqvalue."".$colon."'+".$seqvalue."+'".$columns;
					//$columns_values="".$columns_values."".$comma."'\".\$".$seqvalue.".\"'";
					}
					else
					{
						$columns=$columns."".$seqvalue."".$colon."'+".$seqvalue."+'";
					}
					$test=$totalrow-1;
					if($counter==$test)
					{
						$columns=$columns."'";
					}
					$counter++;
			
				
							
			}//End inner if
		} //End For Loop
		
		echo $columns;
	}
	if($lang=='PHP' && $type=='Adb Query Code')
	{	

		$data .= "<br><div class='syntax'>";
		$colon=',';
		$counter=0;
		$columns='';
		$columns_values='';
		$first="";
		$cols_php="";
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
					$seqvalue=$_REQUEST['variable'.$seq];

					if($counter==0)
					{
						$first="$".$seqvalue."_query = \"SELECT ";
						$firstvalue=$seqvalue;
					}
					else if($counter==1)
					{
						$tablename=$seqvalue;
					}
					else if($counter==2)
					{

					$columns="".$seqvalue."";
					$cols_php.="&nbsp;\$".$seqvalue."=\$adb->query_result(\$".$firstvalue."_result,\$k,\"".$seqvalue."\");<br>"	;
					//$columns_values="".$columns_values."".$comma."'\".\$".$seqvalue.".\"'";
					}
					else
					{
						$columns=$columns.",".$seqvalue."";
						$cols_php.="&nbsp;\$".$seqvalue."=\$adb->query_result(\$".$firstvalue."_result,\$k,\"".$seqvalue."\");<br>"	;
					}
					$counter++;
			
						
						
			}//End inner if

		} //End For Loop
		$query=$first.$columns." FROM ".$tablename."\";<BR>//echo \$".$firstvalue."_query;";
		$query_result="\$".$firstvalue."_result = \$adb->query(\$".$firstvalue."_query);";
		$query_rows="\$".$firstvalue."_rows = \$adb->num_rows(\$".$firstvalue."_result);";
		$forloop="for(\$k=0;\$k<\$".$firstvalue."_rows;\$k++)<BR> {";
		$data=$query."<BR>".$query_result."<BR>".$query_rows."<BR>".$forloop."<BR>".$cols_php." }";

	}

	if($lang=='PHP' && $type=='insert with query')
	{	

		$data .= "<br><div class='syntax'>";
		$colon=',';
		$counter=0;
		$columns='';
		$columns_values='';
		$first="";
		$cols_php="";
		$request_columns="";
		$insert_columns="";
		$insert_columns_values="";
		$where_firstvalue="";
		$update_columns="";
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
					$seqvalue=$_REQUEST['variable'.$seq];

					if($counter==0)
					{
						$first="$".$seqvalue."_query = \"SELECT ";
						$firstvalue=$seqvalue;
					}
					else if($counter==1)
					{
						$tablename=$seqvalue;
					}
					else if($counter==2)
					{
						$where_firstvalue=$seqvalue;
					}
					else if($counter==3)
					{

					$columns="".$seqvalue."";
					$cols_php.="&nbsp;\$".$seqvalue."=\$adb->query_result(\$".$firstvalue."_result,\$k,\"".$seqvalue."\");<br>"	;
					//$columns_values="".$columns_values."".$comma."'\".\$".$seqvalue.".\"'";
					$request_columns=$request_columns."\$".$seqvalue."="."\$_REQUEST['".$seqvalue."']; <BR>";
					$insert_columns_values="'\".\$".$seqvalue.".\"'";
					$update_columns=$update_columns."".$seqvalue."= '\".\$".$seqvalue.".\"' <BR>";
					}
					else
					{
						$columns=$columns.",".$seqvalue."";
						$request_columns=$request_columns."\$".$seqvalue."="."\$_REQUEST['".$seqvalue."']; <BR>";
						$insert_columns_values=$insert_columns_values.",'\".\$".$seqvalue.".\"'";
						$update_columns=$update_columns.",".$seqvalue."= '\".\$".$seqvalue.".\"' <BR>";	
						$cols_php.="&nbsp;\$".$seqvalue."=\$adb->query_result(\$".$firstvalue."_result,\$k,\"".$seqvalue."\");<br>"	;
					}
					$counter++;
			
						
						
			}//End inner if

		} //End For Loop
	//	$query=$first.$columns." FROM ".$tablename."\";<BR>//echo \$".$firstvalue."_query;";
	//	$query_result="\$".$firstvalue."_result = \$adb->query(\$".$firstvalue."_query);";
	//	$query_rows="\$".$firstvalue."_rows = \$adb->num_rows(\$".$firstvalue."_result);";
	//	$forloop="for(\$k=0;\$k<\$".$firstvalue."_rows;\$k++)<BR> {";
	//	$data=$query."<BR>".$query_result."<BR>".$query_rows."<BR>".$forloop."<BR>".$cols_php." }";
		

		$insert_columns=$columns;
		$data.= "".$request_columns;
		$data.="<BR>\$select_query=\"SElECT ".$where_firstvalue." FROM ".$tablename." WHERE ".$where_firstvalue."='\".\$".$where_firstvalue.".\"'\";<BR> 
				//echo \$select_query;
				<BR> \$select_result=\$adb->query(\$select_query);
				<BR> \$select_rows=\$adb->num_rows(\$select_result);
				<BR> if(\$select_rows<=0)
				{		

			";	
		$data.= "<BR> \$".$firstvalue."_query=\"INSERT ".$tablename."(".$insert_columns.")
			  <BR> VALUES(".$insert_columns_values.") \"; <BR> //echo \$".$firstvalue."_query;
			 
			  <BR>	}	
			  <BR> else {
			  <BR> 	 \$".$firstvalue."_query=\"UPDATE ".$tablename." SET
			  <BR>	".$update_columns."
			  <BR>  WHERE  ".$where_firstvalue."='\".\$".$where_firstvalue.".\"' \";
			  <BR> <BR> //echo \$".$firstvalue."_query;
			  <BR>	}
			   <BR> \$".$firstvalue."_result=\$adb->query(\$".$firstvalue."_query);
			   <BR>";
	}


	if($lang=='NET' && $type=='NET Retrieve')
	{	

		//$data .= "for(\$k=0;\$k<\$total_rows;\$k++)<br>";
		$data .= "<br><div class='syntax'>";
		$columns="";
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
				$seqvalue=$_REQUEST['variable'.$seq];
				//$data.="\$".$seqvalue."=\$adb->query_result(\$result,\$k,'".$seqvalue."');<br>"	;
				$columns.='<pre>                                   emps.'.$seqvalue.'=rdr["'.$seqvalue.'"].ToString();</pre>';			
			}//End inner if
		} //End For Loop
		$data.=' 
		<pre>public IEnumerable &lt;Change&gt; Employees  {
            get
            {
                string connectionstring = ConfigurationManager.ConnectionStrings["ChangeContext"].ConnectionString;
                List&lt;Change&gt; emp = new List&lt;Change&gt;();

                using(SqlConnection conn=new SqlConnection(connectionstring))
                {
                    SqlCommand cmd = new SqlCommand("SELECT * FROM Change", conn);
                  //  cmd.CommandType = CommandType.StoredProcedure;
                    conn.Open();
                    SqlDataReader rdr = cmd.ExecuteReader();
                    while (rdr.Read())
                    {
				     Change emps = new Change();
							'.$columns.'
				     emp.Add(emps);    
                    }


                    
                }

                return emp;
            }
        }</pre>
		<div style="background:yellow;color:black;">
		Please do change the datatype with respect to your need in WHILE loop 
		</div>
					';
		
		//$data.= "</div>}";
	
	}//End Main If
	if($lang=='NET' && $type=='NET Insert')
	{	

		//$data .= "for(\$k=0;\$k<\$total_rows;\$k++)<br>";
		$data .= "<br><div class='syntax'>";
		$columns="";
		$counter=0;
		$procedure_columns="";
		$procedure_values="";
		$procedure_declares="";
		$comma=",";
		$at=",";
		$previous=$totalrow-1;
		for($i=0;$i<$totalrow;$i++)
		{	
			$seq=$seq+1;
			
			if(isset($_REQUEST['deltedstatus'.$seq]) && $_REQUEST['deltedstatus'.$seq]!='D')
			{
				$seqvalue=$_REQUEST['variable'.$seq];
				//$data.="\$".$seqvalue."=\$adb->query_result(\$result,\$k,'".$seqvalue."');<br>"	;
				$columns.='<br>
						   SqlParameter '.$seqvalue.' = new SqlParameter();
						   '.$seqvalue.'.ParameterName = "@'.$seqvalue.'";
						   '.$seqvalue.'.Value = emp.'.$seqvalue.';
						   cmd.Parameters.Add('.$seqvalue.');';	
				if($counter==$previous)	
				{
					$procedure_declares.="<br>                @".$seqvalue." varchar(500)";
				}
				else				
				{
					$procedure_declares.="<br>                @".$seqvalue." varchar(500),";
				}

				if($counter==0)
				{
					$procedure_columns="".$seqvalue."".$procedure_columns;
					$procedure_values="@".$seqvalue."".$procedure_values;
					 
				}	
				else
				{
					$procedure_columns=$procedure_columns."".$comma."".$seqvalue."";
					$procedure_values=$procedure_values."".$at."@".$seqvalue."";
					 
				}
				$counter++;
				
			}//End inner if
		} //End For Loop
		$data.=' 
		<pre>  public void Add(Employee emp)
        {
                
                string connectionstring = ConfigurationManager.ConnectionStrings["EmployeeContext"].ConnectionString;
               // List<Employee> emp = new List<Employee>();

                using (SqlConnection conn = new SqlConnection(connectionstring))
                {
                    SqlCommand cmd = new SqlCommand("addemployee", conn);
                    cmd.CommandType = CommandType.StoredProcedure;

					'.$columns.'
                    

                    conn.Open();
                    cmd.ExecuteNonQuery();

                }
        }
		==============================================================================
		//Stored Procedure 
		CREATE PROCEDURE addemployee
		'.$procedure_declares.'
		AS
		BEGIN
		 INSERT INTO Employee('.$procedure_columns.') VALUES('.$procedure_values.')
		END
		</pre>
		<div style="background:yellow;color:black;">
		Please do change the datatype,object and tablename  with respect to your need in Stored Procedure 
		</div>
		';
		
		//$data.= "</div>}";
	
	}//End Main If	

	
	
	
	return $data;
	
}

?>