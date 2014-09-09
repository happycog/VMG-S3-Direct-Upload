<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * VMG S3 Direct Upload Module Install/Update File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Khaliq Gant
 * @link		http://www.vectormediagroup.com
 */

class Vmg_s3_direct_upload_upd {

    public $version = '1.0';

    private $EE;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->EE =& get_instance();
    }

    // ----------------------------------------------------------------

    /**
     * Installation Method
     *
     * @return 	boolean 	TRUE
     */
    public function install()
    {
        $mod_data = array(
            'module_name'			=> 'Vmg_s3_direct_upload',
            'module_version'		=> $this->version,
            'has_cp_backend'		=> "y",
            'has_publish_fields'	=> 'n'
        );

        $this->EE->db->insert('modules', $mod_data);

        // $this->EE->load->dbforge();
        /**
         * In order to setup your custom tables, uncomment the line above, and
         * start adding them below!
         */

        return TRUE;
    }

    // ----------------------------------------------------------------

    /**
     * Uninstall
     *
     * @return 	boolean 	TRUE
     */
    public function uninstall()
    {
        $mod_id = $this->EE->db->select('module_id')
            ->get_where('modules', array(
                'module_name'	=> 'Vmg_s3_direct_upload'
            ))->row('module_id');

        $this->EE->db->where('module_id', $mod_id)
            ->delete('module_member_groups');

        $this->EE->db->where('module_name', 'Vmg_s3_direct_upload')
            ->delete('modules');

        // $this->EE->load->dbforge();
        // Delete your custom tables & any ACT rows
        // you have in the actions table

        return TRUE;
    }

    // ----------------------------------------------------------------

    /**
     * Module Updater
     *
     * @return 	boolean 	TRUE
     */
    public function update($current = '')
    {
        // If you have updates, drop 'em in here.
        return TRUE;
    }

}
/* End of file upd.vmg_s3_direct_upload.php */
/* Location: /system/expressionengine/third_party/vmg_s3_direct_upload/upd.vmg_s3_direct_upload.php */
