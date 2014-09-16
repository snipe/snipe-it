<?php
    $presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);

    $trans = $environment->getTranslator();
?>

<?php if ($paginator->getLastPage() > 1): ?>
    <ul class="pager">
        <?php
            echo $presenter->getPrevious($trans->trans('general.previous'));

            echo $presenter->getNext($trans->trans('general.next'));
        ?>
    </ul>
<?php endif; ?>
