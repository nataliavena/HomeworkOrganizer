
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['acl'] = array('home' => array('public' => false, 'member' => true, 'admin' => true),
                       'dashboard' => array('public' => false, 'member' => true, 'admin' => true),
                       'assignments' => array('public' => false, 'member' => true, 'admin' => true),
                       'settings' => array('public' => false, 'member' => true, 'admin' => true),
                       'admin' => array('public' => false, 'member' => false, 'admin' => true),
                       'login' => array('public' => true, 'member' => true, 'admin' => true),
                       'register' => array('public' => true, 'member' => true, 'admin' => true),
                       'resetpassword' => array('public' => true, 'member' => true, 'admin' => true),
                       'securityquestion' => array('public' => true, 'member' => true, 'admin' => true),
                       'setpassword' => array('public' => true, 'member' => true, 'admin' => true),
                       'assignments' => array('public' => false, 'member' => true, 'admin' => true),
                       'addassignment' => array('public' => false, 'member' => true, 'admin' => true),
                       'reportuser' => array('public' => false, 'member' => true, 'admin' => true),
                       'share' => array('public' => false, 'member' => true, 'admin' => true),
                       'addtasks' => array('public' => false, 'member' => true, 'admin' => true)
                      );
