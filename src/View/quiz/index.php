<div class="alert alert-danger" style="display:none"></div>

<form action="" method="post" id="question-form">
  <section class="row">
    <section class="panel panel-default">
      <section class="panel-body">
        <article class="question row">
          <div class="col-md-12">
            <h1><?= $question ?></h1>
            <input name="question" type="hidden" value="<?= $questionId ?>" />
          </div>
        </article>
        
        <article class="answers row">
          <?php foreach ($answers as $answer): ?>
          <div data-toggle="buttons" class="col-md-6 col-sm-12">
            <label class="btn btn-info btn-block">
              <input type="radio" name="answer" value="<?= $answer['answerId'] ?>"> <?= $answer['answer'] ?>
            </label>
          </div>
          <?php endforeach ?>
        </article>

        <article class="row">
          <div class="col-md-12">
            <div class="progress">
              <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?= $progress ?>"
              aria-valuemin="0" aria-valuemax="100" style="width:<?= $progress ?>%">
                <?= $progress ?>% Complete
              </div>
            </div>
          </div>
        </article>
      </section>
      
      <section class="panel-footer text-right">
        <button type="submit" class="btn btn-default"><?= ($progress == 100) ? 'submit' : 'Next' ?></button>
      </section>
    </section>
  </section>
</form>