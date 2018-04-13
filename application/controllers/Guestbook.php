<?php   
if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
  
Class Guestbook extends CI_Controller {  
    public function index(){  
        // load model gusetbook  
        $this->load->model('guestbook_model');  
      
        // get data  
        $data['titolo'] = 'Il mio guestbook con CodeIgniter';  
        $data['commenti'] = $this->guestbook_model->GetComment();  
        $data['numero_commenti'] = count($data['commenti']);  
  
        // show view  
        $this->load->view('guestbook_view', $data);  
	}  
  
    public function newcomment(){  
		/* eseguiamo il load della Form Validation Class */  
		$this->load->library('form_validation');  

		/* per ogni input indichiamo le regole (rules) di validazione con il metodo set_rules() */  
		/* 
		validazione del campo 'nome':  
		1) applichiamo al valore la funzione trim() per eliminare gli spazi iniziali e finali 
		2) required per verificare che non sia una stringa vuota 
		3) applichiamo al valore la funzione htmlspecialchars() per immunizzare i caratteri pericolosi in caso di stampa a video 
		*/  
		$this->form_validation->set_rules('nome', 'nome', 'trim|required|htmlspecialchars');  
		/* 
		validazione del campo 'email': 
		1) required per verificare che non sia una stringa vuota 
		2) valid_email per verificare la sintassi dell'indirizzo email 
		*/  
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');  
		/* 
		validazione del campo website 
		1) filtriamolo con htmlentities 
		*/  
		$this->form_validation->set_rules('website', 'website', 'htmlspecialchars');  
		/* 
		validazione del campo 'commento': 
		1) applichiamo al valore la funzione trim() per eliminare gli spazi iniziali e finali 
		2) required per verificare che non sia una stringa vuota 
		3) min_lenght[6] per verificare che il commento abbia una lunghezza minima di 6 caratteri 
		4) applichiamo al valore la funzione htmlspecialchars() per immunizzare i caratteri pericolosi in caso di stampa a video 
		*/  
		$this->form_validation->set_rules('commento', 'commento', 'trim|required|min_length[6]|htmlspecialchars');  

		/* se la validazione è andata a buon fine*/  
		if($this->form_validation->run()==TRUE){  
		/* eseguamo il load del guestbook_model */  
		$this->load->model('guestbook_model');  
		/* applichaimo il metodo AddComment dell'user_model */  
		$this->guestbook_model->AddComment(  
				$this->input->post('nome'),   
				$this->input->post('email'),   
				(string) $this->input->post('website'),   
				$this->input->post('commento')  
				);  
		/* redirect al guestbook */  
		redirect('/guestbook');  
		}  
		/* altrimenti mostriamo i messsaggi di errore della validazione */  
		else{  

		echo validation_errors();  
		}    
	}  
	public function deleteComment(){  
		$link_id = $this->uri->segment(3);
		 $this->load->model('guestbook_model');  
		$this->guestbook_model->DeleteCommetById($link_id);  
		redirect('/guestbook');  
	}
}  