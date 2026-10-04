<?php global $t_one_opt; ?>
<div id="cta-contact">
    <div class="container">
        <div class="row text-contact">
            <div class="col-md-12 text-center">
                <h3>
                    <?php echo $t_one_opt['contact_title']; ?>
                </h3>
            </div>
        </div>
    </div>
</div>
<section class="space" id="contact">
	<div class="container">
    	<div id="message"></div>
        <div class="row">
            <form method="post" action="<?php echo site_url() . '/wp-admin/admin-ajax.php' ?>" name="contactform" id="contactform">
                <div class="col-sm-6">
                    <fieldset>
                        <input name="name" type="text" id="name" size="30" value="" placeholder="Name" />
                        <br />
                        <input name="email" type="text" id="email" size="30" value="" placeholder="Email" />
                        <br />
                        <input name="phone" type="text" id="phone" size="30" value="" placeholder="Phone" />
                        <br />
                    </fieldset>
                </div>
                <div class="col-sm-6">
                    <fieldset>
                        <textarea name="comments" cols="40" rows="8" id="comments" placeholder="Message"></textarea>
                        <button type="submit" class="btn btn-green-border btn-lg" id="submit" value="submit" data-loader="<?php echo get_template_directory_uri() . '/images/loader.gif' ?>">Send Message</button>
                    </fieldset>
                </div>
                <?php if( $t_one_opt['rechapta'] == 1 & !empty( $t_one_opt['rechapta_public_key'] ) & !empty( $t_one_opt['rechapta_private_key'] ) ) { ?>
                   <div id="rechapta" class="col-sm-8 col-sm-offset-4">
						<?php $publickey = $t_one_opt['rechapta_public_key'];
                        echo recaptcha_get_html($publickey) ?>
                   </div>
                <?php } ?>
            </form>
        </div>
    </div>
</section>