
<section class="row">
    <section class="col-md-12">
        <article class="panel panel-default home">
            <div class="panel-body">
                <h1>Technical Task</h1>
                <?php $actionUrl = $this->createUrl('quiz', 'question'); ?>
                <form class="col-md-10 col-sm-12 col-md-offset-1" action='<?= $actionUrl ?>' method="post">
                    <div class="form-group has-error">
                        <input type="text" class="form-control" placeholder="Enter your name" data-required="true" />
                        <span class="help-block">This field is required</span>
                    </div>
                    
                    <div class="form-group has-error">
                        <select name="quiz" class="selectpicker" title="Choose a test" data-required="true">
                            <?php foreach ($quizes as $quiz): ?>
                            <option value="<?= $quiz['id'] ?>"><?= $quiz['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="help-block">This field is required</span>
                    </div>

                    <button class="btn btn-primary btn-lg" type="submit">Start</button>
                </form>
            </div>
        </article>    
    </section>
</section>