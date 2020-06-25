<?php get_header();?>

<div class="row content-area">
    <div class="col-9 border-left">
<?php
$sections = array(
    array(
        "template"      => "main_news",
        "section_class" => "main_news_section",
        "cat"           => "main-news",
        "title"         => "Main News",
        "title_class"   => "bg_black",
        "cat_class"     => "bg_red clip",
    ),
    array(
        "template"      => "international",
        "section_class" => "main_news_section",
        "cat"           => "chattogram",
        "title"         => "International",
        "title_class"   => "bg_black",
        "cat_class"     => "bg_red clip",
    ),
);

foreach ( $sections as $section ):
?>
            <div class="row <?php echo $section['section_class'] ?>">
                <div class="col-12">
                <?php
					eis_main_news_section_title( $section['title'], $section['title_class'], $section['cat_class'] );
				?>
                </div>
                <div class="col-12">
                    <div class="row">
                        <?php
							$args = array(
								'post_type'      => 'post',
								'category_name'  => 'international',
								'posts_per_page' => 7,
							);

							$q = new WP_Query( $args );
							while ( $q->have_posts() ) {
								$q->the_post();
								
								echo $section["template"];

								get_template_part( 'templates/' . $section['template'] );
							}
						?>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="col-3">
        <?php get_sidebar();?>
    </div>
</div>

<?php get_footer();?>