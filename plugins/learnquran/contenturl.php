<?php
/**
 * Dynamic Content Uniform Resource Locator Handler For LearnQuran Plugin
 * Replaces Hardcoded Domain Uniform Resource Locators In Post Content And Post Metadata With Dynamic Placeholder
 * Restores Dynamic Uniform Resource Locators On Content Retrieval And Rendering
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

/* Define Uniform Resource Locator Placeholder Constant */
if ( ! defined( 'LEARNQURAN_URL_PLACEHOLDER' ) ) {
    define( 'LEARNQURAN_URL_PLACEHOLDER', '[domain]' );
}

/**
 * Retrieve All Search Pattern Variations For Current Domain
 * Includes Secure And Non-Secure Protocols / Trailing Slash Variations / JavaScript Object Notation Escaped Formats
 *
 * @return array<int, string>
 */
function learnquran_get_site_url_patterns(): array {
    $activeHomeUrl = rtrim( home_url(), '/' );
    $activeSiteUrl = rtrim( site_url(), '/' );

    $registeredDomainUrls = array_unique( array_filter( [ $activeHomeUrl, $activeSiteUrl ] ) );
    $replacementSearchPatterns = [];

    foreach ( $registeredDomainUrls as $registeredDomainUrl ) {
        /* Standard Uniform Resource Locator Variations */
        $replacementSearchPatterns[] = $registeredDomainUrl . '/';
        $replacementSearchPatterns[] = $registeredDomainUrl;

        /* Alternative Protocol Variations / Secure Hypertext Transfer Protocol And Insecure Protocol */
        if ( strpos( $registeredDomainUrl, 'https://' ) === 0 ) {
            $insecureProtocolUrl = 'http://' . substr( $registeredDomainUrl, 8 );
            $replacementSearchPatterns[] = $insecureProtocolUrl . '/';
            $replacementSearchPatterns[] = $insecureProtocolUrl;
        } elseif ( strpos( $registeredDomainUrl, 'http://' ) === 0 ) {
            $secureProtocolUrl = 'https://' . substr( $registeredDomainUrl, 7 );
            $replacementSearchPatterns[] = $secureProtocolUrl . '/';
            $replacementSearchPatterns[] = $secureProtocolUrl;
        }

        /* JavaScript Object Notation Escaped Variations / Common Inside Block Editor Attributes */
        $escapedDomainUrl = str_replace( '/', '\/', $registeredDomainUrl );
        $replacementSearchPatterns[] = $escapedDomainUrl . '\/';
        $replacementSearchPatterns[] = $escapedDomainUrl;
    }

    /* Sort By String Length Descending / Longer Paths Match First */
    usort( $replacementSearchPatterns, function( $firstPattern, $secondPattern ) {
        return strlen( $secondPattern ) - strlen( $firstPattern );
    } );

    return array_values( array_unique( $replacementSearchPatterns ) );
}

/**
 * Replace Active Domain In String Payload
 *
 * @param string $rawContentPayload
 * @return string
 */
function learnquran_replace_domain_in_string( string $rawContentPayload ): string {
    if ( empty( $rawContentPayload ) ) {
        return $rawContentPayload;
    }

    $replacementSearchPatterns = learnquran_get_site_url_patterns();
    $targetPlaceholder         = LEARNQURAN_URL_PLACEHOLDER;

    foreach ( $replacementSearchPatterns as $replacementSearchPattern ) {
        $isEscapedPattern = ( strpos( $replacementSearchPattern, '\/' ) !== false );
        $replacementToken = $isEscapedPattern ? $targetPlaceholder . '\/' : $targetPlaceholder . '/';

        $hasTrailingSlash = substr( $replacementSearchPattern, -1 ) === '/' || substr( $replacementSearchPattern, -2 ) === '\/';
        $effectiveReplacement = $hasTrailingSlash ? $replacementToken : rtrim( $replacementToken, '/\\' );

        $rawContentPayload = str_replace(
            $replacementSearchPattern,
            $effectiveReplacement,
            $rawContentPayload
        );
    }

    return $rawContentPayload;
}

/**
 * Recursively Replace Active Domain In Metadata Value Payload / Supports Strings / Arrays / Objects
 *
 * @param mixed $metadataValuePayload
 * @return mixed
 */
function learnquran_replace_domain_deep( $metadataValuePayload ) {
    if ( is_string( $metadataValuePayload ) ) {
        return learnquran_replace_domain_in_string( $metadataValuePayload );
    }

    if ( is_array( $metadataValuePayload ) ) {
        $normalizedArrayPayload = [];
        foreach ( $metadataValuePayload as $arrayItemKey => $arrayItemValue ) {
            $normalizedArrayPayload[ $arrayItemKey ] = learnquran_replace_domain_deep( $arrayItemValue );
        }
        return $normalizedArrayPayload;
    }

    if ( is_object( $metadataValuePayload ) ) {
        $clonedObjectPayload = clone $metadataValuePayload;
        foreach ( get_object_vars( $clonedObjectPayload ) as $propertyName => $propertyValue ) {
            $clonedObjectPayload->$propertyName = learnquran_replace_domain_deep( $propertyValue );
        }
        return $clonedObjectPayload;
    }

    return $metadataValuePayload;
}

/**
 * Inspect Whether Payload Contains Dynamic Placeholder / Recursively Checks Arrays And Objects
 *
 * @param mixed $inspectedPayload
 * @return bool
 */
function learnquran_has_domain_placeholder( $inspectedPayload ): bool {
    if ( is_string( $inspectedPayload ) ) {
        return ( strpos( $inspectedPayload, LEARNQURAN_URL_PLACEHOLDER ) !== false );
    }

    if ( is_array( $inspectedPayload ) ) {
        foreach ( $inspectedPayload as $arrayElementItem ) {
            if ( learnquran_has_domain_placeholder( $arrayElementItem ) ) {
                return true;
            }
        }
        return false;
    }

    if ( is_object( $inspectedPayload ) ) {
        foreach ( get_object_vars( $inspectedPayload ) as $objectPropertyItem ) {
            if ( learnquran_has_domain_placeholder( $objectPropertyItem ) ) {
                return true;
            }
        }
        return false;
    }

    return false;
}

/*
 * 1. Persist Post Content To Database / Replace Active Domain With Placeholder
 * Automatically Normalizes Media And Asset Links In Post Content And Excerpt Before Storing
 */
add_filter( 'wp_insert_post_data', function ( array $sanitizedPostData, array $rawPostData ): array {
    /* Replace Domain Occurrences Inside Post Content */
    if ( ! empty( $sanitizedPostData['post_content'] ) ) {
        $sanitizedPostData['post_content'] = learnquran_replace_domain_in_string(
            $sanitizedPostData['post_content']
        );
    }

    /* Replace Domain Occurrences Inside Post Excerpt */
    if ( ! empty( $sanitizedPostData['post_excerpt'] ) ) {
        $sanitizedPostData['post_excerpt'] = learnquran_replace_domain_in_string(
            $sanitizedPostData['post_excerpt']
        );
    }

    return $sanitizedPostData;
}, 10, 2 );

/*
 * 2. Persist Post Metadata To Database / Replace Active Domain With Placeholder
 * Automatically Intercepts Adding And Updating Post Meta To Store Normalized Values
 */
add_filter( 'update_post_metadata', function( $checkShortCircuit, int $postIdentifier, string $metaKeyName, $metaValuePayload, $previousMetaValue ) {
    static $isUpdatingPostMetadata = false;

    if ( $isUpdatingPostMetadata ) {
        return null;
    }

    $transformedMetaValue = learnquran_replace_domain_deep( $metaValuePayload );

    if ( $transformedMetaValue !== $metaValuePayload ) {
        $isUpdatingPostMetadata = true;
        $updateOperationResult = update_metadata( 'post', $postIdentifier, $metaKeyName, wp_slash( $transformedMetaValue ), $previousMetaValue );
        $isUpdatingPostMetadata = false;
        return $updateOperationResult;
    }

    return null;
}, 10, 5 );

add_filter( 'add_post_metadata', function( $checkShortCircuit, int $postIdentifier, string $metaKeyName, $metaValuePayload, bool $isUniqueEntry ) {
    static $isAddingPostMetadata = false;

    if ( $isAddingPostMetadata ) {
        return null;
    }

    $transformedMetaValue = learnquran_replace_domain_deep( $metaValuePayload );

    if ( $transformedMetaValue !== $metaValuePayload ) {
        $isAddingPostMetadata = true;
        $addOperationResult = add_metadata( 'post', $postIdentifier, $metaKeyName, wp_slash( $transformedMetaValue ), $isUniqueEntry );
        $isAddingPostMetadata = false;
        return $addOperationResult;
    }

    return null;
}, 10, 5 );

/**
 * 3. Render On Frontend / Restore Dynamic Domain From Placeholder
 * Replaces Stored Placeholders With Current Active Home Uniform Resource Locator
 *
 * @param mixed $rawContentPayload
 * @return mixed
 */
function restore_dynamic_site_url( $rawContentPayload ) {
    if ( empty( $rawContentPayload ) || ! is_string( $rawContentPayload ) ) {
        return $rawContentPayload;
    }

    $targetPlaceholder = LEARNQURAN_URL_PLACEHOLDER;
    $escapedPlaceholder = str_replace( '/', '\/', $targetPlaceholder );

    if ( strpos( $rawContentPayload, $targetPlaceholder ) === false && strpos( $rawContentPayload, $escapedPlaceholder ) === false ) {
        return $rawContentPayload;
    }

    $activeHomeUrl = rtrim( home_url(), '/' );
    $escapedActiveHomeUrl = str_replace( '/', '\/', $activeHomeUrl );

    $rawContentPayload = str_replace( $escapedPlaceholder, $escapedActiveHomeUrl, $rawContentPayload );
    return str_replace( $targetPlaceholder, $activeHomeUrl, $rawContentPayload );
}

/**
 * Recursively Restore Dynamic Domain In Metadata Value Payload / Supports Strings / Arrays / Objects
 *
 * @param mixed $metadataValuePayload
 * @return mixed
 */
function learnquran_restore_domain_deep( $metadataValuePayload ) {
    if ( is_string( $metadataValuePayload ) ) {
        return restore_dynamic_site_url( $metadataValuePayload );
    }

    if ( is_array( $metadataValuePayload ) ) {
        $restoredArrayPayload = [];
        foreach ( $metadataValuePayload as $arrayItemKey => $arrayItemValue ) {
            $restoredArrayPayload[ $arrayItemKey ] = learnquran_restore_domain_deep( $arrayItemValue );
        }
        return $restoredArrayPayload;
    }

    if ( is_object( $metadataValuePayload ) ) {
        $clonedObjectPayload = clone $metadataValuePayload;
        foreach ( get_object_vars( $clonedObjectPayload ) as $propertyName => $propertyValue ) {
            $clonedObjectPayload->$propertyName = learnquran_restore_domain_deep( $propertyValue );
        }
        return $clonedObjectPayload;
    }

    return $metadataValuePayload;
}

/*
 * 4. Retrieve Post Metadata From Database / Restore Dynamic Domain
 * Automatically Replaces Placeholder With Current Active Domain When Fetching Metadata
 * Strictly Preserves WordPress Short-Circuit Contract By Wrapping Single Return Values In List Array
 */
add_filter( 'get_post_metadata', function( $checkShortCircuit, int $postIdentifier, string $metaKeyName, bool $isSingleValue, string $metaTypeName ) {
    static $isRetrievingPostMetadata = false;

    if ( $isRetrievingPostMetadata ) {
        return null;
    }

    $isRetrievingPostMetadata = true;
    $retrievedRawMetadata = get_metadata( 'post', $postIdentifier, $metaKeyName, $isSingleValue );
    $isRetrievingPostMetadata = false;

    /* Bail Out Early If Metadata Does Not Exist Or Does Not Contain Domain Placeholder */
    if ( null === $retrievedRawMetadata || ! learnquran_has_domain_placeholder( $retrievedRawMetadata ) ) {
        return null;
    }

    $restoredMetadataPayload = learnquran_restore_domain_deep( $retrievedRawMetadata );

    /* WordPress Expects Array When Single Is True To Unpack Index Zero Cleanly */
    if ( $isSingleValue ) {
        return [ $restoredMetadataPayload ];
    }

    return $restoredMetadataPayload;
}, 10, 5 );

/* Standard WordPress Content Filter Hooks */
add_filter( 'the_content', 'restore_dynamic_site_url', 1 );
add_filter( 'the_excerpt', 'restore_dynamic_site_url', 1 );
add_filter( 'widget_text_content', 'restore_dynamic_site_url', 1 );
add_filter( 'widget_block_content', 'restore_dynamic_site_url', 1 );

/*
 * 5. Open In Admin Editor / Ensure Media Preview Remains Functional While Editing
 * Pre-Fills Active Uniform Resource Locators In Both Classic Editor And Gutenberg REST Endpoints
 */
/* Classic Editor Support */
add_filter( 'content_edit_pre', 'restore_dynamic_site_url', 1 );
add_filter( 'excerpt_edit_pre', 'restore_dynamic_site_url', 1 );

/* Block Editor And Representational State Transfer Application Programming Interface Support */
function restore_dynamic_url_rest_api( WP_REST_Response $restResponse, WP_Post $postObject, WP_REST_Request $restRequest ): WP_REST_Response {
    if ( ! is_object( $restResponse ) || ! isset( $restResponse->data ) ) {
        return $restResponse;
    }

    $activeHomeUrl = rtrim( home_url(), '/' );
    $targetPlaceholder = LEARNQURAN_URL_PLACEHOLDER;

    /* Restore Raw And Rendered Content Fields */
    if ( isset( $restResponse->data['content']['raw'] ) ) {
        $restResponse->data['content']['raw'] = str_replace( $targetPlaceholder, $activeHomeUrl, $restResponse->data['content']['raw'] );
    }
    if ( isset( $restResponse->data['content']['rendered'] ) ) {
        $restResponse->data['content']['rendered'] = str_replace( $targetPlaceholder, $activeHomeUrl, $restResponse->data['content']['rendered'] );
    }

    /* Restore Raw And Rendered Excerpt Fields */
    if ( isset( $restResponse->data['excerpt']['raw'] ) ) {
        $restResponse->data['excerpt']['raw'] = str_replace( $targetPlaceholder, $activeHomeUrl, $restResponse->data['excerpt']['raw'] );
    }
    if ( isset( $restResponse->data['excerpt']['rendered'] ) ) {
        $restResponse->data['excerpt']['rendered'] = str_replace( $targetPlaceholder, $activeHomeUrl, $restResponse->data['excerpt']['rendered'] );
    }

    /* Restore Meta Fields If Present In Response */
    if ( isset( $restResponse->data['meta'] ) && is_array( $restResponse->data['meta'] ) ) {
        $restResponse->data['meta'] = learnquran_restore_domain_deep( $restResponse->data['meta'] );
    }

    return $restResponse;
}

/* Register Prepare Filters Dynamically For All Public Post Types */
add_action( 'rest_api_init', function () {
    $registeredPostTypes = get_post_types( [ 'show_in_rest' => true ] );
    foreach ( $registeredPostTypes as $registeredPostType ) {
        add_filter( "rest_prepare_{$registeredPostType}", 'restore_dynamic_url_rest_api', 10, 3 );
    }
}, 20 );

/*
 * 6. Handle Theme Custom Endpoints / Ensure Proper Domain Resolution In Payload
 * Traverses Custom Endpoint Payloads And Normalizes Any Embedded Placeholders
 */
add_filter( 'rest_post_dispatch', function ( $dispatchedResponse, WP_REST_Server $restServerInstance, WP_REST_Request $restRequestInstance ) {
    if ( ! is_object( $dispatchedResponse ) || empty( $dispatchedResponse->data ) ) {
        return $dispatchedResponse;
    }

    $activeRoutePath = $restRequestInstance->get_route();
    if ( strpos( $activeRoutePath, '/learnquran/' ) !== false || strpos( $activeRoutePath, '/wp/' ) !== false ) {
        if ( is_array( $dispatchedResponse->data ) || is_object( $dispatchedResponse->data ) ) {
            $dispatchedResponse->data = learnquran_restore_domain_deep( $dispatchedResponse->data );
        }
    }

    return $dispatchedResponse;
}, 10, 3 );

/*
 * 7. Customizer Hero Image Support / Handle Theme Mod Dynamic Replacement
 * Ensures Uploaded Hero Images And Customizer Options Are Restored Across Different Domains
 */
$heroImageOptionKeys = [
    'theme_mod_learnquran_hero_image_one',
    'theme_mod_learnquran_hero_image_two',
    'theme_mod_learnquran_hero_image_three',
];
foreach ( $heroImageOptionKeys as $heroImageOptionKey ) {
    add_filter( $heroImageOptionKey, 'restore_dynamic_site_url', 10 );
}
