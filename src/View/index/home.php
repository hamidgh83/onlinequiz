
<section class="row">
    <section class="col-md-12">
        <article class="panel panel-default home">
            <div class="panel-body">
                <h1>Technical Task</h1>
                <form class="col-md-10 col-sm-12 col-md-offset-1" action="<?= $this->createUrl('quiz', 'question') ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter your name" />
                    </div>

                    <div class="form-group">
                        <select name="quiz" class="selectpicker" multiple title="Choose a test">
                            <?php foreach ($quizes as $quiz): ?>
                            <option value="<?= $quiz['id'] ?>"><?= $quiz['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button class="btn btn-primary btn-lg" type="submit">Start</button>
                </form>
            </div>
        </article>    
    </section>
</section>