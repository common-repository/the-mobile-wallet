<?php
/*
 *
 *	***** Digital Card *****
 *
 *	This file initializes all DC Core components
 *
 */
// If this file is called directly, abort. //
if (!defined("WPINC")) {
    die();
} // end if
// Define Our Constants
define("TMWCG_CORE_INC", dirname(__FILE__) . "/assets/inc/");
define("TMWCG_CORE_IMG", plugins_url("assets/img/", __FILE__));
define("TMWCG_CORE_CSS", plugins_url("assets/css/", __FILE__));
define("TMWCG_CORE_JS", plugins_url("assets/js/", __FILE__));

define("TMWCG_WALLET_KEY", "IG)(V{Y^_12317EF6{{a345}^Gga9z");
define("TMWCG_WALLET_REFERRAL", "organic");
define("TMWCG_WALLET_AFF", "");
define("TMWCG_WALLET_CLASSIFICATION", "Personal/Professional");
if (isset($_SERVER["HTTP_HOST"]) && !empty($_SERVER["HTTP_HOST"])) {
    define(
        "TMWCG_WALLET_DOMAIN",
        sanitize_text_field(wp_unslash($_SERVER["HTTP_HOST"]))
    );
} else {
    define("TMWCG_WALLET_DOMAIN", ""); // Fallback value
}
//define('TMWCG_WALLET_DOMAIN',$_SERVER['HTTP_HOST']);
//define('TMWCG_WALLET_DOMAIN','bhtyitwo.com');
//{"SUCCESS":"Key Activated.","ACCOUNT":"0CXqFA=="}
//{"SUCCESS":"Card Created\/Updated.","CARD":"3dGobQ=="}

/*
 *
 *  Register CSS
 *
 */
function tmwcg_register_core_css()
{
    wp_enqueue_style( "tmwcg-core", TMWCG_CORE_CSS . "tmwcg-core.css", null, time(), "all" );
}

/*
 *
 *  Register JS/Jquery Ready
 *
 */
function tmwcg_register_core_js()
{
    // Register Core Plugin JS
    wp_enqueue_script( "tmwcg-core", TMWCG_CORE_JS . "tmwcg-core.js", "jquery", time(), true );
}

function tmwcg_menu()
{
    $icon_url = TMWCG_CORE_IMG . "tmwcg-icon.png";
    add_menu_page("The Official Mobile Wallet Card", "Mobile Wallet Card",  "manage_options",  "pc-digital-card",  "tmwcg_digital_card_page", $icon_url);
}

// Set default values
// Callback function to display the page content
function tmwcg_digital_card_page()
{
    // Enqueue necessary scripts
    wp_enqueue_media();
    wp_enqueue_script("wp-color-picker");
    wp_enqueue_style("wp-color-picker");

    // Retrieve saved values
    $options = get_option("tmwcg_digital_card_options");

    // Set default values
    $defaults = [
        "name" => get_bloginfo("name"),
        "link" => get_bloginfo("url"),
        "phone" => "",
        "email" => "",
        "address" => "",
        "mon_hrs" => "",
        "tues_hrs" => "",
        "wen_hrs" => "",
        "thu_hrs" => "",
        "fri_hrs" => "",
        "sat_hrs" => "",
        "sun_hrs" => "",
        "details" => "",
        "logo" => "",
        "style" => "background",
        "background_color" => "",
        "style_file" => "",
        "logo_position" => "top-left",
        "font_color" => "#000000",
    ];

    // Merge defaults with saved options
    $options = wp_parse_args($options, $defaults);
    // Display the form
    ?>
<?php if (!isset($_SESSION["mw_cardID"])) {
    tmwcgCardCreate();
} ?>
<div class="wrap digital-card-wrap" style="width:51%; float:left;">
    <h1>Mobile Wallet Card Settings</h1>
    <form method="post" action="options.php">
        <?php settings_fields("tmwcg_digital_card_options"); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Name</th>
                <td>
                    <input type="text" name="tmwcg_digital_card_options[name]" value="<?php echo esc_attr( $options["name"]); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Link</th>
                <td>
                    <input type="text" name="tmwcg_digital_card_options[link]" value="<?php echo esc_url($options["link"]); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Phone</th>
                <td>
                    <input type="text" name="tmwcg_digital_card_options[phone]" value="<?php echo esc_attr( $options["phone"] ); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Email</th>
                <td>
                    <input type="text" name="tmwcg_digital_card_options[email]" value="<?php echo esc_attr( $options["email"] ); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Address</th>
                <td>
                    <textarea name="tmwcg_digital_card_options[address]"><?php echo esc_textarea( $options["address"] ); ?></textarea>
                </td>
            </tr>
            <tr valign="top" class="opening_hours_tr">
                <th scope="row">Opening Hours</th>
                <td>
					<label>Monday</label> <input type="text" name="tmwcg_digital_card_options[mon_hrs]" value="<?php echo esc_attr( $options["mon_hrs"] ); ?>" /><br/><br/>
						<label>Tuesday</label> <input type="text" name="tmwcg_digital_card_options[tues_hrs]" value="<?php echo esc_attr( $options["tues_hrs"] ); ?>" /><br/><br/>
						<label>Wednesday</label> <input type="text" name="tmwcg_digital_card_options[wen_hrs]" value="<?php echo esc_attr( $options["wen_hrs"] ); ?>" /><br/><br/>
						<label>Thursday</label> <input type="text" name="tmwcg_digital_card_options[thu_hrs]" value="<?php echo esc_attr( $options["thu_hrs"] ); ?>" /><br/><br/>
						<label>Friday</label> <input type="text" name="tmwcg_digital_card_options[fri_hrs]" value="<?php echo esc_attr( $options["fri_hrs"] ); ?>" /><br/><br/>
						<label>Saturday</label> <input type="text" name="tmwcg_digital_card_options[sat_hrs]" value="<?php echo esc_attr( $options["sat_hrs"] ); ?>" /><br/><br/>
						<label>Sunday</label> <input type="text" name="tmwcg_digital_card_options[sun_hrs]" value="<?php echo esc_attr( $options["sun_hrs"] ); ?>" /><br/><br/>
						
					</td>
            </tr>
            <tr valign="top">
                <th scope="row">More Details</th>
                <td>
					<textarea name="tmwcg_digital_card_options[details]"><?php echo esc_textarea($options["details"]); ?></textarea>
                </td>
            </tr>
			<tr valign="top">
                <th scope="row">Logo</th>
                <td>
                    <input type="text" name="tmwcg_digital_card_options[logo]" id="logo" value="<?php echo esc_attr($options["logo"]); ?>" />
                    <input type="button" id="upload_logo_button" class="button" value="Upload Image" />
                    <!-- <button class="remove-image-button dashicons-before dashicons-no" data-target="#logo" data-preview="#logo_preview"></button> -->
                     <?php $preview_logo = !empty($options["logo"]) ? $options["logo"] : TMWCG_CORE_IMG . "placeholder.png"; ?>
                    <div class="image-container">
                        <img src="<?php echo esc_attr($preview_logo); ?>" id="logo_preview" class="preview-image" style="max-width: 100px; max-height: 100px; margin-top: 10px; border:1px solid #ccc;" />
                        <?php if (!empty($options["logo"])): ?>
                        <span class="remove-image-button remove-icon dashicons-before dashicons-dismiss"  data-target="#logo" data-preview="#logo_preview"></span>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row">Card Style</th>
                <td>
                    <select name="tmwcg_digital_card_options[style]" id="card_style">
                        <option value="banner" <?php selected($options["style"],"banner"); ?>>Banner</option>
                        <option value="background" <?php selected($options["style"],"background"); ?>>Background</option>
                    </select>
					<br/>
					<input type="text" name="tmwcg_digital_card_options[style_file]" id="style_file" value="<?php echo esc_attr( $options["style_file"] ); ?>" />
                    <input type="button" id="upload_style_file_button" class="button" value="Upload Image" />
					<?php $preview_style_file = !empty($options["style_file"]) ? $options["style_file"] : TMWCG_CORE_IMG . "placeholder.png"; ?>
                    <img src="<?php echo esc_attr( $preview_style_file ); ?>" id="style_file_preview" style="max-width: 100px; max-height: 100px; margin-top: 10px; border:1px solid #ccc;">
                    <?php if (!empty($options["style_file"])): ?> <span class="remove-image-button remove-icon dashicons-before dashicons-dismiss"  data-target="#style_file" data-preview="#style_file_preview"></span> <?php endif; ?>
                    </td>
            </tr>

			<tr valign="top" id="background_color_row" style="display: <?php echo $options["style"] === "banner" ? "table-row" : "none"; ?>">
                <th scope="row">Background Color</th>
                <td>
                    <input type="text" name="tmwcg_digital_card_options[background_color]" value="<?php echo esc_attr( $options["background_color"]); ?>" class="color-field" />
                </td>
            </tr>
			
			<tr valign="top">
                <th scope="row">Font Color</th>
                <td><input type="text" name="tmwcg_digital_card_options[font_color]" value="<?php echo esc_attr( $options["font_color"] ); ?>" class="color-field" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Position Logo</th>
                <td>
                    <select name="tmwcg_digital_card_options[logo_position]" style="width:80%;"> 
                        <option value="top-left" <?php selected( $options["logo_position"], "top-left" ); ?>>Top Left</option>
                        <option value="top-right" <?php selected($options["logo_position"], "top-right" ); ?>>Top Right</option>
                        <option value="bottom-right" <?php selected( $options["logo_position"], "bottom-right"); ?>>Bottom Right</option>
                        <option value="bottom-left" <?php selected( $options["logo_position"], "bottom-left" ); ?>>Bottom Left</option>
                    </select>
					<img src="<?php echo esc_url( TMWCG_CORE_IMG . "tmwcg-icon.png"); ?>" id="style_file_preview" style="float:right;max-width: 100px; max-height: 100px; margin-top: 0px;">
					<br/>
					<br/>
                </td>
            </tr>
        </table>
		
        <?php submit_button("Update", "primary", "submit", false); ?>
	
    </form>
</div>
<?php if (isset($_SESSION["mw_cardID"])) {
    $disply_statistics = tmwcgCardStatistics();
    //echo "<pre>"; print_r($disply_statistics); echo "</pre>";
    if (!empty($disply_statistics)) { 
        if(isset($disply_statistics[0]["Total Card Prompts"]) && $disply_statistics[0]["Total Card Prompts"]){
            $t_c_p_value = $disply_statistics[0]["Total Card Prompts"];
        }else{
            $t_c_p_value = '0';
        }
        ?>
    <div class="wrap digital-card-wrap" style="width:45%; float:left;">
        <h3>Total Card Holder: <?php echo esc_html( $t_c_p_value ); ?></h3>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<?php 
 if (isset($_SERVER["HTTP_HOST"]) && !empty($_SERVER["HTTP_HOST"])) {
     // Unslash and sanitize the HTTP_HOST
     $http_host = sanitize_text_field(wp_unslash($_SERVER["HTTP_HOST"]));

     // Encode the sanitized domain
     $domain_64 = base64_encode($http_host);
     $t_time = time();
     // Construct the URL
     $custom_digital_cart_url = "https://admin.mobilewallet.cards/?a=" . $domain_64 . "&aa=" . $domain_64 . "&t=" . $t_time;
    } else {
        $custom_digital_cart_url = ""; // or some fallback value
        } ?>
        <p>Customize More, Send Messages To Your Customer's Phone And Upgrade<br/>Upgrade your plan <a class="custom_digital_cart_btn button button-primary" href="<?php echo esc_url( $custom_digital_cart_url ); ?>" target="_blank">Click Here</a></p>
    </div>
<?php }
} 
}

// Function to register settings
function tmwcg_dc_register_settings()
{
    register_setting("tmwcg_digital_card_options", "tmwcg_digital_card_options");

}

// Enqueue necessary scripts for options page
function tmwcg_dc_admin_scripts($hook)
{
    if ("toplevel_page_digital-card" === $hook) {
        wp_enqueue_media();
        wp_enqueue_script("wp-color-picker");
        wp_enqueue_style("wp-color-picker");
    }
    wp_enqueue_style(
        "tmwcg-admin-style",
        TMWCG_CORE_CSS . "tmwcg-admin-core.css",
        [],
        "1.0.0"
    ); // Add a version number here
    
    wp_enqueue_script('tmwcg-admin-script', TMWCG_CORE_JS . "tmwcg-admin-core.js", array('jquery'), '1.0.0', true);
    wp_localize_script('tmwcg-admin-script', 'tmwc', array(
        'tmwcg_plugin_url' => plugin_dir_url(__FILE__),
    ));
}

function tmwcgAccountCreate()
{
    // API Endpoint URL
    $endurl = "https://addthispass.com/api/card-activation/";

    // API Parameters
    $key = urlencode(TMWCG_WALLET_KEY);
    $referral_id = urlencode(TMWCG_WALLET_REFERRAL);
    $aff = urlencode(TMWCG_WALLET_AFF);
    $domain = urlencode(TMWCG_WALLET_DOMAIN);
    $classification = urlencode(TMWCG_WALLET_CLASSIFICATION);

    // Construct API URL
    $api_url =
        $endurl .
        "?key=$key&referral_id=$referral_id&wordpress=true&aff=$aff&domain=$domain&the_classification=$classification";

    // Make HTTP POST request using WordPress HTTP API
    $response = wp_remote_post($api_url, [
        "method" => "POST",
        "timeout" => 45,
        "redirection" => 5,
        "httpversion" => "1.0",
        "blocking" => true,
        "headers" => [],
        "body" => [],
        "cookies" => [],
    ]);

    // Check for errors
    if (is_wp_error($response)) {
        $error_message = esc_html($response->get_error_message());
        echo esc_html("HTTP request failed: $error_message");
    } else {
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);

        if (isset($data["SUCCESS"])) {
            update_option("tmwcg_wallet_account_data", $data["ACCOUNT"]);
            return true;
        } else {
            echo "<pre>" . esc_html(print_r($data, true)) . "</pre>"; // Safely output data
            return true;
        }
    }
}

function tmwcg_session_set()
{
    if (!session_id()) {
        session_start();
    }
}

function tmwcgCardCreate()
{

    if (!get_option("tmwcg_wallet_account_data")) {
        tmwcgAccountCreate();
    }

    // API Endpoint URL
    $endurl = "https://addthispass.com/api/card-management/";

    // API Parameters
    $key = urlencode(TMWCG_WALLET_KEY);
    $referral_id = urlencode(TMWCG_WALLET_REFERRAL);
    $aff = urlencode(TMWCG_WALLET_AFF);
    $domain = urlencode(TMWCG_WALLET_DOMAIN);
    $classification = urlencode(TMWCG_WALLET_CLASSIFICATION);
    $account_key = urlencode(get_option("tmwcg_wallet_account_data"));

    $options = get_option("tmwcg_digital_card_options");

    // Set default values
    $defaults = [
        "name" => get_bloginfo("name"),
        "link" => get_bloginfo("url"),
        "phone" => "",
        "email" => "",
        "address" => "",
        "mon_hrs" => "",
        "tues_hrs" => "",
        "wen_hrs" => "",
        "thu_hrs" => "",
        "fri_hrs" => "",
        "sat_hrs" => "",
        "sun_hrs" => "",
        "details" => "",
        "logo" => "",
        "style" => "background",
        "background_color" => "",
        "style_file" => "",
        "logo_position" => "top-left",
        "font_color" => "#000000",
    ];

    // Merge defaults with saved options
    $options = wp_parse_args($options, $defaults);

    $name = urlencode($options["name"]);
    $logo_image = urlencode($options["logo"]);
    $phone = urlencode($options["phone"]);
    $email = urlencode($options["email"]);
    $address = urlencode($options["address"]);
    $website_name = urlencode(get_bloginfo("name"));
    $website = urlencode(get_bloginfo("url"));
    $monday = urlencode($options["mon_hrs"]);
    $tuesday = urlencode($options["tues_hrs"]);
    $wednesday = urlencode($options["wen_hrs"]);
    $thursday = urlencode($options["thu_hrs"]);
    $friday = urlencode($options["fri_hrs"]);
    $saturday = urlencode($options["sat_hrs"]);
    $sunday = urlencode($options["sun_hrs"]);

    $style_file = urlencode($options["style_file"]);
    $background_color = urlencode($options["background_color"]);

    $more = urlencode($options["details"]);

    if ($options["details"] == "banner") {
        $api_url =
            $endurl .
            "?key=$key&referral_id=$referral_id&account_key=$account_key&name=$name&logo_image=$logo_image&phone=$phone&email=$email&address=$address&website_name=$website_name&website=$website&monday=$monday&tuesday=$tuesday&wednesday=$wednesday&thursday=$thursday&friday=$friday&saturday=$saturday&sunday=$sunday&more=$more&banner_image=$style_file&background=$background_color";
    } else {
        $api_url =
            $endurl .
            "?key=$key&referral_id=$referral_id&account_key=$account_key&name=$name&logo_image=$logo_image&phone=$phone&email=$email&address=$address&website_name=$website_name&website=$website&monday=$monday&tuesday=$tuesday&wednesday=$wednesday&thursday=$thursday&friday=$friday&saturday=$saturday&sunday=$sunday&more=$more&bg_image=$style_file";
    }

    // Make HTTP POST request using WordPress HTTP API
    $response = wp_remote_post($api_url, [
        "method" => "POST",
        "timeout" => 45,
        "redirection" => 5,
        "httpversion" => "1.0",
        "blocking" => true,
        "headers" => [],
        "body" => [],
        "cookies" => [],
    ]);

    // Check for errors
    if (is_wp_error($response)) {
        $error_message = esc_html($response->get_error_message());
        echo esc_html("HTTP request failed: $error_message");
    } else {
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);

        if (isset($data["SUCCESS"])) {
            $_SESSION["mw_cardID"] = $data["CARD"];
            return $data["CARD"];
        } else {
            // You might want to handle the error case here, for example:
            // echo '<pre>' . esc_html(print_r($data, true)) . '</pre>'; // Uncomment to safely output data
        }
    }
}

function tmwcgCardMainSettings()
{
    // API Endpoint URL
    $endurl = "https://addthispass.com/api/card-main-settings/";

    // API Parameters
    $key = urlencode(TMWCG_WALLET_KEY);
    $referral_id = urlencode(TMWCG_WALLET_REFERRAL);
    $aff = urlencode(TMWCG_WALLET_AFF);
    $domain = urlencode(TMWCG_WALLET_DOMAIN);
    $classification = urlencode(TMWCG_WALLET_CLASSIFICATION);
    $account_key = urlencode(get_option("tmwcg_wallet_account_data"));
    //$card_id = urlencode($_SESSION['mw_cardID']);
    if (isset($_SESSION["mw_cardID"]) && !empty($_SESSION["mw_cardID"])) {
        // Sanitize the session variable
        $card_id = sanitize_text_field(wp_unslash($_SESSION["mw_cardID"]));

        // URL encode the sanitized card ID
        $card_id = urlencode($card_id);
    } else {
        // Handle the case where mw_cardID is not set or is empty
        $card_id = ""; // or some fallback value
    }
    $timezone = urlencode(get_option("gmt_offset"));

    // Construct API URL
    $api_url =
        $endurl .
        "?key=$key&referral_id=$referral_id&account_key=$account_key&card_id=$card_id&geo_distance=&timezone=$timezone&mp_status=yes&mp_description=&mp_keywords=";

    // Make HTTP POST request using WordPress HTTP API
    $response = wp_remote_post($api_url, [
        "method" => "POST",
        "timeout" => 45,
        "redirection" => 5,
        "httpversion" => "1.0",
        "blocking" => true,
        "headers" => [],
        "body" => [],
        "cookies" => [],
    ]);

    // Check for errors
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo esc_html("HTTP request failed: $error_message");
    } else {
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);

        if (isset($data["SUCCESS"])) {
            // Success handling goes here if needed
        } else {
            // Handle unsuccessful response
        }
    }

    return true;
}

function tmwcgCardFrontSettings()
{
    // API Endpoint URL
    $endurl = "https://addthispass.com/api/card-front-settings/";

    // API Parameters
    $key = urlencode(TMWCG_WALLET_KEY);
    $referral_id = urlencode(TMWCG_WALLET_REFERRAL);
    $aff = urlencode(TMWCG_WALLET_AFF);
    $domain = urlencode(TMWCG_WALLET_DOMAIN);
    $classification = urlencode(TMWCG_WALLET_CLASSIFICATION);
    $account_key = urlencode(get_option("tmwcg_wallet_account_data"));
    //$card_id = urlencode($_SESSION['mw_cardID']);
    if (isset($_SESSION["mw_cardID"]) && !empty($_SESSION["mw_cardID"])) {
        // Sanitize the session variable
        $card_id = sanitize_text_field(wp_unslash($_SESSION["mw_cardID"]));

        // URL encode the sanitized card ID
        $card_id = urlencode($card_id);
    } else {
        // Handle the case where mw_cardID is not set or is empty
        $card_id = ""; // or some fallback value
    }
    $welcome_text = urlencode("Thanks for adding our digital Card!");
    $welcome_text_1 = urlencode("Thanks For Adding");
    $suspended_by_default = urlencode("no");
    $push_show = urlencode("intro");
    $qr_format = urlencode("PKBarcodeFormatQR");

    // Construct API URL
    $api_url =
        $endurl .
        "?key=$key&referral_id=$referral_id&account_key=$account_key&card_id=$card_id&welcome_text=$welcome_text&push_welcome_1=$welcome_text_1&suspended_by_default=$suspended_by_default&push_show=$push_show&qr_format=$qr_format";

    // Make HTTP POST request using WordPress HTTP API
    $response = wp_remote_post($api_url, [
        "method" => "POST",
        "timeout" => 45,
        "redirection" => 5,
        "httpversion" => "1.0",
        "blocking" => true,
        "headers" => [],
        "body" => [],
        "cookies" => [],
    ]);

    // Check for errors
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo esc_html("HTTP request failed: $error_message");
    } else {
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);

        if (isset($data["SUCCESS"])) {
            // Success handling goes here if needed
        } else {
            // Handle unsuccessful response
        }
    }

    return true;
}

function tmwcgCardBacksideSettings()
{
    // API Endpoint URL
    $endurl = "https://addthispass.com/api/card-back-settings/";

    // API Parameters
    $key = urlencode(TMWCG_WALLET_KEY);
    $referral_id = urlencode(TMWCG_WALLET_REFERRAL);
    $aff = urlencode(TMWCG_WALLET_AFF);
    $domain = urlencode(TMWCG_WALLET_DOMAIN);
    $classification = urlencode(TMWCG_WALLET_CLASSIFICATION);
    $account_key = urlencode(get_option("tmwcg_wallet_account_data"));
    //$card_id = urlencode($_SESSION['mw_cardID']);
    if (isset($_SESSION["mw_cardID"]) && !empty($_SESSION["mw_cardID"])) {
        // Sanitize the session variable
        $card_id = sanitize_text_field(wp_unslash($_SESSION["mw_cardID"]));

        // URL encode the sanitized card ID
        $card_id = urlencode($card_id);
    } else {
        // Handle the case where mw_cardID is not set or is empty
        $card_id = ""; // or set an appropriate fallback value
    }

    $history = 5;
    $registration_header = "";
    $registration_name = "";
    $registration_email = "";
    $registration_phone = "";
    $registration_address = "";
    $registration_other = "";
    $registration_other_name = "";
    $other_unique = "yes";
    $other_onetime = "no";
    $exclusive = "";
    $sharing = true;

    // Construct API URL
    $api_url =
        $endurl .
        "?key=$key&referral_id=$referral_id&account_key=$account_key&card_id=$card_id&history=$history&registration_header=$registration_header&registration_name=$registration_name&registration_email=$registration_email&registration_phone=$registration_phone&registration_address=$registration_address&registration_other=$registration_other&registration_other_name=$registration_other_name&other_unique=$other_unique&other_onetime=$other_onetime&exclusive=$exclusive&sharing=$sharing";

    // Make HTTP POST request using WordPress HTTP API
    $response = wp_remote_post($api_url, [
        "method" => "POST",
        "timeout" => 45,
        "redirection" => 5,
        "httpversion" => "1.0",
        "blocking" => true,
        "headers" => [],
        "body" => [],
        "cookies" => [],
    ]);

    // Check for errors
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo esc_html("HTTP request failed: $error_message");
    } else {
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);

        if (isset($data["SUCCESS"])) {
            // Success handling goes here if needed
        } else {
            // Handle unsuccessful response
        }
    }

    return true;
}

function tmwcgCardStatistics()
{
    // API Endpoint URL
    $endurl = "https://addthispass.com/api/card-statistics/";

    // API Parameters
    $key = TMWCG_WALLET_KEY;
    $referral_id = TMWCG_WALLET_REFERRAL;
    $aff = TMWCG_WALLET_AFF;
    $domain = TMWCG_WALLET_DOMAIN;
    $classification = TMWCG_WALLET_CLASSIFICATION;
    $account_key = get_option("tmwcg_wallet_account_data");
    //$card_id = $_SESSION['mw_cardID'];
    if (isset($_SESSION["mw_cardID"]) && !empty($_SESSION["mw_cardID"])) {
        // Retrieve and sanitize the session variable
        $card_id = sanitize_text_field(wp_unslash($_SESSION["mw_cardID"]));
    } else {
        // Handle the case where mw_cardID is not set or is empty
        $card_id = ""; // or set an appropriate fallback value
    }

    // Construct API URL
    $api_url =
        $endurl .
        "?key=$key&referral_id=$referral_id&account_key=$account_key&card_id=$card_id";

    // Make HTTP POST request using WordPress HTTP API
    $response = wp_remote_get($api_url);

    // Check for errors
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo esc_html("HTTP request failed: $error_message");
        return "";
    } else {
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);

        if ($data) {
            return $data;
        } else {
            return "";
        }
    }
}

function tmwcg_frontend_dc_widget_show()
{
    $options = get_option("tmwcg_digital_card_options");
    //$logo_url = isset($options['logo']) ? $options['logo'] : '';
    $logo_url = TMWCG_CORE_IMG . "tmwcg-icon.png";
    //$domain_64 = base64_encode($_SERVER['HTTP_HOST']);
    if (isset($_SERVER["HTTP_HOST"]) && !empty($_SERVER["HTTP_HOST"])) {
        // Unslash and sanitize the HTTP_HOST
        $http_host = sanitize_text_field(wp_unslash($_SERVER["HTTP_HOST"]));

        // Base64 encode the sanitized domain
        $domain_64 = base64_encode($http_host);
    } else {
        // Handle the case where HTTP_HOST is not set or is empty
        $domain_64 = ""; // or some fallback value
    }
    $card_id = tmwcgDCcardID();
    $link = "https://addthiscard.com/?id=" . $card_id;
    if (!empty($logo_url)) {
        $logo_position = isset($options["logo_position"])
            ? $options["logo_position"]
            : "top-left";
        // Output the logo HTML based on the selected position
        switch ($logo_position) {
            case "top-right":
                echo '<div class="tmwcg-logo-top-right digital-card-logo"><a id="dc_link" target="_blank" href="' .
                    esc_url($link) .
                    '"><img src="' .
                    esc_url($logo_url) .
                    '" alt="Logo"></a></div>';
                break;
            case "bottom-right":
                echo '<div class="tmwcg-logo-bottom-right digital-card-logo"><a id="dc_link" target="_blank" href="' .
                    esc_url($link) .
                    '"><img src="' .
                    esc_url($logo_url) .
                    '" alt="Logo"></a></div>';
                break;
            case "bottom-left":
                echo '<div class="tmwcg-logo-bottom-left digital-card-logo"><a id="dc_link" target="_blank" href="' .
                    esc_url($link) .
                    '"><img src="' .
                    esc_url($logo_url) .
                    '" alt="Logo"></a></div>';
                break;
            default:
                // top-left
                echo '<div class="tmwcg-logo-top-left digital-card-logo"><a id="dc_link" target="_blank" href="' .
                    esc_url($link) .
                    '"><img src="' .
                    esc_url($logo_url) .
                    '" alt="Logo"></a></div>';
                break;
        }
    }

    wp_enqueue_script('tmwcg-widgetinline-script', '', [], '1.0.0', true); // Empty handle for inline script

    // Prepare your inline script
    $tmwcg_widgetinline_script = "
        window.onload = function() {
            var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            var link = document.getElementById('dc_link');
            if (isMobile) {
                link.setAttribute('target', '_blank');
            } else {
                link.removeAttribute('target'); 
                link.onclick = function(event) {
                    event.preventDefault(); 
                    window.open('" . esc_url($link) . "', 'popup', 'width=1000,height=900'); 
                };
            }
        };
    ";
    wp_add_inline_script('tmwcg-widgetinline-script', $tmwcg_widgetinline_script);
}

function tmwcgDCcardID()
{
    // API Endpoint URL
    $endurl = "https://addthispass.com/api/card-management/";

    // API Parameters
    $key = TMWCG_WALLET_KEY;
    $referral_id = TMWCG_WALLET_REFERRAL;
    $aff = TMWCG_WALLET_AFF;
    $domain = TMWCG_WALLET_DOMAIN;
    $classification = TMWCG_WALLET_CLASSIFICATION;
    $account_key = get_option("tmwcg_wallet_account_data");

    $options = get_option("tmwcg_digital_card_options");

    // Set default values
    $defaults = [
        "name" => get_bloginfo("name"),
        "link" => get_bloginfo("url"),
        "phone" => "",
        "email" => "",
        "address" => "",
        "mon_hrs" => "",
        "tues_hrs" => "",
        "wen_hrs" => "",
        "thu_hrs" => "",
        "fri_hrs" => "",
        "sat_hrs" => "",
        "sun_hrs" => "",
        "details" => "",
        "logo" => "",
        "style" => "background",
        "background_color" => "",
        "style_file" => "",
        "logo_position" => "top-left",
        "font_color" => "#000000",
    ];

    // Merge defaults with saved options
    $options = wp_parse_args($options, $defaults);

    $name = urlencode($options["name"]);
    $logo_image = urlencode($options["logo"]);
    $phone = urlencode($options["phone"]);
    $email = urlencode($options["email"]);
    $address = urlencode($options["address"]);
    $website_name = urlencode(get_bloginfo("name"));
    $website = urlencode(get_bloginfo("url"));
    $monday = urlencode($options["mon_hrs"]);
    $tuesday = urlencode($options["tues_hrs"]);
    $wednesday = urlencode($options["wen_hrs"]);
    $thursday = urlencode($options["thu_hrs"]);
    $friday = urlencode($options["fri_hrs"]);
    $saturday = urlencode($options["sat_hrs"]);
    $sunday = urlencode($options["sun_hrs"]);

    $style_file = urlencode($options["style_file"]);
    $background_color = urlencode($options["background_color"]);

    $more = urlencode($options["details"]);

    if ($options["details"] == "banner") {
        $api_url =
            $endurl .
            "?key=$key&referral_id=$referral_id&account_key=$account_key&name=$name&logo_image=$logo_image&phone=$phone&email=$email&address=$address&website_name=$website_name&website=$website&monday=$monday&tuesday=$tuesday&wednesday=$wednesday&thursday=$thursday&friday=$friday&saturday=$saturday&sunday=$sunday&more=$more&banner_image=$style_file&background=$background_color";
    } else {
        $api_url =
            $endurl .
            "?key=$key&referral_id=$referral_id&account_key=$account_key&name=$name&logo_image=$logo_image&phone=$phone&email=$email&address=$address&website_name=$website_name&website=$website&monday=$monday&tuesday=$tuesday&wednesday=$wednesday&thursday=$thursday&friday=$friday&saturday=$saturday&sunday=$sunday&more=$more&bg_image=$style_file";
    }

    // Make HTTP POST request using WordPress HTTP API
    $response = wp_remote_get($api_url);

    // Check for errors
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        echo esc_html("HTTP request failed: $error_message");
        return "";
    } else {
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);

        if (isset($data["SUCCESS"])) {
            return $data["CARD"];
        }
    }
}