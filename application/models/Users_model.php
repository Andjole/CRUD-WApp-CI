<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
  
Class Users_model extends CI_Model{  
      
    // CREATE  
    public function AddUser($data){  
        $this->db->insert('users', $data);  
        return $this->db->insert_id();  
    }  
  
  
    // READ  
    public function GetUsers($id=null){  
        if(!is_null($id)){  
			$this->db->where('id', $id);  
		}  
        $query = $this->db->get('users');  
		if(!is_null($id)){  
			return $query->row();
		}else{
			return $query->result();  
		}
	}  
      
    // UPDATE  
    function update($id, $data){  
        $this->db->where('id', $id);  
        $this->db->update('users', $data);  
        }  
  
  
    // DELETE  
    public function DeleteUserById($id){    
        $this->db->where('id', $id);  
        $this->db->delete('users');  
        return $this->db->affected_rows();  
        }  
  
}  
  
/*NB: nessun tag di chiusura di php*/  