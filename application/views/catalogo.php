<main>
    <h2>Catalogo</h2>
    <p> ID  NOME</p>
    <?php foreach($articoli as $articolo): ?>
    <p> 
        <?= $articolo->id?>
        <?= anchor('go/dettaglio/'.$articolo->id, $articolo->nome)?> 
        <?= anchor('go/mettiNelCarrello/'.$articolo->id, "Aggiungi al carrello")?>
    </p>
<?php endforeach ?>
</main>