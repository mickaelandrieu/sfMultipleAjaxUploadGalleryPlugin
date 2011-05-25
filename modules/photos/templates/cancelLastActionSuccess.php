<form action="<?php echo url_for('@photo_reback') ?>" method="POST">
<div class="">Attention ! Tous retour en arrière supprime les images postérieures à celle ci !</div>
<?php foreach ($imgs as $thumb) :?>
    <div class="">
        <input type="radio" name="picpath" value="<?php echo $thumb ?>"/>
        <img src="<?php echo $dir.'/'.$thumb ?>" alt="<?php echo $thumb ?>"/>
    </div>
<?php endforeach; ?>
    <div class="">
        <input type="radio" name="picpath" value="<?php echo $current ?>" checked="checked"/>
        <img src="<?php echo $dir.'/'.$current ?>" alt="<?php echo $current ?>"/>
    </div>
<input type="hidden" value="<?php echo $photo->getId() ?>" name="id"/>
<input type="hidden" value="<?php echo $picpath_orig ?>" name="picpath_orig"/>
<input type="submit" value="Valider cette version"/>
<a href="<?php echo url_for("@photos") ?>">Revenir à la liste</a>
</form>