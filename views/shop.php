<?php
require 'views/partials/head.php';
require 'views/partials/header.php';
?>


<?php if (isset($items)): ?>
    <?php foreach ($items as $index => $item): ?>
        <div>
            <?php if (isset($item)): ?>
                <h3>
                    <?= $item['item']->getId() ?> -
                    <?= $item['item']->getName() ?> (
                    <?= $item['quantity'] ?> )
                </h3>
                <h5>
                    <?= $item['item']->getDescription() ?> <br>
                </h5>
                <p>
                    Item Weight: <?= $item['item']->getItemWeight() ?><br>
                    Buy Price: <?= $item['item']->getBuyPrice() ?><br>
                    Sell Price: <?= $item['item']->getSellPrice() ?><br>
                    Image Link: <?= $item['item']->getImageLink() ?><br>
                    Utility: <?= $item['item']->getUtility() ?><br>
                    Item Status: <?= $item['item']->getItemStatus() ?><br>
                </p>
                <br>
            <?php endif; ?>
        </div>
        <br>
    <?php endforeach; ?>
<?php endif; ?>

<?php
require 'views/partials/footer.php';
?>
