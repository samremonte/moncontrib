<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="authors-page">

	<?php
	$args = array( 'role' => 'author' ); 
	$listofusers = get_users( $args );
	?>
		<select name="listofusers" id="listofusers">
			<option value="select user" class="site-users">Select User</option>
		<?php
		foreach( $listofusers as $user ){
			if( count_user_posts( $user->ID ) != 0 ){ // DISPLAY USER ONLY WITH POST/S
			
				echo '<option value="' .esc_html( $user->ID ). '" class="site-users">' .esc_html( $user->display_name ). '</option>';
			
			}
		}
	?>
	</select>

	<div class="user-information">
	</div>
	
</div>