<?php

class ModulKonfirmasiFormKonfirmasiModuleFrontController extends ModuleFrontController
{
    public $auth = true;
    public $ssl = true;

    public function displayAjax()
    {
        $this->display();
    }

    /**
     * Assign template vars related to page content
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();

        $id_order = (int)Tools::getValue('id_order');
        $order = new Order($id_order);
        if ($order->id_customer == $this->context->customer->id)
        {
            $id_order_state = (int)$order->getCurrentState();
            $carrier = new Carrier((int)$order->id_carrier, (int)$order->id_lang);

            /* DEPRECATED: customizedDatas @since 1.5 */
            $this->context->smarty->assign(array(
                'order' => $order,
                'carrier' => $carrier,
            ));
        }
        $this->setTemplate('formkonfirmasi.tpl');
		
    }
}
