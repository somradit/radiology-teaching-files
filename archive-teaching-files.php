<?php get_header(); ?>

<div class="container uw-body">

  <div class="row">

    <div class="col-md-12 uw-content" role='main'>

    	<h2 class="uw-site-title"><?php get_uw_post_title();?></h2>
    	
    	 <?php if (is_front_page()) { get_template_part( 'menu', 'mobile' ); }?>

      <div id='main_content' class="uw-body-copy" tabindex="-1">
      <h1>Breast Imaging Teaching Files</h1> 
      
	  The UW Breast Imaging Teaching Files are designed for the education of radiology residents, fellows, and practicing radiologists. They are in an interactive, Q&A multiple choice question format. This includes basic mammography and breast ultrasound findings that all radiologists should be aware of.<br><br>
	  
	  New cases and content have recently been updated by Drs. Steven J. Rockoff and Diana L. Lam to reflect changes in medical knowledge, imaging technology and clinical practice.<br><br>
	  
	  These files are not meant to inform patients about treatments or management decisions. They were originally created by Katherine E. Dee, MD while she was a member of the faculty of the University of Washington Department of Radiology. These archived cases can be found <a href='https://rad.washington.edu/teaching-files-archive/'>here</a>. A report describing this work was published in the journal <a href="https://onlinelibrary.wiley.com/doi/10.1046/j.1365-2923.2002.134723.x">Medical Education.</a>.<br><br>
	  
	  You have permission to use the Breast Imaging Teaching Files for educational and research purposes, provided that you attribute the University of Washington and retain copyright notice with each use of each image. If you are interested in obtaining permission for any other use of these images, including commercial use, please contact the <a href="https://comotion.uw.edu/">UW CoMotion</a> at <a href="mailto:license@uw.edu">license@uw.edu</a>. For any other questions, please <a href="mailto:dllam@uw.edu">contact us</a>. <br><br>
	  
		      <?php
		$args = array(
			'numberposts'	=> -1,
			'post_type'	=> 'teaching-files',
			'meta_key'        => 'order',
			'orderby'	 => 'meta_value_num',
			'order'          => 'ASC',  
			'meta_query' => array(
				'relation' => 'OR',
				array(
				   'key' => 'archived',
				   'compare' => '!=',
					'value' => '1',
				),
				array(
					'key' => 'archived',
					'compare' => 'NOT EXISTS',
				),
				),
				
		);
		// query
		$the_query = new WP_Query( $args );
		$the_query;
		?>
		<br>
		<br>
		<ul style="float:left">
		<?php if( $the_query->have_posts() ): ?>
		
			<?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<li>
						<a href="<?php the_permalink(); ?>"><?php echo the_title()?></a>
					</li>
			<?php endwhile; ?>
		
		<?php endif; ?>
		</ul>
		<img src="/wp-content/uploads/2016/02/Breast_Home_Picture.jpg" style="max-width:700px;float:right">
		<?php wp_reset_query();?>
      	
    </div>
  </div>
 
</div>
</div>
<?php get_footer(); ?>
