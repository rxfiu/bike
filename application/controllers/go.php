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

    public function entra(){
        $this->load->view('header');
        $this->load->view('login');
        $this->load->view('footer');
    }
    
    public function esci(){
        //distruggere la sessione di lavoro
        $this->session->sess_destroy();
        redirect('go/index');
    }

    public function controllaLogin(){
        //acquisisco i dati
        $nome = $this->input->post('nome');
        $password = $this->input->post('password');
        //interrogo il modello
        $utente = $this->Negozio_model->get_utente($nome,$password);
        //controllo se l'utente esiste
        if(isset($utente)){
            $this->session->utente = $utente;
            $this->load->view('header');
            $this->load->view('home');
            $this->load->view('footer');
        }
        else {
            $data['messaggio']="L'utente non esiste!";
            $this->load->view('header');
            $this->load->view('errore', $data);
            $this->load->view('footer');
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