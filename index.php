<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Share+Tech+Mono' rel='stylesheet' type='text/css'>
        <title></title>
    </head>
    <body>
        <?php
            include_once('classes/Filmes.class.php');
            $filmes = new Filmes();
           
            $tituloFilmes  = $filmes->getFilmes();
            $sinopseFilmes = $filmes->getSinopse();
            $censuraFilmes = $filmes->getCensura();
            $horarioFilmes = $filmes->getHorarios();
            
            $contador = 0;
          while($contador < $filmes->getTamanho()){  
        ?>
        <div id="container">
            <div id="titulo-filme">
                <h1><p><?php echo $tituloFilmes[$contador]; ?> </p></h1>
                <div id="sinopse">
                    <p>
                        <?php 
                            echo $sinopseFilmes[$contador];
                        ?>
                        <br><br>
                        <?php echo $horarioFilmes[$contador]; ?>
                        <br><br>
                        <?php echo $censuraFilmes[$contador]; ?>
                    </p>
                </div>
            </div>
        </div>
          <?php $contador++; } ?>
    </body>
</html>
