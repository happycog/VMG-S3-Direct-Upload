<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vmg_s3_direct_upload_ft extends EE_Fieldtype
{
     public $info = array(
        'name'      => 'VMG S3 Direct Upload',
        'version'   => '1.0'
    );

     /**
     * @var EE
     */
    public $EE;


    public function __construct()
    {
        parent::__construct();

        // Add Package Path
        $this->EE->load->add_package_path(PATH_THIRD.'vmg_s3_direct_upload/');

        //set the themes information
        $this->theme_folder_url = $this->EE->config->item('theme_folder_url') . 'third_party/vmg_s3_direct_upload/';
        $this->include_theme_css('vmg_s3_direct_upload.css');
        $this->include_theme_js('vmg_s3_direct_upload.js');
        $this->include_theme_js('jquery.ui.widget.js');
        $this->include_theme_js('jquery.iframe-transport.js');
        $this->include_theme_js('jquery.fileupload.js');

        $this->cell_name = $this->info['name'];

        //load s3 direct upload library
        $this->EE->load->library('Vmg_s3_direct_upload_lib');
        $this->lib = $this->EE->vmg_s3_direct_upload_lib;


    }

    /**
     * Display the field with the bucket name and other appropriate info
     * @return array
     */
    public function display_field($data)
    {
        return $this->EE->load->view('index',array(
            'field_id'      => $this->field_name,
            'field_name'    => $this->cell_name,
            'file'          => $data,
            'bucket_name'   => $this->lib->bucket_name,
            'access_key'    => $this->lib->access_key,
            'policy'        => $this->lib->policy_generator(),
            'signature'     => $this->lib->signature,
            'acl'           => $this->lib->acl,
            'storage_class' => $this->lib->storage_class,
        ), TRUE);

    }

    public function display_cell($data)
    {
        return $this->display_field($data);
    }

    /**
     * Include Theme CSS
     */
    protected function include_theme_css($file)
    {
        $this->EE->cp->add_to_head('<link rel="stylesheet" type="text/css" href="'. $this->theme_folder_url . 'css/' . $file . '?v='.time().'" />');
    }

    /**
     * Include Theme JS
     */
    protected function include_theme_js($file)
    {
        $this->EE->cp->add_to_foot('<script type="text/javascript" src="' . $this->theme_folder_url . 'js/' . $file . '?v='.time().'"></script>');
    }

    /**
     * Save Cell
     */
    function save_cell($data)
    {
        return $data;
    }

    public function save($value)
    {
        return $value;
    }

    /**
     * Replace tag
     *
     * @access  public
     * @param   field data
     * @param   field parameters
     * @param   data between tag pairs
     * @return  replacement text
     *
     */
    function replace_tag($data, $params = array(), $tagdata = FALSE)
    {

    }

    /**
     * Install Fieldtype
     *
     * @access  public
     * @return  array of default global settings
     *
     */
    function install()
    {

    }

    /**
     * Display Settings Screen for single field
     *
     * @access  public
     * @return  default settings
     *
     */
    function display_settings($data)
    {

    }
}
