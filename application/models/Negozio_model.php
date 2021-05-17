<?php
class Negozio_model extends CI_Model{
    public function get_articoli(){
        $query = $this->db->query('SELECT id, nome, foto, prezzo FROM articoli ORDER BY id');
        return $query->result(); //array di oggetti
    }

    public function get_articolo($id){
        $q = "SELECT id, nome, foto, prezzo FROM articoli WHERE id = '$id'";
        $query = $this->db->query($q);
        return $query->row();
    }

    public function get_utente($nome, $email, $password){
        $q = "SELECT * FROM utenti WHERE AND email = ? AND password = ?";
        $query = $this->db->query($q, array($email, $password));
        return $query->row();
    }

    public function set_utente($nome, $password, $email) {
        $q = "INSERT INTO utenti (nome, password, ruolo, email) VALUES (?, ?, 'utente', ?)";
        $query = $this->db->query($q, array($nome, $password, $email));
    }

    public function exist_utente($email){
        $q = "SELECT nome FROM utenti WHERE email = ?";
        $query = $this->db->query($q, array($email));
        return $query->row();
    }
}
?>