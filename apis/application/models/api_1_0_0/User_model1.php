<?php
/* * ******************************************************************
 * Common model 
  ---------------------------------------------------------------------
 * @ Added by                 : Saswata Pal 
 * @ Framework                : CodeIgniter
 * @ Added Date               : 07-01-2016
  ---------------------------------------------------------------------
 * @ Details                  : It Cotains all the common query related method
  ---------------------------------------------------------------------
 ***********************************************************************/
class User_model extends CI_Model
{ 
    public $_volunteer_check_in = 'volunteer_check_in';
    public $_donation_reciept   = 'donation_reciept';

    function __construct()
    {
        //load the parent constructor
        parent::__construct();
    }

    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : insertVolunteer
     * @ Added Date               : 14-09-2016
     * @ Added By                 : Piyalee
     * -----------------------------------------------------------------
     * @ Description              : add volunteer
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function insertVolunteer($param = array())
    {  
        $this->db->insert($this->_volunteer_check_in, $param);
        $insert_id = $this->db->insert_id(); 
        return $insert_id;
    }

    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : insertDonation
     * @ Added Date               : 14-09-2016
     * @ Added By                 : Piyalee
     * -----------------------------------------------------------------
     * @ Description              : add donation
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function insertDonation($param = array())
    {  
        $this->db->insert($this->_donation_reciept, $param);
        $insert_id = $this->db->insert_id(); 
        return $insert_id;
    }

    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : lastIdVolunteer
     * @ Added Date               : 23-09-2016
     * @ Added By                 : Piyalee
     * -----------------------------------------------------------------
     * @ Description              : get last record_id volunteer
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   : int()
     * -----------------------------------------------------------------
     * 
     */
    public function lastIdVolunteer($param = array())
    {  
        $this->db->select('record_id');
        $this->db->order_by('record_id', 'DESC');
        $qry = $this->db->get($this->_volunteer_check_in);
        $insert_id = $qry->row_array(); 
        return $insert_id;
    }

    /*********************************
     * End of user model
     **********************************/
}