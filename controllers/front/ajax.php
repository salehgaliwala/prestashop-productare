<?php
/**
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement.
 *
 * You must not modify, adapt or create derivative works of this source code
 *
 * @author    Musaffar Patel
 * @copyright 2016-2017 Musaffar Patel
 * @license   LICENSE.txt
 */

class ProductAreaPacksAjaxModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $this->ajax = true;
        parent::initContent();
        $this->route();
    }

    public function route()
    {
        $module = Module::getInstanceByName('productareapacks');
        if (Tools::getValue('section') != '') {
            switch (Tools::getValue('section')) {
                case 'front_ajax' :
                    die($module->route());

            }
        }
    }
}
