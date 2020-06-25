<?php

class QueryNewsWidget extends WP_Widget
{

    public function __construct()
    {
        // actual widget processes
        $options = array(
            'classname'   => 'query_news_widgets',
            'description' => 'Query News Widget Descriptions',
        );
        parent::__construct('eis_widget', 'Query News Widget', $options);
        $this->init();
    }

    public function init()
    {
        add_action('widgets_init', function () {
            register_widget(__CLASS__);
        });
    }

    public function form($instance)
    {
        if (!isset($instance['category']) && empty($instance['category'])) {
            $category = "main-news";
        } else {
            $category = $instance['category'];
        }

        if (!isset($instance['template']) && empty($instance['template'])) {
            $template = "col-three";
        } else {
            $template = $instance['template'];
        }

        printf("<p>");
        printf('<label for="%s">%s</label>', esc_attr($this->get_field_id('category')), esc_html("Select Your Category"));
        printf(
            '<input class="widefat" type="text" name="%s" id="%s" value="%s">',
            esc_attr($this->get_field_name('category')),
            esc_attr($this->get_field_id('category')),
            esc_attr($category)
        );
        printf("</p>");

        printf("<p>");
        printf('<label for="%s">%s</label>', esc_attr($this->get_field_id('template')), esc_html("Select Your template"));
        printf(
            '<input class="widefat" type="text" name="%s" id="%s" value="%s">',
            esc_attr($this->get_field_name('template')),
            esc_attr($this->get_field_id('template')),
            esc_attr($template)
        );
        printf("</p>");
    }

    public function widget($args, $instance)
    {
        $categories = explode(",", rtrim($instance["category"], ", "));
        $count = is_array($categories) ? count($categories) : 1;
        $col = 12 / $count;
        foreach ($categories as $cat) {
            $q = new WP_Query([
                "post_type"      => "post",
                "posts_per_page" => 4,
                "category_name" => $cat
            ]);
            if (1 < $count && 1 !== $count) :

                printf('<div class="col-%s">', $col);
                printf('<div class="row">');

                printf('<div class="col-12 pb-2 pt-3">');
                eis_news_section_title($cat, 'section_title', 'bg_black');
                printf('</div>');

                while ($q->have_posts()) {
                    $q->the_post();
                    get_template_part("templates/{$instance['template']}");
                }

                printf('</div>');
                printf('</div>');
            else :
                printf('<div class="col-12 pb-2 pt-3">');
                eis_news_section_title($cat, 'section_title', 'bg_black');
                printf('</div>');
                while ($q->have_posts()) {
                    $q->the_post();
                    get_template_part('templates/col-three');
                }
            endif;
        }
    }

    //public function update( $new_instance, $old_instance ) {
    //    // processes widget options to be saved
    //}
}

new QueryNewsWidget();
