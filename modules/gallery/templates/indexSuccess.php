<?php include_partial('gallery/assets') ?>
<?php include_partial('gallery/list_actions', array('helper' => $helper)) ?>

<?php if($pager->count()){ ?>
<link href="/galleryview/css/jquery.galleryview-3.0.css" media="screen" type="text/css" rel="stylesheet">


<div class="smaugv">
    <div id="smaugv-others">
        <h2><em>BIXI</em> Galleries</h2>
        <div>
            <div>
                <ul>
                    <?php foreach ($pager->getResults() as $nb=>$g) { ?>
                        <li>
                          <!-- this way we remember where the user is (gallery and page -->
                            <a title="<?php echo __("Editer") ?>" href="<?php echo url_for("gallery/edit?id=".$g->getId()) ?>"
                               style="background-image:url(<?php echo $g->getPhotoDefault() ?>);">
                                <span class="disposition alpha60"><?php echo "<span style='font-weight:bold'>".$g->getTitle()."</span><br/>".$g->getDescription() ?></span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <div style="float: right">
        <?php if ($pager->haveToPaginate()){ ?>
            <ul class="pagination ball">
                <?php foreach ($pager->getLinks() as $page){ ?>
                  <li <?php echo $page == $pager->getPage() ? "class='current'": ""; ?>>
                      <!-- this way we remember where the user is (gallery and page -->
                      <a href="<?php echo preg_replace("/\?[a-z\-&=0-9]+/","",$_SERVER["REQUEST_URI"]) ?><?php echo isset($_GET["gallery"])? "?gallery=".$_GET["gallery"]."&":"?"; ?>page=<?php echo $page ?>">
                          <span><?php echo $page ?></span>
                      </a>
                  </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</div>
<?php }else{ ?>
<?php echo __("No content yet"); ?>
<?php } ?>
