<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  This template library can be used to automatically build
 *    views with a header, navigation and footer
 *
 *
 *    Usage: $this->template->show('view', $args);
 *    Note: make sure to include in autoload.php
 *
 *
 */
class Template
{
    function show($view, $args = NULL)
    {
        $CI =& get_instance();

        $CI->load->view('header',$args);
        if ($view != 'login' && $view != 'register' && $view != 'resetpassword' && $view != 'securityquestion' && $view != 'setpassword' && $view != 'resetsuccess'){
              $CI->load->view('navigation',$args);
        }
        $CI->load->view($view, $args);
        $CI->load->view('footer',$args);
    }
}
