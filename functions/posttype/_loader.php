<?php
/* Load All Custom Post Types */

if ( ! defined( 'ABSPATH' ) ) {
    exit; /* Exit If Accessed Directly */
}

require_once __DIR__ . '/program.php';
require_once __DIR__ . '/testimonial.php';
require_once __DIR__ . '/mentor.php';
require_once __DIR__ . '/faq.php';
require_once __DIR__ . '/post.php';

