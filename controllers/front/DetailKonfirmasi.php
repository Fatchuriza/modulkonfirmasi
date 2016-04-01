<?php

class modulkonfirmasiDetailKonfirmasiModuleFrontController extends ModuleFrontController{
    public $auth = true;
    public $ssl = true;
	public $a;
    public function setMedia()
    {
        // We call the parent method
        parent::setMedia();
        $this->addCSS(array(
            _THEME_CSS_DIR_.'history.css',
            _THEME_CSS_DIR_.'addresses.css'
        ));
        $this->addJS(array(
            _THEME_JS_DIR_.'history.js',
            _THEME_JS_DIR_.'tools.js' // retro compat themes 1.5
        ));
        $this->addJQueryUI('ui.datepicker');
        $this->addJqueryPlugin(array('scrollTo', 'footable','footable-sort', 'validate'));
        // Save the module path in a variable
        $this->path = __PS_BASE_URI__.'modules/modulkonfirmasi/';
    }

    public function initContent(){
        $this->display_column_left = false;
        $this->display_column_right = false;
        parent::initContent();
        //$this->initList();
        //sumber dari modul mail alert
		$konfirmasis = konfirmasi::getKonfirmasi();
        $orders = Order::getCustomerOrders($this->context->customer->id);
        $this->context->smarty->assign(array(
            'orders' => $orders,
            'konfirmasis' => $konfirmasis,
            'invoiceAllowed' => (int)Configuration::get('PS_INVOICE'),
            'reorderingAllowed' => !(int)Configuration::get('PS_DISALLOW_HISTORY_REORDERING'),
            'slowValidation' => Tools::isSubmit('slowvalidation')
        ));
        $this->setTemplate('detailkonfirmasi.tpl');
    }

    public function postProcess(){        if(Tools::isSubmit('mymod_pc_submit_konfirmasi')){            $id_konfirmasi_produk = Tools::getValue('id_konfirmasi_produk');            $no_order = Tools::getValue('no_order');            $nama_bank = Tools::getValue('nama_bank');            $nama_pengirim = Tools::getValue('nama_pengirim');            $tanggal_transfer = Tools::getValue('tanggal_transfer');				$tanggal_transfer2 = date("d-m-Y", strtotime($tanggal_transfer));            $jumlah_dana = Tools::getValue('jumlah_dana');            $timestamp = date('Y-m-d G:i:s');				$date_add_konfirmasi2 = date("d-m-Y", strtotime($timestamp));            $insert = array(				'id_konfirmasi_produk' => $id_konfirmasi_produk,				'no_order' => $no_order,				'nama_bank' => $nama_bank,				'nama_pengirim' => $nama_pengirim,				'tanggal_transfer' => $tanggal_transfer,				'jumlah_dana' => $jumlah_dana,            'date_add_konfirmasi' => $timestamp,			);			Db::getInstance()->insert('konfirmasi_produk',$insert);			$lastKonfirmasi = konfirmasi::getIdKonfirmasi();			$b = max($lastKonfirmasi);			$c = $b['id_konfirmasi_produk'];			Mail::Send(				$this->context->language->id,				'template',				Mail::l('Konfirmasi Pembayaran', $this->context->language->id),				array(					'{firstname}' => $this->context->customer->firstname,					'{lastname}' => $this->context->customer->lastname,					'{id_konfirmasi_produk}' => $c,					'{no_order}' => $no_order,					'{nama_bank}' => $nama_bank,					'{nama_pengirim}' => $nama_pengirim,					'{tanggal_transfer}' => $tanggal_transfer2,					'{jumlah_dana}' => $jumlah_dana,					'{date_add_konfirmasi}' => $date_add_konfirmasi2				),				$this->context->customer->email,				$this->context->customer->firstname.' '.$this->context->customer->lastname,				null,				strval(Configuration::get('PS_SHOP_NAME')),				null,				null,				$this->module->getLocalPath().'mails/');			$this->context->smarty->assign('konfirmasi', 'ok');	        }    }
}