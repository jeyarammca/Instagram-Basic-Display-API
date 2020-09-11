<?php
	require_once('instagram_basic_display_api_class.php');
	$accessToken = 'ACCESS-TOKEN'; /* Check Readme.md file mentioned, Copied token past here */ 
	$params = array(
		'get_code' => isset( $_GET['code'] ) ? $_GET['code'] : '',
		'access_token' => $accessToken,
		'user_id' => 'USER-ID' /* Add here Instagram User ID, Run this page browser first, *IG ID Id Past here, then refresh the page will showing the users media*/
	);
	$ig = new instagram_basic_display_api( $params );
?>


<?php if ( $ig->hasUserAccessToken ) : ?>
<?php $user = $ig->getUser(); ?>
<h1>Username: <?php echo $user['username']; ?></h1>
<h2>*IG ID: <?php echo $user['id']; ?></h2>
<h3>Media Count: <?php echo $user['media_count']; ?></h3>
<h4>Account Type: <?php echo $user['account_type']; ?></h4>
<?php endif; ?>

<!-- Images Only load -->
<?php if ( $ig->hasUserAccessToken ) : ?>
	<?php $usersMedia = $ig->getUsersMedia(); ?>	
	<ul style="list-style: none;margin:0px;padding:0px;">
		<?php foreach ( $usersMedia['data'] as $post ) : ?>
			<?php if ( 'IMAGE' == $post['media_type'] || 'CAROUSEL_ALBUM' == $post['media_type']) : ?>
				<?php 
					$highlightedPostId = $post['id'];
					$media = $ig->getMedia( $highlightedPostId );
					?>
				<div>
					<?php if ( 'IMAGE' == $post['media_type'] || 'CAROUSEL_ALBUM' == $post['media_type']) : ?>
						<a href="<?php echo $media['permalink']; ?>" target="_blank"><img style="height:320px" src="<?php echo $post['media_url']; ?>" /></a>				
					<?php endif; ?>
				</div>				
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>	
<?php endif; ?>

<!-- With Videos -->
<h4>Posts</h4>
	<ul style="list-style: none;margin:0px;padding:0px;">
		<?php foreach ( $usersMedia['data'] as $post ) : ?>
			<li style="margin-bottom:20px;border:3px solid #333">
				<div>
					<?php if ( 'IMAGE' == $post['media_type'] || 'CAROUSEL_ALBUM' == $post['media_type']) : ?>
						<img style="height:320px" src="<?php echo $post['media_url']; ?>" />
					<?php else : ?>
						<video height="240" width="320" controls>
							<source src="<?php echo $post['media_url']; ?>">
						</video>
					<?php endif; ?>
				</div>
				<div>
					<b>Caption: <?php echo $post['caption']; ?></b>
				</div>
				<div>
					ID: <?php echo $post['id']; ?>
				</div>
				<div>
					Media Type: <?php echo $post['media_type']; ?>
				</div>
				<div>
					Media URL: <?php echo $post['media_url']; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
