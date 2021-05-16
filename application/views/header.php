<!DOCTYPE html>
<html>
<title> Negozio biciclette </title>
<link rel="stylesheet" href="<?=base_url('stile.css')?>">
<header>
<h1> Negozio Biciclette </h1>
</header>
<body>
<nav>
<p id="utente">
<?php if($this->session->utente->nome == "anonimo") :?>
<?= anchor('go/entra', 'Entra')?>   /   <?= anchor('go/registrati', 'Registrati') ?>
<?php else: ?>
<?= anchor('go/esci', 'Esci') ?>
<?php endif; ?>
</p>

<p>
<?= anchor('go/index', 'Pagina Iniziale')?>
<?= anchor('go/faq', 'Domande Frequenti')?>
<?= anchor('go/catalogo', 'Catalogo')?>
<?= anchor('go/riservato', 'Riservato')?>
<?= anchor('go/carrello', 'Carrello')?>
<?= anchor('go/carrello', img('images/carrello-della-spesa.png'))?>
<span>
    <?= $this->session->utente->nome?>
    (<?= $this->session->utente->ruolo?>)
</span>
</p>
</nav>
</body>
</html>