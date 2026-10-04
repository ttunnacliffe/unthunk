<?php
global $t_one_opt;
$title = esc_html( $t_one_opt['extra_info_title'] );
$column1 = $t_one_opt['extra_info_column1'];
$column2 = $t_one_opt['extra_info_column2'];
?>
<section id="extra-info" class="space">
    <div class="overlay"></div>
    <div class="container">
        <div class="row"> 
        	<div class="col-sm-5">
                <h1><?php echo $title ?></h1>
            </div>
            <?php if( !empty($column1) && !empty($column2) ) { ?>
                <div class="col-sm-3 col-sm-offset-1">
                    <?php echo $column1 ?>
                </div>
                <div class="col-sm-3">
                    <?php echo $column2 ?>
                </div>
            <?php } else { ?>
				<?php if( !empty($column1) ) { ?>
                 <div class="col-sm-6 col-sm-offset-1">
                    <?php echo $column1 ?>
                </div>
                <?php } elseif( !empty($column2) ) { ?>
                	<?php echo $column2 ?>
                <?php } ?>            
            <?php } ?>
        </div>
    </div>
</section>