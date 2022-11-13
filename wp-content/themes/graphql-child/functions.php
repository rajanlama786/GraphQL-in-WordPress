<?php
/**
 * Child Functions
*/

add_action( 'wp_enqueue_scripts', 'cafe_business_enqueue_styles',999 );
function cafe_business_enqueue_styles() {

    $parent_style = 'twentytwentyone-style'; // This is 'twentyseventeen-style' for the Twenty Seventeen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'twentytwentyone-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_script( "child-ajax", get_stylesheet_directory_uri() . '/js/child-ajax.js', array( 'jquery' ), wp_get_theme()->get('Version') );

    global $post;
    wp_localize_script( 'child-ajax', 'child_ajax', 
        array(
            'post_id' => $post->ID,
            'ajaxurl' => admin_url('admin-ajax.php'), 
            'siteurl' => site_url(),
            'jsonurl' => gpl_json_query()
        )
    );

}

function gpl_json_query(){
    $cats = get_the_category();
    $cat_ids = array();
    foreach( $cats as $cat ){
        $cat_ids[] = $cat->term_id;
    }

    $args = array(
        'filter[cat]' => implode(",", $cat_ids),
        'per_page' => 5,
    );

    $url = add_query_arg( $args, rest_url('wp/v2/posts'));

    return $url;
}

function gpl_register_field(){
    register_rest_field( 'post', 
        'author_name',
        array(
            'get_callback' => 'gpl_get_author_name',
            'update_callback' => null,
            'schema' => null,
        )
    );

    register_rest_field( 'post', 
        'featured_media_src',
        array(
            'get_callback' => 'gpl_get_image_src',
            'update_callback' => null,
            'schema' => null,
        )
    );
}


function gpl_get_author_name( $object, $field_name, $request){
    return get_the_author_meta( 'display_name');
}
add_action('rest_api_init', 'gpl_register_field');

function gpl_get_image_src( $object, $field_name, $request){
    $img_src_arr = wp_get_attachment_image_src( $object['featured_media'], 'thumbnail', true );
    return $img_src_arr[0];
}

function gql_loadmore_html( ){
    $baseline = '<section id="related_posts_section">';
    $baseline .= '<h2 id="related_posts" >Related Posts</h2>';
    $baseline .= '<div id="related_posts_ajax"></div>';
    $baseline .= '<a href="#" id="gql_loadmore" >Load More</a>';
    $baseline .= '</section>';

    return $baseline;
}


function gql_loadmore_btn( ){
    $baseline = '<div id="gql_loadmore" >Load More</div>';
    return $baseline;
}

function gql_loadmore( $content ){
    if( is_single() && is_main_query() ){
        $content .= gql_loadmore_html();
    }
    return $content;
}
add_filter('the_content', 'gql_loadmore');


function related_post_ajax(){
    echo 'Hello World!';
die();
}

add_action('wp_ajax_related_post_ajax', 'related_post_ajax');
add_action('wp_ajax_nopriv_related_post_ajax','related_post_ajax');


add_action( 'graphql_register_types', 'example_extend_wpgraphql_schema' );

function example_extend_wpgraphql_schema() {

/*** Sample Url ******/
// http://localhost/graphqlWP/graphql?query={posts{nodes{id,title,content}}}
/*********************/

  // register_graphql_field( 'RootQuery', 'customField', [
  //   'type' => 'String',
  //   'description' => __( 'Describe what the field should be used for', 'your-textdomain' ),
  //   'resolve' => function() {
  //       return [
  //         'count' => 5,
  //         'testField' => 'test value...',
  //       ];
  //     }
  // ] );

    register_graphql_field( 'RootQuery', 'example', [
    'type' => 'String',
    'description' => __( 'Describe what the field should be used for', 'your-textdomain' ),
    'args' => [
        'test' => [
            'description' => __('This is the test', 'your-textdomain'),
            'type' => 'String',
        ],
    ],
    'resolve' => function( $post, $args, $context, $into ) {

        //Debug in graphQL
        //wp_send_json( ['args' => $args ]  );
        //graphql_debug( ['args' => $args ] );

        return 'Hello. ' . $args['test'];
      }
  ] );


// Adding extra field for Posts Posttype.
    register_graphql_field( 'Post', 'color', [
    'type' => 'String',
    'description' => __( 'The color field description.', 'your-textdomain' ),
    'args' => [
        'test' => [
            'description' => __('This is the test', 'your-textdomain'),
            'type' => 'String',
        ],
    ],
    'resolve' => function( $post, $args, $context, $into ) {

        //Debug in graphQL
        //wp_send_json( ['args' => $args ]  );
        //graphql_debug( ['args' => $args ] );

        $color = get_post_meta( 1, 'color', true);

        return $color ?? null;
      }
  ] );

  register_graphql_object_type( 'CustomType', [
  'description' => __( 'Describe what a CustomType is', 'your-textdomain' ),
  'fields' => [
    'testField' => [
      'type' => 'String',
      'description' => __( 'Describe what testField should be used for', 'your-textdomain' ),
    ],
    'count' => [
      'type' => 'Int',
      'description' => __( 'Describe what the count field should be used for', 'your-textdomain' ),
    ],
  ],
] );
};

add_action( 'init', function() {
    update_post_meta( 1, 'color', 'blue' );
});