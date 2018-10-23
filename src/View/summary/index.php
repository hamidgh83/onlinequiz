
<section class="row">
    <section class="col-md-12">
        <article class="panel panel-default home">
            <div class="panel-body">
                <h1>Summary</h1>
                <table class="table table-striped">
                    <tr>
                        <td>Total questions</td>
                        <td><?= $totalQuestions ?></td>
                    </tr>
                    <tr>
                        <td>Passes</td>
                        <td><?= $correct ?></td>
                    </tr>
                    <tr>
                        <td>Faild</td>
                        <td><?= $wrong ?></td>
                    </tr>
                </table>

                <div class="text-center">
                    <a class="btn btn-success btn-lg" href="<?= $this->createUrl('index', 'index') ?>">Take another test</a>
                </div>
            </div>
        </article>    
    </section>
</section>