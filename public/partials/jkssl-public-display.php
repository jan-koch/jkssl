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
?>
<h1>TEST</h1>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="session-<?php echo $session_id; ?>">
<h2><?php echo get_the_title( $session_id ); ?></h2>
</div>

<?php
echo ob_get_clean();
