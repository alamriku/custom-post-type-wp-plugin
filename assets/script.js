jQuery(document).ready(function($) {
    var this2 = this;
    console.log(my_ajax_obj);
    // Grid item click event handler
    $('.grid-item').on('click', function() {
        var postId = $(this).data('post-id'); // Retrieve post ID from data attribute
        loadProjectDetails(postId); // Load post details via AJAX
    });

    // Function to load post details via AJAX
    function loadProjectDetails(postId) {
        $('#post_modal').show();
        $.ajax({
            url: my_ajax_obj.ajax_url, // Use the WordPress AJAX URL
            type: 'POST',
            _ajax_nonce: my_ajax_obj.nonce,
            data: {
                action: 'load_project_details',
                post_id: postId
            },
            success: function(response) {
                // Populate the modal container with the retrieved post details
                //$('#projectDetails').html(response);
                $('#post_title').text(response.title)
                $('#preview_image').attr('src', response.preview_image)
                $('#thumbnail_image').attr('src', response.thumbnail)
                $('#post_category').text(categoryAsCommaSeparated(response.categories));
                $('#post_content').html(response.content);
                // Show the modal
                $('#projectModal').show();
            },
            error: function() {
                console.log('Error occurred while loading project details.');
            }
        });
    }

    // Close the modal when the close button or outside the modal content is clicked
    $('.close, .modal').on('click', function(event) {
        var postId = $(this).data('button-post');
        $('#post_modal').hide();
    });

    // Prevent modal close when clicking inside the modal content
    $('.modal-content').on('click', function(event) {
        event.stopPropagation();
    });

    function categoryAsCommaSeparated(categories) {
        if(categories.length > 0) {
            return categories.map((category) => {
               return category.category_nicename;
            }).toString();
        }

        return '';
    }
});