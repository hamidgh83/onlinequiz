<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Online Quiz</title>
        <meta name="This is a simple MVC application to generate an online quiz" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?= $this->getAssetsUrl() ?>node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= $this->getAssetsUrl() ?>node_modules/bootstrap-select/dist/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="<?= $this->getAssetsUrl() ?>css/style.css" />
        
    </head>
    <body>
    
        <section class="container">
            <article class="content-wraper">
                <?php echo $content ?> 
            </article>
        </section>
    
        <script src="<?= $this->getAssetsUrl() ?>node_modules/jquery/dist/jquery.min.js"></script>
        <script src="<?= $this->getAssetsUrl() ?>node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?= $this->getAssetsUrl() ?>node_modules/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
        <script src="<?= $this->getAssetsUrl() ?>js/scripts.js"></script>
    </body>
</html>