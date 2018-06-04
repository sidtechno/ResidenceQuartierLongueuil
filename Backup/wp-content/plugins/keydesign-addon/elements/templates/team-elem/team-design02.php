<?php
/*
* Template: Team Members Design 1
*/

if(!function_exists('kd_team_set_design02')) {
  function kd_team_set_design02($atts,$content = null){
  	extract(shortcode_atts(array(
      'title' => '',
      'title_color' => '',
      'position' => '',
      'position_color' => '',
      'description' => '',
      'description_color' => '',
      'phone' => '',
      'email' => '',
      'team_link' => '',
      'team_link_url' => '',
      'image' => '',
      'team_bg_color' => '',
      'facebook_url' => '',
      'twitter_url' => '',
      'google_url' => '',
      'linkedin_url' => '',
      'social_color' => '',
      'css_animation' => '',
      'elem_animation_delay' => '',
      'team_extra_class' => '',
  	),$atts));

    $link_target_fb = $link_title_fb = $link_target_tw = $link_title_tw = $link_target_go = $link_title_go = $link_target_li = $link_title_li = $href_facebook = $href_twitter = $href_google = $href_linkedin = $animation_delay = '';

    $link_target_fb = $link_target_go = $link_target_li = $link_target_tw = '_blank';

    $href_team_link = $link_target_team = $link_title_team = '';

    $image  = wpb_getImageBySize($params = array(
        'post_id' => NULL,
        'attach_id' => $image,
        'thumb_size' => 'full',
        'class' => ""
    ));

    $href_team_link = vc_build_link($team_link_url);
    if($href_team_link['url'] !== '') {
      $link_target_team = (isset($href_team_link['target']) && ($href_team_link['target'] != '')) ? 'target="'.$href_team_link['target'].'"' : '';
      $link_title_team = (isset($href_team_link['title'])) ? 'title="'.$href_team_link['title'].'"' : '';
    }

    $href_facebook = vc_build_link($facebook_url);
    if($href_facebook['url'] !== '') {
      $link_target_fb = (isset($href_facebook['target'])) ? 'target="'.$href_facebook['target'].'"' : '_blank';
      $link_title_fb = (isset($href_facebook['title'])) ? 'title="'.$href_facebook['title'].'"' : '';
    }

    $href_twitter = vc_build_link($twitter_url);
    if($href_twitter['url'] !== '') {
      $link_target_tw = (isset($href_twitter['target'])) ? 'target="'.$href_twitter['target'].'"' : '_blank';
      $link_title_tw = (isset($href_twitter['title'])) ? 'title="'.$href_twitter['title'].'"' : '';
    }

    $href_google = vc_build_link($google_url);
    if($href_google['url'] !== '') {
      $link_target_go = (isset($href_google['target'])) ? 'target="'.$href_google['target'].'"' : '_blank';
      $link_title_go = (isset($href_google['title'])) ? 'title="'.$href_google['title'].'"' : '';
    }

    $href_linkedin = vc_build_link($linkedin_url);
    if($href_linkedin['url'] !== '') {
      $link_target_li = (isset($href_linkedin['target'])) ? 'target="'.$href_linkedin['target'].'"' : '_blank';
      $link_title_li = (isset($href_linkedin['title'])) ? 'title="'.$href_linkedin['title'].'"' : '';
    }

    //CSS Animation
    if ($css_animation == "no_animation") {
        $css_animation = "";
    }

    // Animation delay
    if ($elem_animation_delay) {
        $animation_delay = 'data-animation-delay='.$elem_animation_delay;
    }

    $output = '<div class="team-member design-two '.$css_animation.' '.$team_extra_class.'" '.$animation_delay.'>
                    <div class="team-content">
                        <div class="team-image-overlay"></div>
                        <div class="team-image">'.$image['thumbnail'].'</div>
                        <div class="team-content-text" '.(!empty($team_bg_color) ? 'style="background-color: '.$team_bg_color.';"' : '').'>
                        <div class="team-content-text-inner">
                        <h5 '.(!empty($title_color) ? 'style="color: '.$title_color.';"' : '').'>'.$title.'</h5>
                        <span class="team-subtitle" '.(!empty($position_color) ? 'style="color: '.$position_color.';"' : '').'>'.$position.'</span>
                        <p '.(!empty($description_color) ? 'style="color: '.$description_color.';"' : '').'>'.$description.'</p>
                        </div>';
                        if ($team_link == "link_enable") {
                            if(isset($team_link_url) && $team_link_url !== '' && $href_team_link['url'] !== '') {
                                $output .= '<div class="team-link"><a href="'.$href_team_link['url'].'"'.$link_target_team.''.$link_title_team.'>'.$href_team_link['title'].'</a></div>';
                            }
                        }
                        $output .= '<div class="team-socials">';
                            if(isset($facebook_url) && $facebook_url !== '' && $href_facebook['url'] !== '') {
                              $output .='<a href="'.$href_facebook['url'].'" '.$link_target_fb.' '.$link_title_fb.'><span class="fa fa-facebook" '.(!empty($social_color) ? 'style="color: '.$social_color.';"' : '').'></span></a>';
                            }
                            if(isset($twitter_url) && $twitter_url !== '' && $href_twitter['url'] !== '') {
                              $output .='<a href="'.$href_twitter['url'].'" '.$link_target_tw.' '.$link_title_tw.'><span class="fa fa-twitter" '.(!empty($social_color) ? 'style="color: '.$social_color.';"' : '').'></span></a>';
                            }
                            if(isset($google_url) && $google_url !== '' && $href_google['url'] !== '') {
                              $output .='<a href="'.$href_google['url'].'" '.$link_target_go.' '.$link_title_go.'><span class="fa fa-google-plus" '.(!empty($social_color) ? 'style="color: '.$social_color.';"' : '').'></span></a>';
                            }
                            if(isset($linkedin_url) && $linkedin_url !== '' && $href_linkedin['url'] !== '') {
                              $output .='<a href="'.$href_linkedin['url'].'" '.$link_target_li.' '.$link_title_li.'><span class="fa fa-linkedin" '.(!empty($social_color) ? 'style="color: '.$social_color.';"' : '').'></span></a>';
                            }
                        $output .='</div>
                        <div class="team-contact">';
                            if ($phone !== '') {
                                $output .='<div class="phone-wrapper"><span class="iconsmind-Telephone"></span><span class="team-phone">'.$phone.'</span></div>';
                            }
                            if ($email !== '') {
                                $output .='<div class="email-wrapper"><span class="iconsmind-Mail"></span><span class="team-email">'.$email.'</span></div>';
                            }
                        $output .='</div>
                    </div>
                    </div>
                </div>';
    return $output;
  }
}
