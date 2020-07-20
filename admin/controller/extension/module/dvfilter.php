<?php

class ControllerExtensionModuleDVFilter extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('extension/module/dvfilter');

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('dvfilter', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->get['apply'])) {
                $this->response->redirect($this->url->link('extension/module/dvfilter', 'token=' . $this->session->data['token'], true));
            } else {
                $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], true));
            }
        }

        $this->document->setTitle($this->language->get('heading_title'));

        $data['heading_title'] = $this->language->get('heading_title');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_option'] = $this->language->get('tab_option');
        $data['tab_price_filtering'] = $this->language->get('tab_price_filtering');
        $data['tab_copy'] = $this->language->get('tab_copy');
        $data['tab_other'] = $this->language->get('tab_other');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_selected'] = $this->language->get('text_selected');
        $data['text_stock_by_status_id'] = $this->language->get('text_stock_by_status_id');
        $data['text_stock_by_quantity'] = $this->language->get('text_stock_by_quantity');
        $data['text_options'] = $this->language->get('text_options');
        $data['text_values'] = $this->language->get('text_values');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['text_complete'] = $this->language->get('text_complete');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_apply'] = $this->language->get('button_apply');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_copy'] = $this->language->get('button_copy');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_show_price'] = $this->language->get('entry_show_price');
        $data['entry_show_counter'] = $this->language->get('entry_show_counter');
        $data['entry_show_diagram'] = $this->language->get('entry_show_diagram');
        $data['entry_show_selected'] = $this->language->get('entry_show_selected');
        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_consider_discount'] = $this->language->get('entry_consider_discount');
        $data['entry_consider_special'] = $this->language->get('entry_consider_special');
        $data['entry_consider_option'] = $this->language->get('entry_consider_option');
        $data['entry_manual_price'] = $this->language->get('entry_manual_price');
        $data['entry_show_first_limit'] = $this->language->get('entry_show_first_limit');
        $data['entry_hide_empty_values'] = $this->language->get('entry_hide_empty_values');
        $data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
        $data['entry_type'] = $this->language->get('entry_type');
        $data['entry_stock_status'] = $this->language->get('entry_stock_status');
        $data['entry_stock_status_method'] = $this->language->get('entry_stock_status_method');
        $data['entry_stock_out_value'] = $this->language->get('entry_stock_out_value');
        $data['entry_store'] = $this->language->get('entry_store');
        $data['entry_noindex_limit'] = $this->language->get('entry_noindex_limit');

        $data['notice_status'] = $this->language->get('notice_status');
        $data['notice_show_price'] = $this->language->get('notice_show_price');
        $data['notice_show_diagram'] = $this->language->get('notice_show_diagram');
        $data['notice_show_counter'] = $this->language->get('notice_show_counter');
        $data['notice_show_selected'] = $this->language->get('notice_show_selected');
        $data['notice_category'] = $this->language->get('notice_category');
        $data['notice_consider_discount'] = $this->language->get('notice_consider_discount');
        $data['notice_consider_special'] = $this->language->get('notice_consider_special');
        $data['notice_consider_option'] = $this->language->get('notice_consider_option');
        $data['notice_manual_price'] = $this->language->get('notice_manual_price');
        $data['notice_show_options_limit'] = $this->language->get('notice_show_options_limit');
        $data['notice_show_values_limit'] = $this->language->get('notice_show_values_limit');
        $data['notice_hide_empty_values'] = $this->language->get('notice_hide_empty_values');
        $data['notice_manufacturer'] = $this->language->get('notice_manufacturer');
        $data['notice_stock_status'] = $this->language->get('notice_stock_status');
        $data['notice_noindex_limit'] = $this->language->get('notice_noindex_limit');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_module'),
                'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/dvfilter', 'token=' . $this->session->data['token'], true)
        );

        $data['save'] = $this->url->link('extension/module/dvfilter', 'token=' . $this->session->data['token'], true);
        $data['apply'] = $this->url->link('extension/module/dvfilter', 'token=' . $this->session->data['token'] . '&apply', true);
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);

        $data['token'] = $this->session->data['token'];

        if (isset($this->request->post['dvfilter_status'])) {
            $data['dvfilter_status'] = $this->request->post['dvfilter_status'];
        } else {
            $data['dvfilter_status'] = $this->config->get('dvfilter_status');
        }

        if (isset($this->request->post['dvfilter_sitemap_status'])) {
            $data['dvfilter_sitemap_status'] = $this->request->post['dvfilter_sitemap_status'];
        } else {
            $data['dvfilter_sitemap_status'] = $this->config->get('dvfilter_sitemap_status');
        }

        $data['sitemap_link'] = HTTP_CATALOG . 'index.php?route=feed/dvfilter_sitemap';

        ####### Option category ########
        if (isset($this->request->post['dvfilter_category'])) {
            $data['dvfilter_category'] = $this->request->post['dvfilter_category'];
        } else {
            $data['dvfilter_category'] = $this->config->get('dvfilter_category');
        }
        ##### End Option subcategory ######

        if (isset($this->request->post['dvfilter_show_selected'])) {
            $data['dvfilter_show_selected'] = $this->request->post['dvfilter_show_selected'];
        } else {
            $data['dvfilter_show_selected'] = $this->config->get('dvfilter_show_selected');
        }

        if (isset($this->request->post['dvfilter_show_price'])) {
            $data['dvfilter_show_price'] = $this->request->post['dvfilter_show_price'];
        } else {
            $data['dvfilter_show_price'] = $this->config->get('dvfilter_show_price');
        }

        if (isset($this->request->post['dvfilter_show_counter'])) {
            $data['dvfilter_show_counter'] = $this->request->post['dvfilter_show_counter'];
        } else {
            $data['dvfilter_show_counter'] = $this->config->get('dvfilter_show_counter');
        }

        if (isset($this->request->post['dvfilter_manufacturer'])) {
            $data['dvfilter_manufacturer'] = $this->request->post['dvfilter_manufacturer'];
        } else {
            $data['dvfilter_manufacturer'] = $this->config->get('dvfilter_manufacturer');
        }

        if (isset($this->request->post['dvfilter_manufacturer_type'])) {
            $data['dvfilter_manufacturer_type'] = $this->request->post['dvfilter_manufacturer_type'];
        } else {
            $data['dvfilter_manufacturer_type'] = $this->config->get('dvfilter_manufacturer_type');
        }

        if (isset($this->request->post['dvfilter_stock_status'])) {
            $data['dvfilter_stock_status'] = $this->request->post['dvfilter_stock_status'];
        } else {
            $data['dvfilter_stock_status'] = $this->config->get('dvfilter_stock_status');
        }

        if (isset($this->request->post['dvfilter_stock_status_method'])) {
            $data['dvfilter_stock_status_method'] = $this->request->post['dvfilter_stock_status_method'];
        } else {
            $data['dvfilter_stock_status_method'] = $this->config->get('dvfilter_stock_status_method');
        }

        if (isset($this->request->post['dvfilter_stock_out_value'])) {
            $data['dvfilter_stock_out_value'] = $this->request->post['dvfilter_stock_out_value'];
        } else {
            $data['dvfilter_stock_out_value'] = $this->config->get('dvfilter_stock_out_value');
        }

        if (isset($this->request->post['dvfilter_show_diagram'])) {
            $data['dvfilter_show_diagram'] = $this->request->post['dvfilter_show_diagram'];
        } else {
            $data['dvfilter_show_diagram'] = $this->config->get('dvfilter_show_diagram');
        }

        if (isset($this->request->post['dvfilter_manual_price'])) {
            $data['dvfilter_manual_price'] = $this->request->post['dvfilter_manual_price'];
        } else {
            $data['dvfilter_manual_price'] = $this->config->get('dvfilter_manual_price');
        }

        if (isset($this->request->post['dvfilter_consider_discount'])) {
            $data['dvfilter_consider_discount'] = $this->request->post['dvfilter_consider_discount'];
        } else {
            $data['dvfilter_consider_discount'] = $this->config->get('dvfilter_consider_discount');
        }

        if (isset($this->request->post['dvfilter_consider_special'])) {
            $data['dvfilter_consider_special'] = $this->request->post['dvfilter_consider_special'];
        } else {
            $data['dvfilter_consider_special'] = $this->config->get('dvfilter_consider_special');
        }

        if (isset($this->request->post['dvfilter_consider_option'])) {
            $data['dvfilter_consider_option'] = $this->request->post['dvfilter_consider_option'];
        } else {
            $data['dvfilter_consider_option'] = $this->config->get('dvfilter_consider_option');
        }

        if (isset($this->request->post['dvfilter_show_options_limit'])) {
            $data['dvfilter_show_options_limit'] = $this->request->post['dvfilter_show_options_limit'];
        } else {
            $data['dvfilter_show_options_limit'] = $this->config->get('dvfilter_show_options_limit');
        }

        if (isset($this->request->post['dvfilter_show_values_limit'])) {
            $data['dvfilter_show_values_limit'] = $this->request->post['dvfilter_show_values_limit'];
        } else {
            $data['dvfilter_show_values_limit'] = $this->config->get('dvfilter_show_values_limit');
        }

        if (isset($this->request->post['dvfilter_hide_empty_values'])) {
            $data['dvfilter_hide_empty_values'] = $this->request->post['dvfilter_hide_empty_values'];
        } else {
            $data['dvfilter_hide_empty_values'] = $this->config->get('dvfilter_hide_empty_values');
        }

        if (isset($this->request->post['dvfilter_noindex_limit'])) {
            $data['dvfilter_noindex_limit'] = $this->request->post['dvfilter_noindex_limit'];
        } else if ($this->config->has('dvfilter_noindex_limit')) {
            $data['dvfilter_noindex_limit'] = $this->config->get('dvfilter_noindex_limit');
        } else {
            $data['dvfilter_noindex_limit'] = 3;
        }

        if (isset($this->request->post['dvfilter_attribute_separator'])) {
            $data['dvfilter_attribute_separator'] = $this->request->post['dvfilter_attribute_separator'];
        } else {
            $data['dvfilter_attribute_separator'] = $this->config->get('dvfilter_attribute_separator');
        }

        $data['types'] = array(
                'checkbox',
                'radio',
                'select'
        );

        $this->load->model('setting/store');

        $data['stores'] = $this->model_setting_store->getStores();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/dvfilter', $data));
    }

    public function copyFilters() {
        $json = array();

        $this->load->language('extension/module/dvfilter');

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if (!isset($this->request->post['copy_store'])) {
                $json['error'] = 'Пожалуйста, укажите магазин, с которого будут копироваться данные';
            }

            if (empty($this->request->post['copy_type'])) {
                $json['error'] = 'Пожалуйста, укажите тип будущих опций';
            }

            if (!$json) {
                $this->load->model('catalog/dvfilter');

                $this->model_catalog_dvfilter->copyFilters($this->request->post);

                $json['success'] = $this->language->get('text_complete');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/dvfilter')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

}
