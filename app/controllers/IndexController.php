<?php
namespace TestApp\Controllers;

class IndexController extends \Phalcon\Mvc\Controller
{
    /**
     * @Get("/")
     */
    public function indexAction()
    {
        $this->view->setVar('testArray', range(0, 10));
        $this->view->pick('index/index');
    }
}
