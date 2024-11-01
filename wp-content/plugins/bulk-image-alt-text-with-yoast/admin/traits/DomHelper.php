<?php
namespace Pagup\Bialty\Traits;

use Pagup\Bialty\Core\Option;

trait DomHelper {

    public function setEmpty($option, $node, $img_url)
    {
        if ( Option::check($option) ) 
        {

            switch ( Option::get($option) ) 
            {
                case Option::get($option) == 'alt_empty_fkw':
                    $node->setAttribute("alt", $this->focus_keyword() . $this->site_title());
                    break;

                case Option::get($option) == 'alt_empty_title':
                    $node->setAttribute("alt", $this->post_title() . $this->site_title());
                    break;

                case Option::get($option) == 'alt_empty_imagename':
                    $node->setAttribute("alt", $this->image_name($img_url) . $this->site_title());
                    break;

                case Option::get($option) == 'alt_empty_both':
                    $node->setAttribute("alt", $this->focus_keyword() . ', ' . $this->post_title() . $this->site_title());
                    break;
            }

        }

    }
    
    public function setNotEmpty($option, $node, $img_url)
    {
        if ( Option::check($option) ) 
        {

            switch ( Option::get($option) ) 
            {
                case Option::get($option) == 'alt_not_empty_fkw':
                    $node->setAttribute("alt", $this->focus_keyword() . $this->site_title());
                    break;

                case Option::get($option) == 'alt_not_empty_title':
                    $node->setAttribute("alt", $this->post_title() . $this->site_title());
                    break;

                case Option::get($option) == 'alt_not_empty_imagename':
                    $node->setAttribute("alt", $this->image_name($img_url) . $this->site_title());
                    break;

                case Option::get($option) == 'alt_not_empty_both':
                    $node->setAttribute("alt", $this->focus_keyword() . ', ' . $this->post_title() . $this->site_title());
                    break;
            }

        }

    }

    public function setEmptyWoo($option, $node, $img_url)
    {
        if ( Option::check($option) ) 
        {

            switch ( Option::get($option) ) 
            {
                case Option::get($option) == 'woo_alt_empty_fkw':
                    $node->setAttribute("alt", $this->focus_keyword() . $this->site_title());
                    break;

                case Option::get($option) == 'woo_alt_empty_title':
                    $node->setAttribute("alt", $this->post_title() . $this->site_title());
                    break;

                case Option::get($option) == 'woo_alt_empty_imagename':
                    $node->setAttribute("alt", $this->image_name($img_url) . $this->site_title());
                    break;

                case Option::get($option) == 'woo_alt_empty_both':
                    $node->setAttribute("alt", $this->focus_keyword() . ', ' . $this->post_title() . $this->site_title());
                    break;
            }

        }

    }

    public function setNotEmptyWoo($option, $node, $img_url)
    {
        if ( Option::check($option) ) 
        {

            switch ( Option::get($option) ) 
            {
                case Option::get($option) == 'woo_alt_not_empty_fkw':
                    $node->setAttribute("alt", $this->focus_keyword() . $this->site_title());
                    break;

                case Option::get($option) == 'woo_alt_not_empty_title':
                    $node->setAttribute("alt", $this->post_title() . $this->site_title());
                    break;

                case Option::get($option) == 'woo_alt_not_empty_imagename':
                    $node->setAttribute("alt", $this->image_name($img_url) . $this->site_title());
                    break;

                case Option::get($option) == 'woo_alt_not_empty_both':
                    $node->setAttribute("alt", $this->focus_keyword() . ', ' . $this->post_title() . $this->site_title());
                    break;
            }

        }

    }

    public function focus_keyword()
    {
        global $post;

        $focus_keyword = "";
        
        if ( class_exists('WPSEO_Meta') ) {

            // define focus keyword for Yoast SEO
            $focus_keyword = \WPSEO_Meta::get_value('focuskw', $post->ID);

        }
        
        elseif ( class_exists('RankMath') ) {
    
            // define focus keyword for Rank Math
            $focus_keyword = get_post_meta( $post->ID, 'rank_math_focus_keyword', true );

        }

        return $focus_keyword;
    }

    public function post_title()
    {
        global $post;
        return get_the_title( $post->ID );
    }

    public function image_name($url)
    {
        $path = pathinfo($url);

        // Remove the size part from the filename if it's a thumbnail
        $filename = preg_replace('/-\d+x\d+$/', '', $path['filename']);

        return $this->fileName($filename);
    }

    public function site_title()
    {
        $site_title = "";
        
        if ( Option::check('add_site_title') ) {
            $site_title = ', ' . get_bloginfo( 'name' );
        }

        return $site_title;
        
    }

    public function fileName($string)
    {
        $string = preg_replace("/[\s-]+/", " ", $string); // clean dashes/whitespaces
        $string = preg_replace("/[_]/", " ", $string); // convert whitespaces/underscore to space
        $string = ucwords($string); // convert first letter of each word to capital
        return $string;
    }

    /**
     * Get the list of blacklist URL's string from Options, converts it to an array, and use the array map function to convert each URL to ID.
     * 
     * @return array
    */
    public function blacklist(): array
    {
        $blacklist = Option::check('blacklist') ? Option::get('blacklist') : [];

        if ( is_array($blacklist) ) {
            return $blacklist;
        }
        
        $urls_array = explode("\n", str_replace("\r", "", $blacklist));

        // Convert URL's to Id's, skipping URLs that don't return an ID
        $ids_array = array();
        foreach ($urls_array as $link) {
            $post_id = url_to_postid($link);
            if ($post_id > 0) {
                $ids_array[] = $post_id;
            }
        }

        return $ids_array;
    }
    
}