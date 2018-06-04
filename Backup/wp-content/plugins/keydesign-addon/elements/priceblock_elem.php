<?php

if (!class_exists('KD_ELEM_PRICE_BLOCK')) {

    class KD_ELEM_PRICE_BLOCK extends KEYDESIGN_ADDON_CLASS {

        function __construct() {
            add_action('init', array($this, 'kd_priceblock_init'));
            add_shortcode('tek_priceblock', array($this, 'kd_priceblock_shrt'));
        }

        // Element configuration in admin

        function kd_priceblock_init() {
            if (function_exists('vc_map')) {
                vc_map(array(
                    "name" => esc_html__("Price block", "keydesign"),
                    "description" => esc_html__("Price block with thumb image.", "keydesign"),
                    "base" => "tek_priceblock",
                    "class" => "",
                    "icon" => plugins_url('assets/element_icons/price-block.png', dirname(__FILE__)),
                    "category" => esc_html__("KeyDesign Elements", "keydesign"),
                    "params" => array(

                         array(
                             "type" => "textfield",
                             "class" => "",
                             "heading" => esc_html__("Block title", "keydesign"),
                             "param_name" => "pb_title",
                             "admin_label" => true,
                             "value" => "",
		                         "description" => esc_html__("Price block title.", "keydesign"),
                             ),
                          array(
                              "type" => "textarea",
                              "class" => "",
                              "heading" => esc_html__("Block description", "keydesign"),
                              "param_name" => "pb_description",
                              "value" => "",
                              "description" => esc_html__("Price block description.", "keydesign")
                              ),
                          array(
                              "type" => "attach_image",
                              "class" => "",
                              "heading" => esc_html__("Block image", "keydesign"),
                              "param_name" => "pb_image",
                              "value" => "",
                              "description" => esc_html__("Upload price block image.", "keydesign"),
                              ),
                          array(
                              "type" => "textfield",
                              "class" => "",
                              "heading" => esc_html__("Price", "keydesign"),
                              "param_name" => "pb_price",
                              "admin_label" => true,
                              "value" => "",
 		                         "description" => esc_html__("Enter product price.", "keydesign"),
                              ),
                          array(
                              "type" => "dropdown",
                              "class" => "",
                              "heading" => esc_html__("Price currency", "keydesign"),
                              "param_name" => "pb_currency",
                              "value" => array(
                                  "Dollar" => "currency-dollar",
                                  "Euro" => "currency-euro",
                                  "Pound" => "currency-pound"
                              ),
                              "save_always" => true,
                              "description" => esc_html__("Select price currency.", "keydesign")
                          ),
                          array(
                              "type" => "textfield",
                              "class" => "",
                              "heading" => esc_html__("Other currency", "keydesign"),
                              "param_name" => "pb_other_currency",
                              "value" => "",
                              "description" => esc_html__("Pricing block custom currency.", "keydesign")
                          ),
                          array(
                              "type" => "dropdown",
                              "class" => "",
                              "heading" => esc_html__("Currency symbol position", "keydesign"),
                              "param_name" => "pb_currency_position",
                              "value" => array(
                                  "Left" => "currency-position-left",
                                  "Right" => "currency-position-right"
                              ),
                              "save_always" => true,
                              "description" => esc_html__("Select price block currency symbol position.", "keydesign")
                          ),
                          array(
                              "type" => "colorpicker",
                              "class" => "",
                              "heading" => esc_html__("Box background color", "keydesign"),
                              "param_name" => "pb_background_color",
                              "value" => "",
                              "description" => esc_html__("Select box background color. If none selected, the default theme color will be used.", "keydesign"),
                          ),
                          array(
                              "type" => "textfield",
                              "class" => "",
                              "heading" => esc_html__("Extra class name", "keydesign"),
                              "param_name" => "pb_extra_class",
                              "value" => "",
                              "description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "keydesign")
                          ),
                    )
                ));
            }
        }



		// Render the element on front-end

        public function kd_priceblock_shrt($atts, $content = null)
        {

            // Include required JS and CSS files
	          wp_enqueue_script('kd_jquery_appear');

            // Declare empty vars
            $output = $pb_img_array = $product_image = $currency_symbol = '';

            extract(shortcode_atts(array(
              'pb_title'                    => '',
              'pb_description'              => '',
              'pb_image'                    => '',
              'pb_price'                    => '',
              'pb_currency'                 => '',
              'pb_other_currency'           => '',
              'pb_currency_position'        => '',
              'pb_background_color'         => '',
              'pb_extra_class'              => '',
            ), $atts));

            switch($pb_currency){
                    case 'currency-dollar':
                        $currency_symbol = "&#36;";
                    break;

                    case 'currency-euro':
                        $currency_symbol = "&#128;";
                    break;

                    case 'currency-pound':
                        $currency_symbol = "&#163;";
                    break;

                    default:
                }

            if (!empty($pb_other_currency)) {
                $currency_symbol = $pb_other_currency;
            }

            if(!empty($pb_image)){
                $pb_img_array = wpb_getImageBySize ( $params = array( 'post_id' => NULL, 'attach_id' => $pb_image, 'thumb_size' => 'full', 'class' => "" ) );
                $product_image = $pb_img_array['thumbnail'];
            }


            $output = '<div class="kd-price-block '.$pb_extra_class.'" '.(!empty($pb_background_color) ? 'style="background-color: '.$pb_background_color.';"' : '').'>';
                if ($pb_image != '') {
                    $output .= '<div class="pb-image-wrap">'.$product_image.'</div>';
                }
                $output .= '<div class="pb-content-wrap">
                    <h4>'.$pb_title.'</h4>';
                    if ($pb_currency_position == "currency-position-left") {
    				          $output .= '<div class="pb-pricing-wrap"><span class="pb-price"><span class="pb-currency">'.$currency_symbol.'</span>'.$pb_price.'</span></div>';
                    } elseif ($pb_currency_position == "currency-position-right") {
                      $output .= '<div class="pb-pricing-wrap"><span class="pb-price">'.$pb_price.'<span class="pb-currency">'.$currency_symbol.'</span></span></div>';
                    }
                    $output .= '<div class="pb-desc-wrap">'.wpb_js_remove_wpautop($pb_description, true).'</div>';
                $output .= '</div>
            </div>';

            return $output;

        }
    }
}

if (class_exists('KD_ELEM_PRICE_BLOCK')) {
    $KD_ELEM_PRICE_BLOCK = new KD_ELEM_PRICE_BLOCK;
}

?>
