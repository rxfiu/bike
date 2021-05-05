<main>
    <h2>Articolo</h2>
    <p> ID <?= $articoli[0]->id ?> </p>
    <p> <?= $articoli[0]->nome ?> </p> 
    <?= img("images/" . $articoli[0]->foto) ?>
    <p>PREZZO</p>
    <p> 
        <?= $articoli[0]->prezzo?>
        <br><br>

        
        <?= anchor('go/mettiNelCarrello/'.($articoli[0]->id), "Aggiungi al carrello");?>
    </p>
</main>