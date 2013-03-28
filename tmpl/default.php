<?php
/**
 * @subpackage	mod_twitter
 * @license		WTFPL
 */

// no direct access
defined('_JEXEC') or die;

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$style = $params->get('style', 'feed');
?>

<style type="text/css">
	.mod_twitter {
		margin-bottom: 5px;
	}

	.mod_twitter li {
		list-style: none;
	}

	.mod_twitter ul {
		padding: 0px;
		margin-top: 0px;		
	}

	.mod_twitter .twitter-accordian p {
		margin: 0px;
		padding: 5px;
	}

	.mod_twitter .twitter-accordian .accordian_title {padding: 5px; background: #eee;}
	.mod_twitter .twitter-accordian li:not(:first-child) .accordian_content {display: none;}
</style>

<div class="mod_twitter clearfix">
	<?php if($module->showtitle): ?>
		<div class="clearfix mod_latest_news_title">
			<h2 class="title"><?php echo $module->title; ?></h2>
		</div>
	<?php endif; ?>
	<ul class="twitter-<?php echo $style; ?>">
		<?php if(count($list) > 0): ?>
			<?php foreach ($list as $item) : ?>
				<?php if(isset($item->Status) && $item->Status == 'Error'): ?>
					<li>
						<?php echo $item->Message; ?>
					</li>
				<?php else : ?>
				<?php
					$item->text = preg_replace('/(http\:\/\/[a-zA-Z0-9\.\/]+[a-zA-Z0-9\/])/', '<a href="$1" target="_blank">$1</a>', $item->text);
					$item->text = preg_replace('/\#([a-zA-Z0-9_-]+)/', '<a href="https://twitter.com/search?q=%23$1" target="_blank">#$1</a>', $item->text);
					$item->text = preg_replace('/\@([a-zA-Z0-9_-]+)/', '<a href="https://twitter.com/$1" target="_blank">@$1</a>', $item->text);
				?>
					<li>
						<?php if($style == 'accordian'): ?>
							<div class="accordian_title">
								<?php if($params->get('show_user')): ?>
									<?php if($params->get('show_avatar')): ?>
										<a href="http://twitter.com/<?php echo $item->user->screen_name; ?>" target="_blank">
											<img src="<?php echo $item->user->profile_image_url_https; ?>" alt="<?php echo $item->user->screen_name; ?>'s avatar" />
											@<?php echo $item->user->screen_name; ?>
										</a>
									<?php else : ?>
										<a href="http://twitter.com/<?php echo $item->user->screen_name; ?>" target="_blank">@<?php echo $item->user->screen_name; ?></a>
									<?php endif; ?>
								<?php else: ?>
									Tweeted on <?php echo date($params->get('postdate_format', 'F jS, Y'), strtotime($item->created_at)); ?>
								<?php endif; ?>
							</div>
							
							<div class="accordian_content">
								<p class="leadin"><?php echo $item->text; ?></p>
							</div>
						<?php elseif($style == 'feed'): ?>
							<?php if($params->get('show_user')): ?>
								<?php if($params->get('show_avatar')): ?>
									<a href="http://twitter.com/<?php echo $item->user->screen_name; ?>" target="_blank">
										<img src="<?php echo $item->user->profile_image_url_https; ?>" alt="<?php echo $item->user->screen_name; ?>'s avatar" />
										@<?php echo $item->user->screen_name; ?>
									</a>
								<?php else : ?>
									<a href="http://twitter.com/<?php echo $item->user->screen_name; ?>" target="_blank">@<?php echo $item->user->screen_name; ?></a>
								<?php endif; ?>
							<?php endif; ?>

							<p class="leadin"><?php echo $item->text; ?></p>

							<?php if($params->get('show_postdate', '1')): ?>
								<span class="postdate"><em><?php echo date($params->get('postdate_format', 'F jS, Y'), strtotime($item->created_at)); ?></em></span>
							<?php endif; ?>
						<?php endif; ?>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php else : ?>
			<li>There are no recent tweets.</li>
		<?php endif; ?>
	</ul>
	<?php if($params->get('show_follow_us_link')): ?>
		<p><a href="https://twitter.com/<?php echo $params->get('screen_name'); ?>" class="follow_us" target="_blank"><?php echo $params->get('follow_us_link_text'); ?></p></a>
	<?php endif; ?>
</div>

<script>window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"><\/script>')</script>
<script type="text/javascript">
	jQuery('.accordian_title').click(function(){
		jQuery('.accordian_content').slideUp('fast');

		var content = jQuery(this).parent().find('.accordian_content');

		if(content.is(':visible')){
			content.slideUp('fast');
		}else {
			content.slideDown('fast');
		}
	});
</script>