<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php

$listofusers = esc_html($_POST['user']);
if( is_numeric( $listofusers ) || $listofusers != 0 ){
?>
	<table>
		<tr>
			<th rowspan=4><?php echo get_avatar( $listofusers, 60 ); ?></th>
		</tr>
		<tr>
			<td><?php echo the_author_meta( 'display_name', $listofusers ); ?></td>
		</tr>
		<tr>
			<td><?php echo get_the_author_meta( 'user_email', $listofusers ); ?></td>
		</tr>
		<tr>
			<td><?php echo 'Total Posts: ' .count_user_posts( $listofusers ); ?></td>
		</tr>
	</table>

	<div class="posts-table">
	<table class="widefat fixed scoretable" cellspacing="0">
		<thead>
			<tr>
				<th>Title</th>
				<th>Category</th>
				<th>Date Posted</th>
			    <th>Views</th>
				<th>Likes</th>

			</tr>
		</thead>

		<tbody>
		<?php

		$args = array(
			'author'        =>  $listofusers,
			'orderby'       =>  'post_date',
			'order'         =>  'DSC',
			'posts_per_page' => -1
		);

		$author_posts = new WP_Query( $args );

		while($author_posts->have_posts()) : $author_posts->the_post();
			
			echo '<tr>';
			echo '<td><a href="' .get_the_permalink(). '" target="_blank">';
			echo the_title();
			echo '</a></td>';

			$category = get_the_category( get_the_ID() ); 
			echo '<td>' .$category[0]->name. '</td>';

			echo '<td>' .get_the_date( _('M j, Y'), get_the_ID() ). '</td>';
			echo '<td>' .get_post_meta( get_the_ID(), 'views_count', true ). '</td>';
			echo '<td>' .getPostLikeLink( get_the_ID() ). '</td>';
			echo '</tr>';

		endwhile;

		wp_reset_postdata();
		die();

		?>

		</tbody>
	</table>
	</div>
<?php
}else{
	echo "Selected user: ";
}
?>