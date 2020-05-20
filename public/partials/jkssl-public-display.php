<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wpmastery.xyz
 * @since      1.0.0
 *
 * @package    Jkssl
 * @subpackage Jkssl/public/partials
 */

ob_start();
$session_title = get_the_title( $session_id );
$video         = get_post_meta( $session_id, 'ess_vimeo_url', true );
$thumb         = get_the_post_thumbnail_url( $session_id, 'full' );
$permalink     = get_the_permalink( $session_id );
$speaker       = get_post_meta( $session_id, 'ess_speaker_name', true );
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="session-<?php echo $session_id; ?>" class='summit-session'>
<a href="<?php echo esc_url( $video ); ?>" class="html5lightbox" data-thumbnail="<?php echo $thumb; ?> "><img src="<?php echo $thumb; ?>" alt="<?php echo $title; ?>">
</a>

<h2>
	<a href="<?php echo esc_url( $permalink ); ?>">
	<?php echo esc_attr( $session_title ); ?>
	<span> by <?php echo esc_attr( $speaker ); ?></span>
	</a>
</h2>
</div>

<?php
echo ob_get_clean();
