<main>
    <?php foreach($carrello as $articolo): ?>
    <p> 
        <?= $articolo->id?>
        <?= anchor('go/dettaglio/'.$articolo->id, $articolo->nome)?>
        <br>
        <?= img("images/" . $articolo->foto) ?>
    </p>
    <?php endforeach ?> 

</main>