<?php 
 
class Rsvp_model extends CI_Model { 
 
  function __construct()
  { 
    parent::__construct();
    $this->load->database();
  } 

  function insert_data($data) 
  { 
    $this->db->insert('rsvps', $data);
    return $this->db->affected_rows();
  } 

} 

?>
