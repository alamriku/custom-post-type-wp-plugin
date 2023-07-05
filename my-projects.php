<?php
/**
 * @package My-project
 */
/*
Plugin Name: My-project
Plugin URI: https://project.com/
Description: Used by millions,  To get started: activate the my-project plugin and then go to your y-project Settings page to set up your API key.
Version: 5.1

*/

if(!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    die;
}

class MyProject
{
    public function __construct(){
        add_action('init', array($this, 'custom_post_type'));
    }

    public function register():void {
        add_action('wp_enqueue_scripts', array($this, 'enqueue'));
        add_action('admin_init', array($this, 'add_post_meta_boxes'));
        add_action('save_post_project', array($this, 'save_project_external_url_fields'));
        add_action('save_post_project', array($this, 'save_project_preview_image'));
        add_action('wp_ajax_load_project_details', array($this, 'load_project_details'));
        add_action('wp_ajax_nopriv_load_project_details', array($this, 'load_project_details'));
    }

    public function activate():void {
        $this->custom_post_type();
        flush_rewrite_rules();
    }

    public function deactivate():void {
        flush_rewrite_rules();
    }

    public function custom_post_type():void {
        $labels = array(
            'name'               => 'Projects',
            'singular_name'      => 'Project',
            'menu_name'          => 'Projects',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Project',
            'edit_item'          => 'Edit Project',
            'new_item'           => 'New Project',
            'view_item'          => 'View Project',
            'search_items'       => 'Search Projects',
            'not_found'          => 'No projects found',
            'not_found_in_trash' => 'No projects found in Trash',
            'parent_item_colon'  => 'Parent Project:',
            'all_items'          => 'All Projects',
            'archives'           => 'Project Archives',
            'insert_into_item'   => 'Insert into project',
            'uploaded_to_this_item' => 'Uploaded to this project',
            'featured_image'        => 'Thumbnail Image',
            'set_featured_image'    => 'Set thumbnail image',
            'remove_featured_image' => 'Remove thumbnail image',
            'use_featured_image'    => 'Use as thumbnail image',
            'filter_items_list'     => 'Filter projects list',
            'items_list_navigation' => 'Projects list navigation',
            'items_list'            => 'Projects list',
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'projects' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'thumbnail' ),
            'taxonomies'            => array('category'),
            'can_export' => true,
        );

        register_post_type('project',   $args);
    }

    public function add_post_meta_boxes(): void {
        add_meta_box(
            "post_metadata_projects_external_url",
            "External URL",
            array($this, 'render_projects_external_url_meta_box'),
            "project", // name of post type on which to render fields,
        "side",
            "low", // placement priority
        );
        add_meta_box(
            'post_metadata_projects_preview_image',
            'Preview Image',
            array($this, 'render_projects_preview_image_meta_box'),
            'project',
            'side',
            'low',
        );
    }
    public function render_projects_external_url_meta_box($post):void {
        $external_url = get_post_meta($post->ID, 'external_url', true);
        ?>
        <input type="text" id="external_url" name="external_url" value="<?php echo esc_attr($external_url); ?>">
        <?php
    }

    public function render_projects_preview_image_meta_box($post): void {
        // Retrieve the saved preview image ID
    $preview_image_id = get_post_meta($post->ID, 'preview_image', true);
    $preview_image_url = wp_get_attachment_image_src($preview_image_id, 'thumbnail');

    // Output the custom field
    ?>
        <div class="preview-image-wrapper">
            <img class="preview-image" width="250" height="150" src="<?php echo $preview_image_url ?  esc_attr($preview_image_url[0]) : 'https://placehold.co/250X150'; ?>" alt="Preview Image">
            <div class="preview-image-actions">
                <button type="button" class="button upload-preview-image"><?php esc_html_e('Select Image', 'project preview image'); ?></button>
                <button type="button" class="button remove-preview-image"><?php esc_html_e('Remove Image', 'project preview image'); ?></button>
            </div>

            <input type="hidden" name="preview_image" id="preview_image" value="<?php echo esc_attr($preview_image_id); ?>">
        </div>

        <script>
            jQuery(document).ready(function ($) {
                var mediaUploader;

                // Handle the click event for the "Select Image" button
                $('.upload-preview-image').click(function (e) {
                    e.preventDefault();

                    if (mediaUploader) {
                        mediaUploader.open();
                        return;
                    }

                    mediaUploader = wp.media({
                        title: '<?php esc_html_e("Select Image", "project preview image"); ?>',
                        button: {
                            text: '<?php esc_html_e("Use this image", "project preview image"); ?>',
                        },
                        multiple: false,
                    });

                    // When an image is selected, update the preview image and ID field
                    mediaUploader.on('select', function () {
                        var attachment = mediaUploader.state().get('selection').first().toJSON();

                        $('.preview-image').attr('src', attachment.url);
                        $('#preview_image').val(attachment.id);
                    });

                    mediaUploader.open();
                });

                // Handle the click event for the "Remove Image" button
                $('.remove-preview-image').click(function (e) {
                    e.preventDefault();

                    $('.preview-image').attr('src', 'https://placehold.co/250X150');
                    $('#preview_image').val('');
                });
            });
        </script>
        <?php
    }
    public function save_project_external_url_fields($post_id): void {
        // Save the label values
        if (isset($_POST['external_url'])) {
            update_post_meta($post_id, 'external_url', sanitize_text_field($_POST['external_url']));
        }
    }

    public function save_project_preview_image($post_id): void {
        if(isset($_POST['preview_image'])) {
            update_post_meta($post_id, 'preview_image', sanitize_text_field($_POST['preview_image']));
        }
    }

    public function load_project_details() {
        $post_id = $_POST['post_id'];

        // Query the post details based on the post ID
        $post = get_post($post_id);
        $categories = get_the_category($post_id);
        $external_url = get_post_meta($post_id, 'external_url', true);
        $preview_image_id = get_post_meta($post_id, 'preview_image', true);
        $preview_image_url = wp_get_attachment_image_src($preview_image_id, 'full')[0];
        $thumbnail = get_the_post_thumbnail_url($post_id, 'post-thumbnail');
        // Prepare the response data as an associative array
        $response = array(
            'title' => $post->post_title,
            'content' => $post->post_content,
            'categories' => $categories,
            'external_url' => $external_url,
            'preview_image' => $preview_image_url,
            'thumbnail' => $thumbnail,
        );

        // Encode the response data as JSON
        $json_response = json_encode($response);

        // Set the content type header to JSON
        header('Content-Type: application/json');

        // Return the JSON response
        echo $json_response;

        // Always exit after handling AJAX requests
        wp_die();

    }

    public function enqueue():void {
        $title_nonce = wp_create_nonce( 'custom_post_project_nonce' );
        wp_enqueue_script('tailwind-css', 'https://cdn.tailwindcss.com', array(), '3.3.2');
        wp_enqueue_script( 'projectScript', plugins_url( '/assets/script.js', __FILE__  ), array('jquery'), '3.6.4', true );
        wp_enqueue_style( 'projectStyle', plugins_url( '/assets/myProjectStyle.css', __FILE__  ) );
        wp_localize_script(
            'projectScript',
            'my_ajax_obj',
            array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => $title_nonce,
            )
        );
    }
}

if (class_exists('MyProject')) {
    $myProject = new MyProject();
    $myProject->register();
}

register_activation_hook(__FILE__, array($myProject, 'activate'));
register_deactivation_hook(__FILE__, array($myProject, 'deactivate'));

