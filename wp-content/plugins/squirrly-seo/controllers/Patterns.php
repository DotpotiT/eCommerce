<?php
defined('ABSPATH') || die('Cheatin\' uh?');

class SQ_Controllers_Patterns extends SQ_Classes_FrontController
{

    /**
     * 
     *
     * @var SQ_Models_Domain_Patterns $patterns 
     */
    public $patterns;

    public function init()
    {
	    $handles = array();

        if (is_rtl()) {
	        $handles[] = SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('sqbootstrap.rtl');
	        $handles[] = SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('rtl');
        } else {
	        $handles[] = SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('sqbootstrap');
        }

	    $handles[] = SQ_Classes_ObjController::getClass('SQ_Classes_DisplayController')->loadMedia('patterns');

        echo '
        <script>
            jQuery.sq_patterns_list = jQuery.parseJSON("' . addslashes(SQ_ALL_PATTERNS) . '");
            var __sq_save_message = "' . esc_html__("Saved!", 'squirrly-seo') . '";
            var __sq_save_message_preview = "' . esc_html__("Saved! This is how the preview looks like", 'squirrly-seo') . '";
        </script>';

	    wp_print_styles($handles);
	    wp_print_scripts($handles);
    }

    /**
     * Replace the patterns by each tags
     *
     * @param  SQ_Models_Domain_Post $post
     * @return SQ_Models_Domain_Post | false
     */
    public function replacePatterns($post)
    {
        if ($post instanceof SQ_Models_Domain_Post) {
            //set the patterns based on the current post
            $this->patterns = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Patterns', $post->toArray());

            //set the current post for excerpt and description
            $this->patterns->currentpost = $post;

            //Foreach SQ, if has patterns, replace them
            if ($sq_array = $post->sq->toArray()) {

                //set the keywords from sq and not from post
                $this->patterns->keywords = $post->sq->keywords;

                $post->sq = $this->processPatterns($sq_array, $post->sq);
            }
        }
        return $post;

    }

    /**
     * Get all patterns to process and add them in the object
     *
     * @param  $values
     * @param  $object
     * @return mixed
     */
    public function processPatterns($values, $object)
    {

        //Foreach SQ, if has patterns, replace them
        $sq_with_patterns = array();
        //Set the Separator from object automation
        //do not remove it from here
        $this->patterns->sep = $object->sep;

        if (!empty($values)) {
            foreach ($values as $name => $value) {
                if ($name <> '' && !is_array($value) && $value <> '') {

                    if (strpos($value, '%%') !== false) { //in case there are still patterns from Yoast
                        $value = preg_replace('/%%([^\%]+)%%/s', '{{$1}}', $value);
                        $object->$name = preg_replace('/%%([^\%]+)%%/s', '{{$1}}', $object->$name);
                    }

                    if (strpos($value, '%') !== false) { //in case there are still patterns from Rank Math
                        $value = preg_replace('/%([^\%]+)%/s', '{{$1}}', $value);
                        $object->$name = preg_replace('/%([^\%]+)%/s', '{{$1}}', $object->$name);
                    }

                    if(is_string($value) && $value <> '') {
                        if (strpos($value, '{{') !== false && strpos($value, '}}') !== false) {
                            $sq_with_patterns[$name] = $value;
                        }
                    }
                }
            }
            if (!empty($sq_with_patterns)) {
                foreach ($this->patterns->getPatterns() as $key => $pattern) {
                    foreach ($sq_with_patterns as $name => $value) {
                        if ($name <> '' && is_string($value) &&  $value <> '' && $pattern <> '') {
                            if (stripos($value, $pattern) !== false && $object->$name) {
                                if($this->patterns->$key) {
                                    $object->$name = str_ireplace($pattern, $this->patterns->$key, $object->$name);
                                }else{
                                    $object->$name = str_ireplace($pattern, '', $object->$name);
                                }
                            }
                        }
                    }
                }

            }
        }

        return $object;
    }

    /**
     * Called when Post action is triggered
     *
     * @return void
     */
    public function action()
    {
        parent::action();

        switch (SQ_Classes_Helpers_Tools::getValue('action')) {
            case 'sq_getpatterns':
	            //return json with the results
	            SQ_Classes_Helpers_Tools::setHeader('json');

	            if (!SQ_Classes_Helpers_Tools::userCan('sq_manage_snippet')) {
		            $response['error'] = SQ_Classes_Error::showNotices(esc_html__("You do not have permission to perform this action", 'squirrly-seo'), 'error');
		            echo wp_json_encode($response);
		            exit();
	            }

	            $all_patterns = json_decode(SQ_ALL_PATTERNS, true);
	            $patterns = false;

	            $post_id = (int)SQ_Classes_Helpers_Tools::getValue('post_id', 0);
	            $term_id = (int)SQ_Classes_Helpers_Tools::getValue('term_id', 0);
	            $taxonomy = SQ_Classes_Helpers_Tools::getValue('taxonomy', 'category');
	            $post_type = SQ_Classes_Helpers_Tools::getValue('post_type', 'post');

	            if ($post = SQ_Classes_ObjController::getDomain('SQ_Models_Snippet')->getCurrentSnippet($post_id, $term_id, $taxonomy, $post_type)) {

	                $patterns = SQ_Classes_ObjController::getDomain('SQ_Models_Domain_Patterns', $post->toArray());
	                $patterns = $this->processPatterns(array_keys($all_patterns), $patterns);

	                //Set the separator character from post sep
	                $patterns->sep = $post->sq->sep;

	                foreach ($all_patterns as $pattern => $title) {
	                    $name = preg_replace('/{{([^\}]+)}}/s', '$1', $pattern);
	                    $all_patterns[$pattern] = array('value' => $patterns->$name, 'details' => $all_patterns[$pattern]);
	                }
	            }


	            if (SQ_Classes_Helpers_Tools::isAjax()) {
	                echo wp_json_encode(array('json' => wp_json_encode($all_patterns)));
	                exit();
	            }
	            break;
        }
    }


}
