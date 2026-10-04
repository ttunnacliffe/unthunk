<?php
global $t_one_opt;
$title = esc_html( $t_one_opt['clients_title'] );
$content = esc_html( $t_one_opt['clients_content'] );
$button_url = esc_url( $t_one_opt['clients_button_url'] );
$button_text = esc_html( $t_one_opt['clients_button_text'] );
?>
<section id="clients" class="space">
	<div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h1><?php echo $title ?></h1>
                <p><?php echo $content ?></p>
                <div class="divide20"></div>
                <p>
                    <a href="<?php echo $button_url ?>" class="btn btn-white btn-lg"><?php echo $button_text ?></a>
                </p>
            </div>
            <!-- end col 4 -->
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-4">
                        <a href="<?php echo esc_url( $t_one_opt['client1_url'] ) ?>">
                            <img src="<?php echo esc_url( $t_one_opt['client1']['url'] ) ?>" alt="" class="img-responsive">
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?php echo esc_url( $t_one_opt['client2_url'] ) ?>">
                            <img src="<?php echo esc_url( $t_one_opt['client2']['url'] )?>" alt="" class="img-responsive">
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?php echo esc_url( $t_one_opt['client3_url'] ) ?>">
                            <img src="<?php echo esc_url( $t_one_opt['client3']['url'] ) ?>" alt="" class="img-responsive">
                        </a>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-sm-4">
                        <a href="<?php echo esc_url( $t_one_opt['client4_url'] ) ?>">
                            <img src="<?php echo esc_url( $t_one_opt['client4']['url'] ) ?>" alt="" class="img-responsive">
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?php echo esc_url( $t_one_opt['client5_url'] ) ?>">
                            <img src="<?php echo esc_url( $t_one_opt['client5']['url'] )?>" alt="" class="img-responsive">
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?php echo esc_url( $t_one_opt['client6_url'] ) ?>">
                            <img src="<?php echo esc_url( $t_one_opt['client6']['url'] ) ?>" alt="" class="img-responsive">
                        </a>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-sm-4">
                        <a href="<?php echo esc_url( $t_one_opt['client7_url'] ) ?>">
                            <img src="<?php echo esc_url( $t_one_opt['client7']['url'] ) ?>" alt="" class="img-responsive">
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?php echo esc_url( $t_one_opt['client8_url'] ) ?>">
                            <img src="<?php echo esc_url( $t_one_opt['client8']['url'] )?>" alt="" class="img-responsive">
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?php echo esc_url( $t_one_opt['client9_url'] ) ?>">
                            <img src="<?php echo esc_url( $t_one_opt['client9']['url'] ) ?>" alt="" class="img-responsive">
                        </a>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end col 8 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>