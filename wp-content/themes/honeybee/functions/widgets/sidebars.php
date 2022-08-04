<?php	
add_action( 'widgets_init', 'honeybee_widgets_init');
function honeybee_widgets_init() {
	
   
	// Header Social Icon Sidebar
	register_sidebar( array(
		'name' => esc_html__( 'Top header sidebar left area', 'honeybee' ),
		'id' => 'home-header-sidebar_left',
		'description' => esc_html__('Social media menu lateral area', 'honeybee' ),
		'before_widget' => '<aside id="%1$s" class="right-widgets %2$s">',
		'after_widget' => '</aside>',
	));
	
	// Subscribe Sidebar
	register_sidebar( array(
		'name' => esc_html__( 'Top header sidebar right area', 'honeybee' ),
		'id' => 'home-header-sidebar_right',
		'description' => esc_html__('Subscriber section widget area', 'honeybee' ),
		'before_widget' => '<aside id="%1$s" class="left-widgets %2$s">',
		'after_widget' => '</aside>',
	));
}