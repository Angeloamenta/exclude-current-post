<?php
/*
Plugin Name: Exclude Current Post from Loops
Description: Esclude automaticamente il post attualmente visualizzato da tutti i loop (anche nei widget o builder come YOOtheme).
Version: 1.0
Author: Angelo
*/

add_filter('posts_where', function($where, $query) {
    // Evita l'applicazione in area admin
    if ( is_admin() ) return $where;

    global $post;

    // Se c'è un post attivo e siamo su una singola pagina (es. articolo), escludilo dagli altri loop
    if ( $post && is_singular() ) {
        $post_id = $post->ID;

        // Escludi solo se la query non è quella principale (quella della pagina corrente)
        if ( !$query->is_main_query() ) {
            global $wpdb;
            $where .= $wpdb->prepare(" AND {$wpdb->posts}.ID != %d", $post_id);
        }
    }

    return $where;
}, 10, 2);

