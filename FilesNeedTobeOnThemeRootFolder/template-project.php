<?php
/**
 * Template Name: Project Template
 */

get_header();

$args_category_filter = array(
    'show_option_all' => 'All Categories',
    'taxonomy' => 'category',
    'name' => 'category_filter',
    'orderby' => 'name',
    'echo' => false,
);

$category_dropdown = wp_dropdown_categories($args_category_filter);

$args = array(
    'post_type' => 'project',
    'posts_per_page' => -1, // Retrieve all projects
    'orderby' => 'title',
    'order' => 'ASC',
);
$selected_category = isset($_GET['category_filter']) ? sanitize_text_field($_GET['category_filter']) : '';
if (!empty($selected_category) && $selected_category !== '0') {
    $args['tax_query']  = array(
        array(
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $selected_category,
        )
    );
}
$projects_query = new WP_Query($args);

if ($projects_query->have_posts()) {
    echo '<div class="p-3 m-4">';
    echo '<form method="GET" class="float-right">';
    echo $category_dropdown;
    echo '<input type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" value="Filter">';
    echo '</form>';
    echo '</div>';
    //tailwind grid
    echo '<div class="px-5 mx-10">';
    echo '<ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">';
    while ($projects_query->have_posts()) {
        global $post;
        $projects_query->the_post();
        $categories = get_the_category();
        $thumbnail = get_the_post_thumbnail_url();
        $title = get_the_title();
        $permalink = get_permalink();
        if (!empty($categories)) {
            $category_names = array_map(function($category) {
                return $category->name;
            }, $categories);
        }
        // Render the grid item
        echo '<li class="relative cursor-pointer grid-item" data-post-id="'.$post->ID.'">';
        echo '<div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">';
        echo '<img src="' . esc_url($thumbnail) . '" alt="" class="object-cover pointer-events-none group-hover:opacity-75">';
        echo '</div>';
        echo '<p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">' . esc_html($title) . '</p>';
        if(!empty($category_names)) {
            echo '<p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">' . implode(',', $category_names) . '</p>';
        }
        echo '</li>';
    }
    echo '</ul>';
    $modalPath = get_template_directory() . '/custom-post-modal.php';
    require($modalPath);
    echo '</div>';
    // Restore global post data
    wp_reset_postdata();
} else {
    // No projects found
    echo 'No projects found.';
}

get_footer();


