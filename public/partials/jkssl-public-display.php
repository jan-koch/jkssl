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
$title = get_the_title( $session_id );
$video = get_post_meta( $session_id, 'ess_vimeo_url', true );
$thumb = get_the_post_thumbnail_url( $session_id, 'full' );
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="session-<?php echo $session_id; ?>" class='summit-session'>
<a href="<?php echo $video; ?>" class="html5lightbox" data-thumbnail="<?php echo $thumb; ?> "><img src="<?php echo $thumb; ?>" alt="<?php echo $title; ?>">
</a>

<h2><?php echo $title; ?></h2>
</div>

<?php
echo ob_get_clean();
