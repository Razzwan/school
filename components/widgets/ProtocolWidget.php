<?php

namespace components\widgets\protocol;

use Yii;
use yii\base\Exception;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use \common\models\Protocol;
use \common\models\ParamValue;
use \common\models\Auctions;
use components\helpers\DateTimeHelper;
use \common\models\Lots;

class ProtocolWidget extends Widget
{
    /**
     * @var array data fore view
     */
    public $data = [];

    /**
     * @var \yii\db\ActiveRecord
     */
    public $model;

    /**
     * @var string тип протокола, который нужно сгенерировать
     *  из вариантов:
     *      self::TYPE_FINISHED_NAMELESS = '_anonymous';
     *      self::TYPE_FINISHED_WITH_NAME = '_personal';
     *      self::TYPE_FAILED = '_failed';
     */
    public $type;

    /**
     * @var string html-разметка виджета
     */
    public $layout;

    public $viewPath;

    public function init()
    {
        if ($this->model === null) {
            throw new InvalidConfigException('Please specify the "model" property.');
        }

        $this->viewPath = $this->viewPath ? Yii::getAlias($this->viewPath) : Yii::getAlias('@components/widgets/protocol/views');

        if (empty($this->layout)) {
            $this->layout = $this->viewPath .'/layout.php';
        } else {
            $this->layout = Yii::getAlias($this->layout);
        }
    }

    public function run()
    {
        $protocol = $this->model;

        // Общие данные
        $this->data['algorithm']    = $protocol->auction->etau_etal_id ;
        $this->data['protocol_id']  = $protocol->etpr_id;
        $this->data['lot_number']   = $protocol->lot->etlo_number;
        $this->data['product_name'] = $protocol->product->prod_name;
        $this->data['org_name']     = $protocol->organizer->ettd_name;
        $this->data['end_auction']  = DateTimeHelper::toDateTime($protocol->auction->etau_end_auc);
        $this->data['date_create']  = DateTimeHelper::toDateTime($protocol->etpr_created_date);

        // условия
        if (isset($protocol->user)) {
            $this->data['status']       = 'успешно состоялись';

            $this->data['participant_number'] = $protocol->participant->etpa_number_statement;
            $this->data['type_protocol']      = $this->type;
            $this->data['full_name']          = $protocol->user->fullName;

            if ($this->data['algorithm'] == Auctions::ALGORITHM_STANDARD) {
                $this->data['price']          = $protocol->bid->etbi_price;
                $this->data['algorithm']      = $protocol->auction->etau_etal_id;
                $this->data['reason']         = $protocol->reason;
                $this->data['start_price']    = $protocol->lot->etlo_start_price;
                $this->data['paid']           = $protocol->lot->etlo_size_deposit;
                // Если установлен флаг об отдельной оплате гарантийного взноса
                if ($protocol->organizer->getParam('PR_PRICE_INCLUDES_MONEY_PAID_FOR_ORGANIZER') == 1) {
                    $this->data['need_pay']       = $protocol->bid->etbi_price;
                } else {
                    $this->data['need_pay']       = $protocol->bid->etbi_price - $protocol->lot->etlo_size_deposit;
                }
                // Реквизиты для оплаты
                if ($protocol->lot->etlo_realization_type == Lots::REALIZATION_TYPE_FOR_REALIZATION) {
                    $this->data['pay_name']      = $protocol->organizer->ettd_name;
                    $this->data['pay_account']   = $protocol->organizer->ettd_account;
                    $this->data['pay_recipient'] = $protocol->organizer->ettd_edrpou_recipient;
                    $this->data['pay_bank']      = $protocol->organizer->ettd_bank;
                    $this->data['pay_mfo']       = $protocol->organizer->ettd_mfo;
                } else {
                    $this->data['pay_name']      = $protocol->trader->ettd_name;
                    $this->data['pay_account']   = $protocol->trader->ettd_account;
                    $this->data['pay_recipient'] = $protocol->trader->ettd_edrpou_recipient;
                    $this->data['pay_bank']      = $protocol->trader->ettd_bank;
                    $this->data['pay_mfo']       = $protocol->trader->ettd_mfo;
                }
                $this->data['pay_purpose']   = $protocol->paymentPurpose;
                $file_content = $this->viewPath . '/algorithm/standard.php';
            } elseif($this->data['algorithm'] == Auctions::ALGORITHM_COMMISSION) {
                $this->data['price']          = $protocol->participant->etpa_paid_money;
                $file_content = $this->viewPath . '/algorithm/commission.php';
            }
        } else {
            $this->data['status'] = 'не состоялись';
            $data['reason'] = $protocol->reason;
            $file_content = $this->viewPath . '/failed.php';
        }

        $this->testArray($this->data);
        $content = $this->renderFile($file_content, [
            'data' => $this->data,
        ]);
        if (file_exists($this->layout)) {
            return $this->renderFile($this->layout, [
                'data' => $protocol,
                'type' => $this->type,
                'content' => $content,
            ]);
        } else {
            throw new InvalidConfigException("Please specify the \"layout\" property.
           Или убедитесь, что файл {$this->layout} существует и находится в директории виджета.");
        }
    }

    /**
     * Renders a single attribute.
     * @param string $key
     * @param string $label
     * @param string $value
     * @param array $labelOptions
     * @param array $valueOptions
     * @param integer $index the zero-based index of the attribute in the [[attributes]] array
     * @return string the rendering result
     */
    protected function renderAttribute($key, $label, $value, $index, $labelOptions, $valueOptions)
    {
        if (is_string($this->line)) {
            return strtr($this->line, [
                '{key}' => $key,
                '{label}' => $label,
                '{value}' => $this->renderValue($key, $value),
                '{labelOptions}' => $this->renderOptions($labelOptions),
                '{valueOptions}' => $this->renderOptions($valueOptions),
            ]);
        } else {
            return false;
        }
    }

    protected function renderOptions($options)
    {
        if (!is_array($options)) {
            return '';
        }
        $html = '';
        foreach ($options as $key => $value) {
            $html .= " $key=\"$value\"";
        }

        return $html;
    }

    protected function renderValue($key, $value)
    {
        if (empty($value)) {
            if (isset($this->data[$key])){
                return $this->data[$key];
            } else {
                return '';
            }
        }
        if (isset($this->data[$key])){
            $params = [$value, $this->data[$key]];
            return call_user_func_array('sprintf', $params);
        }
        return $value;
    }

    private function testArray($arr)
    {
        foreach ($arr as $key => $value) {
            if ($value === null) {
                throw new Exception("Значение $key не определено!");
            }
        }
    }
}

