<?php
namespace Webapp\Backend\Controllers;
use Webapp\Backend\Locale\Culture;
use Webapp\Backend\Models\Category;
use Webapp\Backend\Models\CategoryView;

class CategoryviewController extends ControllerBase
{
    public function initialize()
    {
        global $config;
        $this->modulename = "categoryview";
        $this->view->activesidebar = $config->application->baseUri."categoryview/index";
        parent::initialize();
    }
    public function indexAction()
    {
        if (!$this->checkpermission("categoryview_view")) return false;
        $poslist = Category::position();
        $this->view->catpos = $poslist;
        $q = $this->request->getQuery("pos", "string") ? $this->request->getQuery("pos", "string") : $poslist[0]['key'];
        if ($this->request->isPost()) {
            try {
                $selectedCat = array_values(array_unique($this->request->getPost('cat')));
                    $query = "poskey='$q'";
                    $o = CategoryView::find(array('conditions' => $query));
                    if ($o) {
                        try {
                            $o->delete();
                        } catch (\Exception $e) {
                            $this->flash->error($e->getMessage());
                        }
                    }
                    $i = 1;
                    foreach ($selectedCat as $sCat) {
                        try {
                            $datapost['catid'] = (int) $sCat;
                            $datapost['poskey'] = $q;
                            $datapost['sorts'] = $i;
                            $o = new CategoryView();
                            $o->map_object($datapost);
                            $o->save();
                            $i++;
                        } catch (\Exception $e) {
                            $this->flash->error($e->getMessage());
                        }
                    }
                    if($i>sizeof($selectedCat)) $this->flash->success("Saved Successfully !");
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }

        $query = "poskey = '$q'";
        $listdata = CategoryView::find(
            array(
                'conditions' => $query
            )
        );
        $this->view->listdata = $listdata;
    }


}