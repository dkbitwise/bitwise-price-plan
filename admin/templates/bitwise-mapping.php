<?php

	global $wpdb;
	$courseid=$_GET['id'];
	$coursemapping = $wpdb->prefix.'course_mapping';
	$product_ids = $wpdb->get_results( $wpdb->prepare( "SELECT product_ids FROM $coursemapping  where course_id='$courseid'" ) );
	$postids=unserialize($product_ids[0]->product_ids);

	
	if($_POST['course_id']){
		$productid=$_POST['productid'];
		$courseid=$_POST['course_id'];
		
		$total = $wpdb->get_results( $wpdb->prepare( "SELECT count(*) as total FROM $coursemapping  where course_id='$courseid'" ) );
		
		
		
	if ($total[0]->total==0) {


		$data = array('course_id' => $courseid,'product_ids'=>serialize($productid));


    	$wpdb->insert($coursemapping,$data);
		}else{

		$product_ids = $wpdb->get_results( $wpdb->prepare( "SELECT product_ids FROM $coursemapping  where course_id='$courseid'" ) );
		
		$postids=unserialize($product_ids[0]->product_ids);
		
		if($remove==1){

			$array_without_id = array_diff($postids, $productid);
		
		
		}else{
		
			
		array_push($postids,$productid[0]);
		}
		
		$productids=serialize($postids);
		$where['course_id'] = $courseid;	
		$updatedata = array('product_ids' => $productids);
		

		$wpdb->update( $coursemapping, $updatedata, $where );
	}
	}

 if($_GET['id']){
	
	$post   = get_post( $_GET['id']);
	
	$html='<h2>Course Name: '.$post->post_title.'</h2>';
	 $args = array(
	 	'post_status'   => 'publish',
            'post_type' => 'product',
             'orderby'   => 'post_title',
        	 'order' => 'ASC',
            'posts_per_page' => -1
            );
        $products = new WP_Query( $args );

		$html.='<table class="wp-list-table widefat fixed striped pages"><thead><tr><td>S.No</td><td>Product Name</td><td>Action</td></tr></thead>';
 	if ( $products->post_count > 0 ) {
 		$i=1;
 		foreach ( $products->posts as $available_course ) {
 	

 			$html.='<tr><td>'.$i++.'</td><td>'.$available_course->post_title.'</td><td>';
 			$html.='<form action="" method="post"><input type="hidden" value="'.$_GET['id'].'" name="course_id"><input type="hidden" value="'.$available_course->ID.'" name="productid[]">';
 			if(in_array( $available_course->ID ,$postids ) )
		{
 			$html.='<input type="hidden" value="1" name="remove">';
 			$html.='<input type="submit" value="Remove"></form></tr>';
 		}else{

 			$html.='<input type="submit" value="Add"></form></tr>';
 		}


 		}

 	}
 		$html.='</table>';

 		echo $html;
      
 }else{
 	$argsnew= array(
				'post_status'   => 'publish',
				'post_type'     => 'lp_course',
				'posts_per_page' => '-1'
			);
	$available_courses = new WP_Query( $argsnew );

	
		$html='<table class="wp-list-table widefat fixed striped pages"><thead><tr><td>S.No</td><td>Course Name</td><td>Action</td></tr></thead>';
 	if ( $available_courses->post_count > 0 ) {
 		$i=1;
 		foreach ( $available_courses->posts as $available_course ) {
 	$course_url = add_query_arg( array(
	'page'   => 'bitwise-course-mapping',
	'action' => 'edit',
	'id' => $available_course->ID,
), admin_url( 'admin.php' ) );

 			$html.='<tr><td>'.$i++.'</td><td>'.$available_course->post_title.'</td><td><a href="'.$course_url.'" class="button">Add mapping</a></tr>';


 		}

 	}
 		$html.='</table>';

 		echo $html;

 	}




















?>