<?php

class Go extends CI_Controller {
    public function __construct(){
        parent::__construct();

        //se non c'è un utente lo creo anonimo
        if(!isset($this->session->utente)){
            $utente_anonimo = new stdClass();
            $utente_anonimo->nome = 'anonimo';
            $utente_anonimo->password = '';
            $utente_anonimo->ruolo = 'utente';
            //lo assegno alla sessione di lavoro
            $this->session->utente = $utente_anonimo;
        }
    }

    public function index(){
        $this->load->view('header');
        $this->load->view('home');
        $this->load->view('footer');
    }

    public function faq(){
        $this->load->view('header');
        $this->load->view('faq');
        $this->load->view('footer');
    }

    public function catalogo(){
        //Calcoli
        $data['articoli'] = $this->Negozio_model->get_articoli();
        //Risultati
        $this->load->view('header');
        $this->load->view('catalogo', $data);
        $this->load->view('footer');
    }

    public function dettaglio($id){
        $articoli[] = $this->Negozio_model->get_articolo($id);
        $articoli[] = $this->Negozio_model->get_articolo($id+1);
        if(!empty($articoli)) {
            $data['articoli'] = $articoli;
            $this->load->view('header');
            $this->load->view('dettaglio', $data);
            if(!empty($articoli[1])) {
                $this->load->view('prossimoArticolo', $data);
            }
            $this->load->view('footer');
        }
        else{
            $data['messaggio']="L'articolo non esiste!";
            $this->load->view('header');
            $this->load->view('errore', $data);
            $this->load->view('footer');
        }
    }

    public function carrello() {
        $data['carrello'] = $this->session->carrello;
        $this->load->view('header');
        $this->load->view('carrello', $data);
        $this->load->view('footer');
    }

    public function rimuoviDettaglio($id) {
        // $carrello = $this->session->carrello;
        // $this->session->carrello = array();
        // for($i = 0; $i < count($carrello); $i++) {
        //     if($carrello[$i]->id == $id) {
        //         unset($carrello[$i]);
        //         break;
        //     }
        // }
        // foreach($carrello as $dettaglio) {
        //     $this->session->carrello[] = $dettaglio;
        // }
        redirect("go/carrello");
    }

    public function entra(){
        $this->load->view('header');
        $this->load->view('login');
        $this->load->view('footer');
    }

    public function registrati() {
        $this->load->view('header');
        $this->load->view('signin');
        $this->load->view('footer');
    }
    
    public function esci(){
        //distruggere la sessione di lavoro
        $this->session->sess_destroy();
        redirect('go/index');
    }

    public function controllaLogin(){
        //acquisisco i dati
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        //interrogo il modello
        $utente = $this->Negozio_model->get_utente($email, $password);
        //controllo se l'utente esiste
        if(isset($utente)){
            $this->session->utente = $utente;
            redirect('go/index');
        }
        else {
            $data['messaggio']="L'utente non esiste!";
            $this->load->view('header');
            $this->load->view('errore', $data);
            $this->load->view('footer');
        }
    }

    private function redirectAfterSignIn($msg) {
        $data['messaggio']= $msg;
            $this->load->view('header');
            $this->load->view('errore', $data);
            $this->load->view('footer');
            header("refresh:1;url=index");
    }

    public function controllaSignin(){
        //acquisisco i dati
        $nome = $this->input->post('nome');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        //interrogo il modello
        $exists = $this->Negozio_model->exist_utente($email); 
        // $utente = $this->Negozio_model->get_utente($nome,$password);
        //controllo se l'utente esiste
        if(isset($exists)){
            $this->redirectAfterSignIn("Esiste già un utente con la stessa email! Reindirizzando...");
        }
        else {
            // $utente = stdClass();
            // $utente->nome = $nome;
            // $utente->password = $password;
            $this->Negozio_model->set_utente($nome, $email, $password);
            $utente = $this->Negozio_model->get_utente($email, $password);
            $this->session->utente->nome = $utente->nome;
            $this->session->utente->email = $utente->email;
            $this->session->utente->password = $utente->password;
            $this->session->utente->ruolo = $utente->ruolo;
            $this->redirectAfterSignIn("Utente registrato correttamente! Reindirizzando...");
        }
    }
    
    public function riservato(){
        $this->load->view('header');
        
        if($this->session->utente->ruolo == 'admin'){
            $this->load->view('riservato');
        }
        else{
            $data['messaggio']="Non sei un admin!";
            $this->load->view('errore', $data);
        }
        
        $this->load->view('footer');

    }

    public function mettiNelCarrello($id){
        $articolo = $this->Negozio_model->get_articolo($id);
        $this->load->view('header');
        $this->load->view('footer');
        if(isset($articolo)){
            //SCENARIO PRINCIPALE
            $merce = new stdClass();
            $merce->id = $articolo->id;
            $merce->nome = $articolo->nome;
            $merce->foto = $articolo->foto;
            $merce->prezzo = $articolo->prezzo;
            //prelevo il carrello dalla sessione
            $carrello = $this->session->carrello;
            $carrello[] = $merce;
            $this->session->carrello = $carrello;
            
            // $data['carrello'] = $carrello;
            redirect('go/carrello');
        }
        else {
            //SCENARIO ALTERNATIVO
            $data['messaggio']="L'articolo non esiste";
            $this->load->view('errore', $data);
        }
    }
}

?>