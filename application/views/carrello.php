<main>
    <?php if (!empty($carrello)) {?>
    <?php foreach($carrello as $articolo): ?>
    <p> 
        <?= $articolo->id?>
        <?= anchor('go/dettaglio/'.$articolo->id, $articolo->nome)?>
        <?= anchor('go/rimuoviDettaglio/'.$articolo->id, "Rimuovi") ?>
        <br>
        <?= img("images/" . $articolo->foto) ?>
    </p>
    <?php endforeach ?>
    <?php } else { ?> 
    <p> Nessun articolo! </p>
    <?php } ?>
</main>