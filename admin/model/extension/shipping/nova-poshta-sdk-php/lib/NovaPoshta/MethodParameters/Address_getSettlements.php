<?php

namespace NovaPoshta\MethodParameters;

/**
 * Параметры метода getSettlements модели Address
 *
 * Class Address_getSettlements
 * @package NovaPoshta\DataMethods
 * @property string Ref
 * @property string Page
 */
class Address_getSettlements extends MethodParameters
{
    /**
     * Устанавливает реф
     *
     * @param string $value
     * @return $this
     */
    public function setRef($value)
    {
        $this->Ref = $value;
        return $this;
    }

    /**
     * Возвращает реф
     *
     * @return string
     */
    public function getRef()
    {
        return $this->Ref;
    }
    
    /**
     * setup AreaRef
     *
     * @param string $value
     * @return $this
     */
    public function setArea($value)
    {
        $this->Area = $value;
        return $this;
    }

    /**
     * get AreaRef
     *
     * @return string
     */
    public function getArea()
    {
        return $this->Area;
    }
    
    /**
     * Устанавливает страницу
     *
     * @param string $value
     * @return $this
     */
    public function setPage($value)
    {
        $this->Page = $value;
        return $this;
    }

    /**
     * Возвращает страницу
     *
     * @return string
     */
    public function getPage()
    {
        return $this->Page;
    }
}