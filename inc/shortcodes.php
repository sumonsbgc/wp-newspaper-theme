<?php

function news_ticker($attr, $content)
{
    $breaking_news = get_transient('breaking_news');
    if (false === $breaking_news) :
        $d = getdate();
        $breaking_news = new WP_Query(
            [
                "post_type"     => "post",
                "posts_per_page" => 10
            ]
        );
        set_transient('breaking_news', $breaking_news, DAY_IN_SECONDS);
    endif;

    $html = '<ul id="news-ticker-wrap">';
    while ($breaking_news->have_posts()) {
        $breaking_news->the_post();
        $html .= sprintf(
            '<li><a><i class="fas fa-angle-double-right"></i> %s</a></li>',
            get_the_title()
        );
    }

    $html .= '</ul>';

    return $html;
    wp_reset_postdata();
}
add_shortcode('breaking_news', 'news_ticker');


function display_tabnews()
{
    if (!empty($_POST["action"])) {
        if (wp_verify_nonce($_POST['nonce'], $_POST['action'])) {
            check_ajax_referer($_POST["action"]);
            $category = $_POST['category'];
            $q = new WP_Query([
                "category_name" => $category,
                "posts_per_page" => 5
            ]);

            ob_start();
            while ($q->have_posts()) {
                $q->the_post();
                if (0 === $q->current_post) {
                    get_template_part("templates/tab-large-news");
                } else {
                    get_template_part("templates/tab-news");
                }
            }
            echo '<a href="' . eis_get_category_link($category) . '" class="more">আরোও <i class="fas fa-angle-double-right"></i></a>';
            wp_send_json_success(ob_get_clean());
            wp_reset_postdata();
        }
    }

    wp_die();
}
add_action("wp_ajax_tabnews", "display_tabnews");
add_action("wp_ajax_nopriv_tabnews", "display_tabnews");
