<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
  
Class Guestbook_model extends CI_Model{  
      
    // CREATE  
    public function AddComment($name, $email, $website, $comment){  
        $data = array(  
                'name'      => $name,  
                'email'     => $email,  
                'website'   => $website,  
                'comment'   => $comment,  
                'time_insert'   => date('Y-m-d H:i:s')  
                );  
        $this->db->insert('guestbook', $data);  
        return $this->db->insert_id();  
        }  
  
  
    // READ  
    public function GetComment($id=null){  
        if(!is_null($id)){  
            $this->db->where('id', $id);  
            }  
        $this->db->order_by('time_insert', 'desc');  
        $query = $this->db->get('guestbook');  
        return $query->result();  
        }  
      
    // UPDATE  
    function update($id, $data){  
        $this->db->where('id', $id);  
        $this->db->update('guestbook', $data);  
        }  
  
  
    // DELETE  
    public function DeleteCommetById($id){    
        $this->db->where('id', $id);  
        $this->db->delete('guestbook');  
        return $this->db->affected_rows();  
        }  
  
}  
  
/*NB: nessun tag di chiusura di php*/  