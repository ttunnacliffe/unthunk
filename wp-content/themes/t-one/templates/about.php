<!-- ABOUT US -->
<?php
global $t_one_opt;
$title = esc_html( $t_one_opt['about_title'] );
$content = esc_html( $t_one_opt['about_content'] );
?>
<section id="about" class="space">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 text-center">
            	
				<?php if ( !empty( $title ) ) { ?>
            		<h2><?php echo $title; ?></h2>
                <?php } ?>
                
                <p class="divide-arrow">
                    <img src="<?php echo get_template_directory_uri() . '/images/wave1.png' ?>" alt="">
                </p>
                
                <?php if ( !empty( $content ) ) { ?>
            		<p><?php echo $content; ?></p>
                <?php } ?>
         	</div>
      	</div>
      	<!--.row-->
        <?php if($t_one_opt['about_members'] == 1) {
			get_template_part('templates/members');
		} ?>
	</div>
</section>