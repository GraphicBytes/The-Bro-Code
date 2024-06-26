<?php
//###############################################
//############### VERSION CONTROL ###############
//###############################################
$generator = "BFAM 4.2.17";
$generator_v_num = "4.2.17";

//###########################################
//############### ENVIRONMENT ###############
//###########################################
include_once('environment.php');

//###########################################
//############### SET HEADERS ###############
//###########################################
header('Content-Type: text/html; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
header('Referrer-Policy: no-referrer-when-downgrade');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Permissions-Policy: geolocation=(), microphone=(), camera=(), fullscreen=(), payment=(), interest-cohort=(), attribution-reporting=(), run-ad-auction=(), join-ad-interest-group=(), browsing-topics=()");
header('X-XSS-Protection: 1; mode=block');
header("Access-Control-Allow-Origin: *");
header('Cross-Origin-Embedder-Policy: require-corp');
header('Cross-Origin-Opener-Policy: same-origin');
header('Cross-Origin-Resource-Policy: same-origin');
header('Expect-CT: enforce, max-age=86400');

//#######################################
//############### CONFIGS ###############
//#######################################
include_once('config/db.php');
include_once('config/known_bots.php');

//#########################################
//############### FUNCTIONS ###############
//#########################################
include_once('functions/login-check.php');
include_once('functions/trim_words.php');
include_once('functions/mobiledetect.php');
include_once('functions/profanity_filter.php');
include_once('functions/random_str.php');
include_once('functions/slugify.php');
include_once('functions/resize-class.php');
include_once('functions/secondstotime.php');
include_once('functions/SBBCodeParser.php');
include_once('functions/delete_image.php');
include_once('functions/encryption.php');
include_once('functions/system_data.php');
include_once('functions/tokens.php');
include_once('functions/track_user.php');
include_once('functions/verifyEmail.php');
include_once('functions/log_malicious.php');
include_once('functions/bot_check.php');
include_once('functions/is_malicious.php');
include_once('functions/RedisCache.php'); 

//###########################################
//############### SYSTEM DATA ###############
//###########################################
$system_data = system_data();
$request_time = time();

//#######################################################
//############### FIRE UP CLASS FUNCTIONS ###############
//#######################################################
//bbcode SSBBCodeParser
$parser = new \SBBCodeParser\Node_Container_Document();
//start pranity filter
$profanity = new filter_profanity; //echo $profanity->filter_string($content);
// Encryption
$crypt = new EncryptData();
$crypt->set_key($encryption_key);
// new csrf
$tokens = new tokens();
$tokens->set_tokens($system_data['csrf_tokens']);
$tokens->set_spam_tokens($system_data['anti_spam_tokens']);
// email validator
$vmail = new verifyEmail();
$vmail->setStreamTimeoutWait(10);
$vmail->setEmailFrom($smtp_from);

//#####################################################
//############### TRACKING AND SECURITY ###############
//#####################################################
$is_user_a_bot = bot_check();
$csrf_token = $tokens->get_token();
$track_this = 0;

//###################################################
//############### MOBILE DEVICE CHECK ###############
//###################################################
$detect = new Mobile_Detect;
if ($detect->isMobile() && !$detect->version('iPad')) {
  $mobile = 1;
} else {
  $mobile = 0;
}

//##############################################
//############### MASTER OPTIONS ###############
//##############################################
//##### Moderation #####
$moderation = $system_data['moderation'];
//##### System Limits and Variables #####
$comment_limit = 10;

//#####################################################
//############### SET INITIAL VARIABLES ###############
//#####################################################
include_once('config/initial-variables.php');

//############################################
//############### DEFAULT META ###############
//############################################
//default title
$pagetitle = "Internet Stuff For Bros | The Bro Code";
//default description
$pagedescription = "Internet Stuff For Bros";
//default canonical
$canonical = $base_url;
//default og_image
$og_image = $base_url . "/styles/images/social.jpg";
$mainmenu = 1;

//#################################################
//############### USER LOGIN STATUS ###############
//#################################################

ob_start();

$login_details = login_check();
$logged_in_id = $login_details['id'];

if ($logged_in_id > 0) {
  $email_verfied = $login_details['email_verfied'];
  $notification = $login_details['notification'];
  $tandc_seen = $login_details['tandc_seen'];
  $view_order = $login_details['view_order'];
  $hide_shit = $login_details['hide_shit'];
  $account_type = $login_details['account_type'];

  $user_display_name = $login_details['user_display_name'];
  $user_email = $login_details['user_email'];
  $user_bio = $login_details['user_bio'];

  $user_facebook = $login_details['user_facebook'];
  $user_twitter = $login_details['user_twitter'];
  $user_website = $login_details['user_website'];

  $user_avatar = $login_details['user_avatar'];
  $avatar_mini = $login_details['user_avatar_mini'];

  $session_id = $login_details['session_id'];

  $update_profile = $login_details['update_profile'];
} else {

  $redisCache = new RedisCache();

  $requestURI = $_SERVER['REQUEST_URI'];
  $path = parse_url($requestURI, PHP_URL_PATH);

  if ($path == "" || $path == null || $path == "/") {
    $path = "/home/";
  }

  $cacheKey = $path . $mobile;

  $cache_data = $redisCache->get($cacheKey);
  if ($cache_data !== false) {
    if ($env == 1) {
      echo $cache_data;
      echo "<!-- cached -->";
      exit();
      die();
    }
  }

  $set_cache = false;
}



//###########################################
//############### THE REQUEST ###############
//###########################################
$page = null;
$typea = null;
$typeb = null;
$typec = null;
$typed = null;
if (isset($_GET['page'])) {
  $page = $_GET['page'];
}
if (isset($_GET['typea'])) {
  $typea = $_GET['typea'];
}
if (isset($_GET['typeb'])) {
  $typeb = $_GET['typeb'];
}
if (isset($_GET['typec'])) {
  $typec = $_GET['typec'];
}
if (isset($_GET['typed'])) {
  $typed = $_GET['typed'];
}

//#####################################################################
//#####################################################################
//####################                             ####################
//####################   2020 NEW PAGE STRUCTURE   ####################
//####################                             ####################
//#####################################################################
//#####################################################################

//############################
//##### system FUNCTIONS #####
//############################

// Trigger Cron Jobs
if ($page == "system-cron-ping-zfks6aa") {
  include($php_base_directory . '/crons/cron_master.php');
}
// Trigger Moderation
else if ($page == "moderation-trigger" && $logged_in_id == 1) {
  include($php_base_directory . '/sections/system/moderation-trigger.php');
}
// Goto next page with something to moderate
else if ($page == "next-moderate" && $logged_in_id == 1) {
  $code_toolbar = 1;
  include($php_base_directory . '/sections/system/next-moderate.php');
}
// MODERATOR BAN USER
else if ($page == "ban-user" && $logged_in_id == 1) {
  $code_toolbar = 1;
  include($php_base_directory . '/sections/system/ban-user.php');
}
// hack fixes
else if ($page == "hackfix" && $logged_in_id == 1) {
  include($php_base_directory . '/sections/system/hackfix.php');
}

//////////////
/////code/////
//////////////
// Moderate Code Comment
else if ($page == "moderate-code-comment" && $logged_in_id == 1) {
  $code_toolbar = 1;
  include($php_base_directory . '/sections/system/moderate-code-comment.php');
}
// Moderate Code Variant Comment
else if ($page == "moderate-code-variant-comment" && $logged_in_id == 1) {
  $code_toolbar = 1;
  include($php_base_directory . '/sections/system/moderate-code-variant-comment.php');
}
// Moderate Code Variant
else if ($page == "moderate-code-variant" && $logged_in_id == 1) {
  $code_toolbar = 1;
  include($php_base_directory . '/sections/system/moderate-code-variant.php');
}
// MODERATOR-DELETE Code Comment
else if ($page == "moderate-code-comment-delete" && $logged_in_id == 1) {
  $code_toolbar = 1;
  include($php_base_directory . '/sections/system/moderate-code-comment-delete.php');
}
// MODERATOR-WARN Variant Comment and issue warning
else if ($page == "moderate-variant-comment-warn" && $logged_in_id == 1) {
  $code_toolbar = 1;
  include($php_base_directory . '/sections/system/moderate-variant-comment-warn.php');
}
// MODERATOR-WARN Variant and issue warning
else if ($page == "moderate-variant-warn" && $logged_in_id == 1) {
  $code_toolbar = 1;
  include($php_base_directory . '/sections/system/moderate-variant-warn.php');
}
// MODERATOR-DELETE Variant Comment
else if ($page == "moderate-variant-comment-delete" && $logged_in_id == 1) {
  $code_toolbar = 1;
  include($php_base_directory . '/sections/system/moderate-variant-comment-delete.php');
}
// MODERATOR-DELETE Code Comment and issue warning
else if ($page == "moderate-code-comment-warn" && $logged_in_id == 1) {
  $code_toolbar = 1;
  include($php_base_directory . '/sections/system/moderate-code-comment-warn.php');
}

//##############################
//##### PRIORITY FUNCTIONS #####
//##############################

// Log-out
else if ($page == "logout") {
  include($php_base_directory . '/sections/user/logout.php');
}
// Log-in check
else if ($page == "logincheck") {
  include($php_base_directory . '/sections/user/login-check.php');
}
// Update Profile
else if ($page == "updateprofile" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/user/update-profile.php');
}
// Update Profile Photo
else if ($page == "updateprofilephoto" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/user/update-profile-photo.php');
}

//##########################
//##### USER FUNCTIONS #####
//##########################

// signup
else if ($page == "signup" && $logged_in_id < 1) {
  include($php_base_directory . '/sections/user/signup.php');
}
// validate email
else if ($page == "signupvalidate") {
  include($php_base_directory . '/sections/user/signupvalidate.php');
}
// Lost Password
else if ($page == "lostpw") {
  include($php_base_directory . '/sections/user/lostpw.php');
}
// Reset Password
else if ($page == "resetpw") {
  include($php_base_directory . '/sections/user/resetpw.php');
}
// Change View Order
else if ($page == "change-view-order" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/user/change-view-order.php');
}
// Hide Shit
else if ($page == "hide-shit" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/user/hide-shit.php');
}
// Facebook deauthorisation
else if ($page == "deauthorise_fb") {
  include($php_base_directory . '/sections/user/deauthorise_fb.php');
}



//##################################
//##### TnCS CHECK & HOME PAGE #####
//##################################

// TNC RESPONSE
else if ($page == "tncresponse" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/legal/tncs_response.php');
}
// DOES USER NEED TO AGREE TO T&CS?
else if (($logged_in_id > 0 && $tandc_seen == 0) or ($logged_in_id > 0 && $page == "tncs")) {
  $tnc_bounce = 0;
  if ($logged_in_id > 0 && $tandc_seen == 0) {
    $tnc_bounce = 1;
  }
  if ($logged_in_id > 0 && $page == "tncs") {
    $tnc_bounce = 2;
  }
  $viewing_tncs = 1;
  include($php_base_directory . '/sections/legal/tncs.php');
}
// HOME PAGE
else if ($page == "start" or $page == "nowsignedup" or $page == "pwreset") {
  $set_cache = true;
  $track_this = 1;
  $viewing_home = 1;
  include($php_base_directory . '/home.php');
} else if ($page == null) {
  $set_cache = true;
  // $code_toolbar = 1;
  // $thecode_menu = 1;
  // $the_code_css = 1;
  // $viewing_bro_codes = 1;
  //include($php_base_directory . '/sections/the-code/the-code.php');
  $track_this = 1;
  $viewing_home = 1;
  include($php_base_directory . '/home.php');
}



//#######################
//##### LEGAL PAGES #####
//#######################

// TERMS PAGE
else if ($page == "terms") {
  $set_cache = true;
  $track_this = 1;

  $legal_css = 1;
  $viewing_legal_page = 1;
  include($php_base_directory . '/sections/legal/terms.php');
}
// privacy
else if ($page == "privacy") {
  $set_cache = true;
  $track_this = 1;

  $legal_css = 1;
  $viewing_legal_page = 1;
  include($php_base_directory . '/sections/legal/privacy.php');
}
// ABOUT
else if ($page == "about") {
  $set_cache = true;
  $track_this = 1;

  $legal_css = 1;
  $viewing_legal_page = 1;
  include($php_base_directory . '/sections/legal/about.php');
}
// dmca
else if ($page == "dmca") {
  $set_cache = true;
  $track_this = 1;

  $legal_css = 1;
  $viewing_legal_page = 1;
  include($php_base_directory . '/sections/legal/dmca.php');
} else if ($page == "contact") {
  $set_cache = true;
  $track_this = 1;

  $legal_css = 1;
  $viewing_legal_page = 1;
  include($php_base_directory . '/sections/legal/contact.php');
}



//####################
//##### THE CODE #####
//####################

// printable
else if ($page == "printable") {
  $set_cache = true;
  $track_this = 1;

  $viewing_printable = 1;
  $printable_css = 1;
  include($php_base_directory . '/sections/the-code/printable.php');
}
// the-code
else if ($page == "the-code") {
  $set_cache = true;
  $track_this = 1;

  $code_toolbar = 1;
  $thecode_menu = 1;
  $the_code_css = 1;
  $viewing_bro_codes = 1;
  include($php_base_directory . '/sections/the-code/the-code.php');
}
// Single Code
else if ($page == "code") {
  $set_cache = true;
  $track_this = 1;

  $code_open = 1;
  $code_toolbar = 1;
  $thecode_menu = 1;
  $code_css = 1;
  $viewing_code = 1;
  include($php_base_directory . '/sections/the-code/code.php');
}
// Suggest Code
else if ($page == "suggest-code") {
  $set_cache = true;
  $track_this = 1;

  $suggest_code_css = 1;
  $code_toolbar = 1;
  $submit_menu = 1;
  $legal_css = 1;
  $suggest_code_open = 1;
  $viewing_legal_page = 1;
  include($php_base_directory . '/sections/the-code/suggest-code.php');
}
// Code Suggestions
else if ($page == "code-suggestions") {
  $set_cache = true;
  $track_this = 1;
  $suggestion_menu = 1;

  $code_toolbar = 1;
  $the_code_css = 1;
  $suggestions_open = 1;
  $viewing_bro_codes = 1;
  include($php_base_directory . '/sections/the-code/code-suggestions.php');
}
// Potential Code
else if ($page == "potential-code" || $page == "amend-code") {
  $set_cache = true;
  $track_this = 1;
  $suggestion_menu = 1;

  $code_toolbar = 1;
  $code_css = 1;
  $suggestions_open = 1;
  $viewing_code = 1;
  include($php_base_directory . '/sections/the-code/potential-code.php');
}

//## Code functions ##
// Rate Code
else if ($page == "rate-code" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/rate-code.php');
}
// Rate Variant
else if ($page == "rate-variant" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/rate-variant.php');
}
// Rate Code Comment
else if ($page == "rate-code-comment" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/rate-code-comment.php');
}
// Rate Code Variant Comment
else if ($page == "rate-code-variant-comment" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/rate-code-variant-comment.php');
}
// Submit Code Comment
else if ($page == "submit-code-comment" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/submit-code-comment.php');
}
// Submit Variant Comment
else if ($page == "submit-variant-comment" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/submit-variant-comment.php');
}
// Delete Code Comment
else if ($page == "delete-code-comment" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/delete-comment.php');
}
// Delete Code Variant Comment
else if ($page == "delete-code-variant-comment" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/delete-code-variant-comment.php');
}
// Reply To Code Comment
else if ($page == "replyto-code-comment" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/replyto-code-comment.php');
}
// Reply To Code Variant Comment
else if ($page == "replyto-code-variant-comment" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/replyto-code-variant-comment.php');
}
// Fetch reply form
else if ($page == "fetch-reply-form" && $logged_in_id > 0) {
  $set_cache = true;
  include($php_base_directory . '/sections/the-code/fetch-reply-form.php');
}
// Fetch variant comment reply form
else if ($page == "fetch-variant-reply-form" && $logged_in_id > 0) {
  $set_cache = true;
  include($php_base_directory . '/sections/the-code/fetch-variant-reply-form.php');
}
// Fetch Comment Children
else if ($page == "fetch-comment-children") {
  $set_cache = true;
  include($php_base_directory . '/sections/the-code/fetch-comment-children.php');
}
// Fetch Variant Comment Children
else if ($page == "fetch-variant-comment-children") {
  $set_cache = true;
  include($php_base_directory . '/sections/the-code/fetch-variant-comment-children.php');
}
// Fetch Comment Infants
else if ($page == "fetch-comment-infants") {
  $set_cache = true;
  include($php_base_directory . '/sections/the-code/fetch-comment-infants.php');
}
// Fetch Variant Comment Infants
else if ($page == "fetch-variant-comment-infants") {
  $set_cache = true;
  include($php_base_directory . '/sections/the-code/fetch-variant-comment-infants.php');
}
// Fetch next comment chunk
else if ($page == "fetch-next-comment-chunk") {
  $set_cache = true;
  include($php_base_directory . '/sections/the-code/fetch_next_comment_chunk.php');
}
// Fetch next variant comment chunk
else if ($page == "fetch-next-variant-comment-chunk") {
  $set_cache = true;
  include($php_base_directory . '/sections/the-code/fetch-next-variant-comment-chunk.php');
}
// Subit Code Suggestion
else if ($page == "submit-code-suggestion" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/submit-code-suggestion.php');
}
// Subit Code Suggestion
else if ($page == "submit-code-variant" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/submit-code-variant.php');
}
// Submit Code Suggestion
else if ($page == "delete-code-variant" && $logged_in_id > 0) {
  include($php_base_directory . '/sections/the-code/delete-code-variant.php');
}

//######################
//##### MEME MAKER #####
//######################

// Meme Maker
else if ($page == "meme-maker") {
  $set_cache = true;
  $track_this = 1;
  $meme_maker_menu = 1;
  $viewing_meme_maker = 1;
  $meme_maker_css = 1;
  include($php_base_directory . '/sections/meme-maker/meme-maker.php');
}

//###################
//##### DEFAULT #####
//###################

// Meme Maker
else if ($page == "test") {

  include($php_base_directory . '/test.php');
} else {
  $location = "Location: " . $base_url;
  header($location);
}

if ($track_this == 1 & $logged_in_id != 1) {
  track_user();
}

$output = ob_get_clean();

if ($minify == 1) {

  $scriptBlocks = [];
  $output = preg_replace_callback('/<script.*?>.*?<\/script>/is', function ($matches) use (&$scriptBlocks) {
    $scriptBlocks[] = $matches[0];
    return 'SCRIPT_BLOCK_PLACEHOLDER';
  }, $output);

  $output = preg_replace('/<!--.*?-->/', '', $output);
  $output = preg_replace('/>\s+</', '><', $output);
  $output = preg_replace('/\s+/', ' ', $output);
  $output = preg_replace('/\s+>/', '>', $output);
  $output = preg_replace('/<\s+/', '<', $output);

  foreach ($scriptBlocks as $index => $script) {
    
    // $script = preg_replace('/(?<!http:|https:)\s*\/\/.*$/m', '', $script);
    // $script = preg_replace('/\r\n|\n|\r/', '', $script);
    // $script = str_replace('    ', " ", $script);
    // $script = str_replace('   ', " ", $script);
    // $script = str_replace('  ', " ", $script);

    $output = preg_replace('/SCRIPT_BLOCK_PLACEHOLDER/', $script, $output, 1);
  } 

}

if ($env == 1 && $set_cache == true && $logged_in_id == 0) {
  $cache_data = $redisCache->set($cacheKey, $output, 900);
}

echo $output;



exit();
