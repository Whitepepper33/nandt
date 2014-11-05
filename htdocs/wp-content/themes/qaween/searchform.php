<?php
/**
 * Template for displaying search form.
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<div class="search-box">
	<form id="search" method="get" action="<?php echo home_url(); ?>">
		<input name="s" id="search-input" value="" placeholder="Type your keyword here"/>
	</form>
</div>