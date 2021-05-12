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

    public function get_utente($nome,$password){
        $q = "SELECT * FROM utenti WHERE nome = ? AND password = ?";
        $query = $this->db->query($q, array($nome, $password));
        return $query->row();
    }

    public function set_utente($nome,$password) {
        $q = "INSERT INTO utenti (nome, password) VALUES (?, ?)";
        $query = $this->db->query($q, array($nome, $password));
        return $query->row();
    }

    public function exist_utente($nome){
        $q = "SELECT nome FROM utenti WHERE nome = ?";
        $query = $this->db->query($q, array($nome));
        return $query->row();
    }
}
?>