<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * VMG S3 Direct Upload Module Control Panel File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Khaliq Gant
 * @link		http://www.vectormediagroup.com
 */

class Vmg_s3_direct_upload_mcp {

    public $return_data;

    private $_base_url;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->EE =& get_instance();

        $this->_base_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=vmg_s3_direct_upload';

        $this->EE->cp->set_right_nav(array(
            'module_home'   => $this->_base_url,
        ));

        //set the themes information
        $this->theme_folder_url = $this->EE->config->item('theme_folder_url') . 'third_party/vmg_s3_direct_upload/';
        $this->css_files = array(
            'vmg_s3_direct_upload.css',
        );
        $this->js_files = array(
            'vmg_s3_direct_upload.js',
            'jquery.ui.widget.js',
            'jquery.iframe-transport.js',
            'jquery.fileupload.js',
        );

        //load helpers
        $this->EE->load->library('table');
        $this->EE->load->library('javascript');
        $this->EE->load->helper('form');

        //load s3 direct upload library
        $this->EE->load->library('Vmg_s3_direct_upload_lib');
        $this->lib = $this->EE->vmg_s3_direct_upload_lib;
    }


    /**
     * Index Function
     * Set the view vars and add in the css/js assets
     * @return 	void
     */
    public function index()
    {
        $this->EE->cp->set_variable('cp_page_title',
            lang('vmg_s3_direct_upload_module_name'));

        //set the vars
        $vars['bucket_name']    = $this->lib->bucket_name;
        $vars['access_key']     = $this->lib->access_key;
        $vars['signature']      = $this->lib->signature;
        $vars['policy']         = $this->lib->policy_generator();
        $vars['acl']            = $this->lib->acl;
        $vars['storage_class']  = $this->lib->storage_class;

        //load the assets
        $this->_load_css();
        $this->_load_js();

        return ee()->load->view('index', $vars, TRUE);
    }

    /**
     * Load JS
     * Add an array of files to the footer
     */
    private function _load_js()
    {
        foreach ($this->js_files as $file)
        {
            $this->EE->cp->add_to_foot('<script type="text/javascript" src="' . $this->theme_folder_url . 'js/' . $file . '?v='.time().'"></script>');
        }
    }

    /**
     * Load CSS
     * Add an array of files to the header
     */
    private function _load_css()
    {
        foreach ($this->css_files as $file)
        {
            $this->EE->cp->add_to_head('<link rel="stylesheet" type="text/css" href="'. $this->theme_folder_url . 'css/' . $file . '?v='.time().'" />');
        }
    }


}
/* End of file mcp.vmg_s3_direct_upload.php */
/* Location: /system/expressionengine/third_party/vmg_s3_direct_upload/mcp.vmg_s3_direct_upload.php */
