<?php 
	$honeybee_actions = $this->recommended_actions;
	$honeybee_actions_todo = get_option( 'honeybee_recommended_actions', false );
?>
<div id="recommended_actions" class="honeybee-tab-pane panel-close">
	<div class="action-list">
		<div class="row">
			<?php if($honeybee_actions): foreach ($honeybee_actions as $key => $honeybee_val): ?>
			<div class="col-md-6">
				<div class="action" id="<?php echo esc_attr($honeybee_val['id']); ?>">
					<div class="action-box">
						<div class="action-watch">
						<?php if(!$honeybee_val['is_done']): ?>
							<?php if(!isset($honeybee_actions_todo[$honeybee_val['id']]) || !$honeybee_actions_todo[$honeybee_val['id']]): ?>
								<span class="dashicons dashicons-visibility"></span>
							<?php else: ?>
								<span class="dashicons dashicons-hidden"></span>
							<?php endif; ?>
						<?php else: ?>
							<span class="dashicons dashicons-yes"></span>
						<?php endif; ?>
						</div>
						<div class="action-inner">
							<h3 class="action-title"><?php echo esc_html($honeybee_val['title']); ?></h3>
							<div class="action-desc"><?php echo esc_html($honeybee_val['desc']); ?></div>
							<?php echo wp_kses_post($honeybee_val['link']); ?>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; endif; ?>
		</div>
	</div>
</div>