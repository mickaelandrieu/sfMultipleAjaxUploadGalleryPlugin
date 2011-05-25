<?php

require_once dirname(__FILE__).'/../lib/photosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/photosGeneratorHelper.class.php';

/**
 * photos actions.
 *
 * @package    sfMultipleAjaxUploadGalleryPlugin
 * @subpackage photos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class photosActions extends autoPhotosActions
{
    public function executeBatch(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        if (!$ids = $request->getParameter('ids'))
        {
          $this->getUser()->setFlash('error', 'You must at least select one item.');

          if ($request->isXmlHttpRequest()) {
              $this->txt = $this->getUser()->getFlash('error');
              $this->getUser()->setFlash('error', null);
              return sfView::ERROR;
          } else {
              $this->redirect('@photos');
          }
        }

        if (!$action = $request->getParameter('batch_action'))
        {
          $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

          if ($request->isXmlHttpRequest()) {
              $this->txt = $this->getUser()->getFlash('error');
              $this->getUser()->setFlash('error', null);
              return sfView::ERROR;
          } else {
              $this->redirect('@photos');
          }
        }

        if (!method_exists($this, $method = 'execute'.ucfirst($action)))
        {
          throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
        }

        if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
        {
          $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        $validator = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'photos'));
        try
        {
          // validate ids
          $ids = $validator->clean($ids);

          // execute batch
          $rst = $this->$method($request);
        }
        catch (sfValidatorError $e)
        {
          $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
        }

        if ($request->isXmlHttpRequest()) {
            if (is_array($rst)) {
                foreach ($rst as $k => $v) {
                    $this->$k = $v;
                }
            } elseif ($rst == sfView::NONE) {
                return $rst;
            }

            $this->ids = $request->getParameter('ids');

            return sfView::SUCCESS;
        } else {
            $this->redirect('@photos');
        }

    }

    public function executeUpdateTitle(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            $id = $request->getParameter('id');
            $title = $request->getParameter('title');
            $photo = Doctrine::getTable('photos')->find($id);
            $photo->setTitle($title);
            $photo->update();
            return $this->renderText('La photo a bien été modifiée !');
        }
    }

    public function executeCrop(sfWebRequest $request)
    {
        if ($request->isMethod(sfRequest::POST) )
        {
            $values = array();
            foreach ($request->getPostParameters() as $key => $value) {
                $values[] = $value;
            }
            list($left,$top,$width,$height,$photo_id) = $values;
            $photo = Doctrine::getTable('Photos')->find($photo_id);
            $gallery = Doctrine::getTable('gallery')->find($photo->getGalleryId());
            if(!$photo instanceof  Photos) $photo = new Photos();
            $quality = 100;

            $ok = $photo->crop($left, $top, $width, $height, $quality);

           $message = $ok==true? "La photo a bien été réduite":"Erreur dans la modification de la photo";

            $this->getUser()->setFlash('ajax_notice',$message);
            return $this->renderPartial('gallery/photoListe', array('photos'=> $gallery->getPhotos()));
        }
    }

    private function batchMethod()
    {
        $this->setTemplate('batch');

        $numargs = func_num_args();
        if ($numargs < 3) {
            $this->getUser()->setFlash('error', 'Error execution method');
            return $this->renderText($this->generateUrl("photos", array(), true));
        }
        $arg_list = func_get_args();
        //argument 0
        $request = array_shift($arg_list);
        if (!$request instanceof  sfWebRequest) {
            $this->getUser()->setFlash('error', 'Error execution method');
            return $this->renderText($this->generateUrl("photos", array(), true));
        }
        //argument 1
        $message = array_shift($arg_list);
        //argument 2
        $method = array_shift($arg_list);

        if ($request->isMethod(sfRequest::POST)) {
            $ids = $request->getParameter('ids');
            $arr = array();
            foreach($ids as $photo_id):
                $photo = Doctrine::getTable('Photos')->find($photo_id);
                $gallery = Doctrine::getTable('gallery')->find($photo->getGalleryId());
                if (!$photo instanceof  Photos) {
                    $photo = new Photos();
                }
                call_user_func_array(array($photo, $method), $arg_list);
                $arr[$photo_id] = $photo->getFullPicpathDefault();
            endforeach;
            //$this->getUser()->setFlash('notice',$message);
            //$this->renderText($this->generateUrl("photos", array(), true));
            return $this->renderText('json;;'.$message.';;'.json_encode($arr));
        }
    }

    public function executeBatchFiligrane(sfWebRequest $request)
    {
        return array('form' => new PluginBackendPhotosFiligraneForm(),
                    'url' => 'http://demo.com/backend_dev.php/photos/filigrane',
                    'title' => 'Gestion Filigrane');
    }

    public function executeFiligrane(sfWebRequest $request)
    {
        $params = $request->getParameter('filigrane');
        return $this->batchMethod($request, 'Les photos ont bien intégrées le filigrane', 'overlay', $params['position']);
    }

    public function executeBatchRotate90(sfWebRequest $request)
    {
        return $this->batchMethod($request, 'Les photos ont bien été tournés de 90°', 'rotate', 90);
    }

    public function executeBatchRotate180(sfWebRequest $request)
    {
        return $this->batchMethod($request, 'Les photos ont bien été tournés de 180°', 'rotate', 180);
    }

    public function executeBatchRotate270(sfWebRequest $request)
    {
        return $this->batchMethod($request, 'Les photos ont bien été tournés de 270°', 'rotate', 270);
    }

    public function executeBatchBlackAndWhite(sfWebRequest $request)
    {
        return $this->batchMethod($request, 'Les photos ont bien été retouchés en noir et blanc', 'greyScale');
    }

    public function executeBatchFlipH(sfWebRequest $request)
    {
        return $this->batchMethod($request, 'Les photos ont bien été retouchés en noir et blanc', 'flip');
    }

    public function executeBatchFlipV(sfWebRequest $request)
    {
        return $this->batchMethod($request, 'Les photos ont bien été retouchés en noir et blanc', 'flipV');
    }

    public function executeBatchBrightness(sfWebRequest $request)
    {
        return $this->batchMethod($request, 'Les photos ont bien été retouchés en noir et blanc', 'brightness', 100);
    }

    public function executeListCancelLastAction(sfWebRequest $request)
    {
        /** @var $photo PluginPhotos */
        $this->photo = $this->getRoute()->getObject();
        $picpathanalyse = explode("_",$this->photo->getPicPath());
        if (count($picpathanalyse)>0 && is_numeric($picpathanalyse[0])) {
            $picpath_orig = "";
            foreach ($picpathanalyse as $key => $value) {
                if($key!=0){
                    $picpath_orig .= "_".$value;
                }
            }
            $picpath_orig = substr($picpath_orig, 1);
            $key = intval($picpathanalyse[0])+1;
        }else{
            //pas d'antécédent
            $this->getUser()->setFlash('error', 'pas d\'antécédent.');
            $this->redirect('photos');
        }
        $this->picpath_orig = $picpath_orig;
        $path = $this->photo->getListPicPath($picpath_orig);
        $this->current = array_pop($path);
        $this->imgs = $path;
        $this->dir = dirname($this->photo->getFullPicPathDefault());
        $this->setTemplate('cancelLastAction');
        return sfView::SUCCESS;
    }

    public function executeBatchSepia(sfWebRequest $request)
    {
        return $this->batchMethod($request, 'Les photos ont bien été retouchés en noir et blanc', 'colorize', 112, 66, 20);
    }

    public function executeBatchColorize(sfWebRequest $request)
    {
        $onclick = 'picker.fromString(this.value)';

        return array('form' => new PluginBackendPhotosColorizeForm(),
                    'url' => 'http://demo.com/backend_dev.php/photos/colorize',
                    'add_field' => Photos::colorizeDefaultChoice($onclick),
                    'title' => 'Gestion Couleur',
        );
    }

    public function executeColorize(sfWebRequest $request)
    {
        $params = $request->getParameter('colorize');
        $color = Photos::rgb2hex2rgb($params['color']);
        return $this->batchMethod($request, 'Les photos ont bien intégrées le filigrane', 'colorize', $color['red'], $color['green'], $color['blue']);
    }

    public function executeReback(sfWebRequest $request)
    {
        $photo = PhotosTable::getInstance()->findOneById(array($request->getParameter('id')));
        /* @var $photo Photos */
        $newPicpath = $request->getParameter('picpath');
        $picpathOrig = $request->getParameter('picpath_orig');
        $imgs = $photo->getListPicPath($picpathOrig);
        $dir = dirname($photo->getFullPicPath());
        $thisdir = sfConfig::get('sf_web_dir').$dir;
        $photo->setPicpath($newPicpath);
        $photo->save();
        if(in_array(sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_default_size"),$sizes)) {
            $sizes[] = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_default_size");
        }
        if (false !== $index = array_search($newPicpath, $imgs)) {
            for($i = $index; $i < count($imgs); $i++) {
                foreach ($sizes as $size) {
                    unlink($thisdir.DIRECTORY_SEPARATOR.$size.DIRECTORY_SEPARATOR.$imgs[$i]);
                }
                unlink($thisdir.DIRECTORY_SEPARATOR.$imgs[$i]);
            }
        }
        $this->getUser()->setFlash('notice', 'La photo sélectionnée est revenue à la version sélectionnées');
        $this->redirect('photos');
    }
}
