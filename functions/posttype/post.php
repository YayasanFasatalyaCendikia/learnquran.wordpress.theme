<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* Register Post Meta For Table Of Contents Settings */
function learnquran_register_post_toc_meta() {
    register_post_meta( 'post', '_learnquran_enable_toc', [
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function() {
            return current_user_can( 'edit_posts' );
        },
    ] );

    register_post_meta( 'post', '_learnquran_toc_title', [
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function() {
            return current_user_can( 'edit_posts' );
        },
    ] );

    register_post_meta( 'post', '_learnquran_toc_levels', [
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function() {
            return current_user_can( 'edit_posts' );
        },
    ] );

    register_post_meta( 'post', '_learnquran_toc_collapsed', [
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function() {
            return current_user_can( 'edit_posts' );
        },
    ] );
}
add_action( 'init', 'learnquran_register_post_toc_meta' );

/* Register Sidebar Meta Box In Post Editor */
function learnquran_add_post_toc_meta_box() {
    add_meta_box(
        'learnquran_post_toc_box',
        __( 'Daftar Isi / Table of Contents', 'learnquran' ),
        'learnquran_render_post_toc_meta_box',
        'post',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'learnquran_add_post_toc_meta_box' );

/* Render Table Of Contents Settings In Post Editor Sidebar */
function learnquran_render_post_toc_meta_box( $targetPost ) {
    wp_nonce_field( 'learnquran_save_post_toc_meta', 'learnquran_post_toc_nonce' );

    $enableTableOfContents           = get_post_meta( $targetPost->ID, '_learnquran_enable_toc', true );
    $tableOfContentsTitle            = get_post_meta( $targetPost->ID, '_learnquran_toc_title', true );
    $tableOfContentsLevels           = get_post_meta( $targetPost->ID, '_learnquran_toc_levels', true );
    $tableOfContentsDefaultCollapsed = get_post_meta( $targetPost->ID, '_learnquran_toc_collapsed', true );

    /* Default To Enabled If Not Explicitly Set */
    $isTableOfContentsEnabled = ( '' === $enableTableOfContents || 'yes' === $enableTableOfContents );
    if ( '' === $tableOfContentsTitle ) {
        $tableOfContentsTitle = 'Daftar Isi';
    }
    if ( '' === $tableOfContentsLevels ) {
        $tableOfContentsLevels = 'h2,h3';
    }
    $isDefaultCollapsed = ( 'yes' === $tableOfContentsDefaultCollapsed );
    ?>
    <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px; color: #1e293b;">
        <label style="display: flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer;">
            <input 
                type="checkbox" 
                name="learnquran_enable_toc" 
                value="yes" 
                <?php checked( $isTableOfContentsEnabled, true ); ?> 
                style="margin: 0; border-radius: 4px;"
            />
            <span><?php _e( 'Tampilkan Daftar Isi Otomatis', 'learnquran' ); ?></span>
        </label>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 4px; font-size: 12px; color: #475569;">
                <?php _e( 'Judul Kotak Daftar Isi:', 'learnquran' ); ?>
            </label>
            <input 
                type="text" 
                name="learnquran_toc_title" 
                value="<?php echo esc_attr( $tableOfContentsTitle ); ?>" 
                placeholder="Daftar Isi" 
                style="width: 100%; padding: 5px 8px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 13px;"
            />
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 4px; font-size: 12px; color: #475569;">
                <?php _e( 'Tingkatan Heading yang Disertakan:', 'learnquran' ); ?>
            </label>
            <div style="display: flex; gap: 12px;">
                <label style="display: flex; align-items: center; gap: 4px; font-size: 12px; cursor: pointer;">
                    <input 
                        type="checkbox" 
                        name="learnquran_toc_level_h2" 
                        value="h2" 
                        <?php checked( strpos( $tableOfContentsLevels, 'h2' ) !== false, true ); ?> 
                    />
                    <span>H2 / Utama</span>
                </label>
                <label style="display: flex; align-items: center; gap: 4px; font-size: 12px; cursor: pointer;">
                    <input 
                        type="checkbox" 
                        name="learnquran_toc_level_h3" 
                        value="h3" 
                        <?php checked( strpos( $tableOfContentsLevels, 'h3' ) !== false, true ); ?> 
                    />
                    <span>H3 / Subbagian</span>
                </label>
            </div>
        </div>

        <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; cursor: pointer; color: #64748b;">
            <input 
                type="checkbox" 
                name="learnquran_toc_collapsed" 
                value="yes" 
                <?php checked( $isDefaultCollapsed, true ); ?> 
                style="margin: 0; border-radius: 4px;"
            />
            <span><?php _e( 'Tutup secara awal (Collapsed)', 'learnquran' ); ?></span>
        </label>

        <div style="padding: 8px 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 11px; line-height: 1.4; color: #64748b;">
            💡 <strong>Info:</strong> Daftar Isi akan otomatis membaca tag Heading (H2, H3) di artikel Anda dan menampilkannya di sisi kiri konten dengan tautan lompat halus.
        </div>
    </div>
    <?php
}

/* Save Table Of Contents Settings When Post Is Saved */
function learnquran_save_post_toc_meta( $postIdentifier ) {
    if ( ! isset( $_POST['learnquran_post_toc_nonce'] ) || ! wp_verify_nonce( $_POST['learnquran_post_toc_nonce'], 'learnquran_save_post_toc_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $postIdentifier ) ) {
        return;
    }

    $enableTableOfContents = isset( $_POST['learnquran_enable_toc'] ) ? 'yes' : 'no';
    update_post_meta( $postIdentifier, '_learnquran_enable_toc', $enableTableOfContents );

    if ( isset( $_POST['learnquran_toc_title'] ) ) {
        $cleanTitle = sanitize_text_field( $_POST['learnquran_toc_title'] );
        update_post_meta( $postIdentifier, '_learnquran_toc_title', $cleanTitle ?: 'Daftar Isi' );
    }

    $selectedLevels = [];
    if ( ! empty( $_POST['learnquran_toc_level_h2'] ) ) {
        $selectedLevels[] = 'h2';
    }
    if ( ! empty( $_POST['learnquran_toc_level_h3'] ) ) {
        $selectedLevels[] = 'h3';
    }
    $levelsString = ! empty( $selectedLevels ) ? implode( ',', $selectedLevels ) : 'h2,h3';
    update_post_meta( $postIdentifier, '_learnquran_toc_levels', $levelsString );

    $isCollapsed = isset( $_POST['learnquran_toc_collapsed'] ) ? 'yes' : 'no';
    update_post_meta( $postIdentifier, '_learnquran_toc_collapsed', $isCollapsed );
}
add_action( 'save_post_post', 'learnquran_save_post_toc_meta' );

/* Automatically Inject Unique Identifiers Into Content Headings And Expose Table Of Contents Settings In REST API */
function learnquran_filter_rest_post_toc( $restResponse, $targetPost, $request ) {
    $enableTableOfContents = get_post_meta( $targetPost->ID, '_learnquran_enable_toc', true );
    if ( '' === $enableTableOfContents ) {
        $enableTableOfContents = 'yes';
    }
    $tableOfContentsTitle            = get_post_meta( $targetPost->ID, '_learnquran_toc_title', true ) ?: 'Daftar Isi';
    $tableOfContentsLevels           = get_post_meta( $targetPost->ID, '_learnquran_toc_levels', true ) ?: 'h2,h3';
    $tableOfContentsDefaultCollapsed = get_post_meta( $targetPost->ID, '_learnquran_toc_collapsed', true ) === 'yes';

    $restResponse->data['toc_settings'] = [
        'enabled'   => ( 'yes' === $enableTableOfContents ),
        'title'     => $tableOfContentsTitle,
        'levels'    => $tableOfContentsLevels,
        'collapsed' => $tableOfContentsDefaultCollapsed,
    ];

    /* Inject Unique Anchor Identifiers Into Rendered Content Headings */
    if ( ! empty( $restResponse->data['content']['rendered'] ) ) {
        $renderedContent = $restResponse->data['content']['rendered'];
        $headingCounter  = 0;
        $seenAnchorSlugs = [];

        $renderedContent = preg_replace_callback( '/<(h[2-4])(.*?)>(.*?)<\/\1>/i', function( $matches ) use ( &$headingCounter, &$seenAnchorSlugs ) {
            $headingTag        = $matches[1];
            $headingAttributes = $matches[2];
            $headingInnerHtml  = $matches[3];
            $headingCounter++;

            /* Check If An Existing Identifier Is Present */
            if ( preg_match( '/id=[\'"]([^\'"]+)[\'"]/i', $headingAttributes, $idMatch ) ) {
                $anchorSlug = $idMatch[1];
            } else {
                $cleanHeadingText = wp_strip_all_tags( $headingInnerHtml );
                $anchorSlug       = sanitize_title( $cleanHeadingText );
                if ( empty( $anchorSlug ) ) {
                    $anchorSlug = 'section-' . $headingCounter;
                }

                /* Ensure Uniqueness In Case Of Duplicate Headings */
                if ( isset( $seenAnchorSlugs[ $anchorSlug ] ) ) {
                    $seenAnchorSlugs[ $anchorSlug ]++;
                    $anchorSlug = $anchorSlug . '-' . $seenAnchorSlugs[ $anchorSlug ];
                } else {
                    $seenAnchorSlugs[ $anchorSlug ] = 1;
                }

                $headingAttributes .= ' id="' . esc_attr( $anchorSlug ) . '"';
            }

            return '<' . $headingTag . $headingAttributes . '>' . $headingInnerHtml . '</' . $headingTag . '>';
        }, $renderedContent );

        $restResponse->data['content']['rendered'] = $renderedContent;
    }

    return $restResponse;
}
add_filter( 'rest_prepare_post', 'learnquran_filter_rest_post_toc', 10, 3 );

