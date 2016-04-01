<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once (dirname(__FILE__).'/../../classes/konfirmasi.php');
class AdminModulKonfirmasiController extends ModuleAdminController{
    public function __construct()
	{
		$this->bootstrap = true;
		$this->context = Context::getContext();
	 	$this->table = 'konfirmasi_produk';
	 	$this->className = 'konfirmasi';
        $this->addRowAction('delete');
        $this->list_no_link =true;
        $this->fields_list = array(
            'id_konfirmasi_produk' => array('title' => $this->l('ID'),
            'align' => 'center'),
            'no_order' => array('title' => $this->l('No Order')),
            'nama_bank' => array('title' => $this->l('Bank')),
            'nama_pengirim' => array('title' => $this->l('Pengirim')),
            'tanggal_transfer' => array('title' => $this->l('Tanggal'), 'type' => 'date'),
            'jumlah_dana' => array('title' => $this->l('Jumlah')),
            'date_add_konfirmasi' => array(
                'title' => $this->l('Tanggal Konfirmasi'),
                'type' => 'date',
                'align' => 'right'
            ),
            'active' => array('title' => $this->l('Cek Konfirmasi'), 'align' => 'center', 'active' => 'status', 'type' => 'bool', 'orderby' => false),
            'date_terkonfirmasi' => array(
                'title' => $this->l('Tanggal Terkonfirmasi'),
                'type' => 'date',
                'align' => 'right'
            )
 		);
		parent::__construct();
	}
    public function initToolbar()
	{
		// If display list, we don't want the "add" button
		if (!$this->display || $this->display == 'list')
			return;
		parent::initToolbar();
	}
    /*public function renderForm()
    {
        if (Shop::isFeatureActive()) {
            $this->fields_form['input'][] = array(
                'type' => 'shop',
                'label' => $this->l('Shop association:'),
                'name' => 'checkBoxShopAsso',
            );
        }
        return parent::renderForm();
    }*/
}