<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="um-unsplash-modal-overlay">
	<div class="large um-unsplash-modal">
		<div class="um-unsplash-modal-header"><?php _e( 'Search or choose cover photo', 'um-unsplash' ); ?></div>

		<div class="um-unsplash-modal-body">

			<form class="um-unsplash-form" method="post" action="">
				<p style="clear: both;display: inline-block;border: 1px solid #ccc;padding: 0;margin: 0;background: #eee;">

					<input style="border: none;background: #eee;padding-left:10px;" type="search" id="um-unsplash-photo-search-field" placeholder="<?php esc_attr_e( 'Search image', 'um-unsplash' ); ?>"/>

					<button data-empty_result="<?php _e( 'No result was found.', 'um-unsplash' ); ?>"
							style="background-color:transparent;border:none;border-left:1px solid #ccc;margin:0;-webkit-box-shadow:none;box-shadow:none;" id="um-unsplash-photo-search-btn"
							type="button"><i class="um-faicon-search"></i>
					</button>
				</p>
				<div class="um-clear"><br/></div>
				<div class="um-unsplash-modal-body-ajax-content"></div>

				<?php wp_nonce_field( 'um_unsplash_save_photo' );?>

				<div class="um-unsplash-form-response"></div>
				<input type="hidden" name="profile" value="<?php echo esc_attr( um_profile_id() ); ?>" />
				<input id="unsplash_photo_author" type="hidden" name="photo_author" value=""/>
				<input id="unsplash_photo_author_url" type="hidden" name="photo_author_url" value=""/>
				<input id="unsplash_photo_download_link" type="hidden" name="photo_download_url" value=""/>
				<input id="unsplash_photo_download_location" type="hidden" name="photo_download_location" value=""/>
				<input id="unsplash_photo_photo_id" type="hidden" name="photo_id" value=""/>
				<input type="hidden" name="action" value="um_unsplash_update" />
			</form>

			<div class="um-unsplash-modal-footer">
				<div class="um-unsplash-modal-right">
					<a href="javascript:void(0);" id="um_unsplash_view_image" class="um-modal-btn alt">
						<?php _e( 'View', 'um-unsplash' ); ?>
					</a>
					<a href="javascript:void(0);" id="um-unsplash-submit" class="um-modal-btn disabled">
						<?php _e( 'Apply', 'um-unsplash' ); ?>
					</a>
					<a href="javascript:void(0);" id="um_unsplash_remove_modal" class="um-modal-btn alt">
						<?php _e( 'Cancel', 'um-unsplash' ); ?>
					</a>
				</div>
				<div class="um-clear"></div>
			</div>
		</div>
	</div>
</div>
