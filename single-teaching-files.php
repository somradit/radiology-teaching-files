<?php get_header(); ?>

<div class="container uw-body">

  <div class="row">

    <div class="col-md-8 uw-content" role='main'>

    	<h2 class="uw-site-title"><?php get_uw_post_title();?></h2>
    	
    	 <?php if (is_front_page()) { get_template_part( 'menu', 'mobile' ); }?>

	      <div id='main_content' class="uw-body-copy" tabindex="-1">
		       <h1><?php echo get_the_title()?></h1>
			   <?php if(get_field( 'contributed_by' ) != ""):
					echo '<p style="font-size:12px">Contributed by: ' . get_field( 'contributed_by' ) . ' - ' . get_field( 'date_created' ) . '</p>';
					endif;
				the_field( 'question_1' );
				$choices = explode(",", get_field( 'question_1_choices' ));
				foreach ($choices as $value) {
					echo '<input type="radio" name="choices1" value="'.$value.'">'.$value.'<br>';
				}?>
				<div id="answer1" style="display:none"><b><?php the_field( 'question_1_answer' )?></b><br>
					<?php the_field( 'question_1_explanation' );?>
				</div>
				<?php if(get_field('question_2')!=""):?>
				<div id="question2" style="display:none">
					<?php the_field( 'question_2' );
					$choices = explode(",", get_field( 'question_2_choices' ));
					foreach ($choices as $value) {
						echo '<input type="radio" name="choices2" value="'.$value.'">'.$value.'<br>';
					}?>
					<div id="answer2" style="display:none"><b><?php the_field( 'question_2_answer' )?></b><br>
					<?php the_field( 'question_2_explanation' );?>
					</div>
				</div>
				<?php endif;?>
				<?php if(get_field('question_3')!=""):?>
				<div id="question3" style="display:none">
					<?php the_field( 'question_3' );
					$choices = explode(",", get_field( 'question_3_choices' ));
					foreach ($choices as $value) {
						echo '<input type="radio" name="choices3" value="'.$value.'">'.$value.'<br>';
					}?>
					<div id="answer3" style="display:none"><b><?php the_field( 'question_3_answer' )?></b><br>
					<?php the_field( 'question_3_explanation' );?>
					</div>
				</div>
				<?php endif;?>
				<?php if(get_field('question_4')!=""):?>
				<div id="question4" style="display:none">
					<?php the_field( 'question_4' );
					$choices = explode(",", get_field( 'question_4_choices' ));
					foreach ($choices as $value) {
						echo '<input type="radio" name="choices4" value="'.$value.'">'.$value.'<br>';
					}?>
					<div id="answer4" style="display:none"><b><?php the_field( 'question_4_answer' )?></b><br>
					<?php the_field( 'question_4_explanation' );?>
					</div>
				</div>
				<?php endif;?>
				<?php if(get_field('question_5')!=""):?>
				<div id="question5" style="display:none">
					<?php the_field( 'question_5' );
					$choices = explode(",", get_field( 'question_5_choices' ));
					foreach ($choices as $value) {
						echo '<input type="radio" name="choices5" value="'.$value.'">'.$value.'<br>';
					}?>
					<div id="answer5" style="display:none"><b><?php the_field( 'question_5_answer' )?></b><br>
					<?php the_field( 'question_5_explanation' );?>
					</div>
				</div>
				<?php endif;?>
		     
		
		</div>
      	
   
	</div>
	<div class="col-md-4 uw-sidebar">
	<nav id="desktop-relative" role="navigation" aria-label="relative">
	<ul class="uw-sidebar-menu first-level">
	<li class="pagenav">
	<a href="https://rad.washington.edu" title="Home" class="homelink">Home</a>
	<ul>
		<?php if (get_field('archived') == '1'):?>
			<li class="page_item current_page_ancestor current_page_parent"><a href="https://rad.washington.edu/teaching-files-archive/">Teaching Files Archive</a>
		<?php else:?>
			<li class="page_item current_page_ancestor current_page_parent"><a href="https://rad.washington.edu/teaching-files/">Teaching Files</a>
		<?php endif;?>
			<ul class="children">
			<?php
			if (get_field('archived') == '1'):
				$args = array(
				'numberposts'	=> -1,
				'post_type'	=> 'teaching-files',
				'meta_key'        => 'order',
				'orderby'	 => 'meta_value_num',
				'order'          => 'ASC',
				'meta_query' => array(
				   'key' => 'archived',
				   'compare' => '==',
					'value' => '1',
					),
				);
			else:
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
			endif;
			// query
			$the_query = new WP_Query( $args );
			$the_query;
			$PID = $post->ID;
			if( $the_query->have_posts() ):
				while( $the_query->have_posts() ) : $the_query->the_post();
				if($PID == $post->ID){?>
					<li class="page_item current_page_item"><span><?php echo the_title();?></span>
				<?php
				} else{?>
					<li class="page_item"><a href="<?php the_permalink()?>"><?php echo the_title()?></a></li>
				
			<?php
				} endwhile;
				endif;?>
			</ul>
		</li>
	</ul>
	</li>
	</ul>
	</nav>
	</div>
    </div>
</div>


<?php get_footer(); ?>
