function crop(img, minWidth, maxWidth, minHeight, maxHeight, ratio){
    jcrop_api = $.Jcrop(img);
    jcrop_api.setOptions({
        onSelect: updateCoords,
        minSize: [ minWidth, minHeight ],
        maxSize: [ maxWidth, maxHeight ],
        aspectRatio: ratio
    });
    $('.jcrop-holder').css('margin','0 auto');
}

function updateCoords(c)
{
 jQuery('#x').val(c.x);
 jQuery('#y').val(c.y);
 jQuery('#w').val(c.w);
 jQuery('#h').val(c.h);
};

function checkCoords()
{
 if (parseInt(jQuery('#w').val())>0) return true;
 alert('Please select a crop region then press submit.');
 return false;
};