<?php

/*
 * Copyright (C) 2014 rick
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Ebay\Common;

/**
 * Ebay API Request Object
 * @package Ebay
 * @author Rick Earley <rick@earleyholdings.com>
 * @copyright (c) 2014
 * @version 1.0
 */
class Request {

    /**
     * Request Fields
     * @var array
     */
    private $fields;
    
    /**
     * Ebay Call Name
     * @var string
     */
    private $callName;
    
    /**
     * Ebay Endpoint
     * @var string
     */
    private $endpoint;
    
    /**
     * Call XML Header
     * @var string
     */
    private $callHeader;
    
    /**
     * Call XML Footer
     * @var string
     */
    private $callFooter;

    /**
     * Request Object
     * @param string $callName
     */
    function __construct($callName) {
        $this->callName = $callName;
    }

   /**
    * Set the Ebay REST API Endpoint
    * @param string $endpoint
    * @throws \InvalidArgumentException
    */
    public function setEndpoint($endpoint) {
        
        if(empty($endpoint)){
            throw new \InvalidArgumentException("Endpoint must be a vaild Ebay API URL.");
        }
        
        $this->endpoint = $endpoint;
    }
    
    /**
     * Set call header XML
     * @param type $callHeader
     * @throws \InvalidArgumentException
     */
    public function setCallHeader($callHeader) {
        
        if(empty($callHeader)){
            throw new \InvalidArgumentException("Call XMl Header cannot be empty.");
        }
        
        $this->callHeader = $callHeader;
    }

    /**
     * Set call footer XML
     * @param string $callFooter
     */
    public function setCallFooter($callFooter) {
        
        if(empty($callFooter)){
            throw new \InvalidArgumentException("Call XML Footer cannot be empty.");
        }
        
        $this->callFooter = $callFooter;
    }

    /**
     * Add request field
     * @param \Ebay\Common\Field $field
     */
    public function addField($field) {
        
        if(!$field instanceof \Ebay\Common\Field){
            throw new \InvalidArgumentException("The field must be an instance of \Ebay\Common\Field");
        }            
        
        $this->fields[] = $field;
    }

    /**
     * Build the XML Request
     * @return string
     */
    public function buildRequest() {

        $xmlString = '<?xml version="1.0" encoding="utf-8"?>';
        $xmlString .= $this->callHeader;
        $xmlString .= $this->buildXmlBody();
        $xmlString .= $this->callFooter;

        return $xmlString;
    }

    /**
     * Build the XML Body for Request
     * @return string
     */
    private function buildXmlBody() {
        $xml = '';

        if (is_array($this->fields)) {
            foreach ($this->fields as $data) {
                $xml .= $this->buildInputField($data);
            }
        }

        return $xml;
    }

    /**
     * Add fields to XML Request
     * @param \Ebay\Common\Field $data
     * @return string
     */
    private function buildInputField($data) {
        
        if(!$data instanceof \Ebay\Common\Field){
            throw new \InvalidArgumentException("The field must be an instance of \Ebay\Common\Field");
        }

        // Name
        $name = $data->getName();

        // Attributes
        $attribute = '';
        if (!is_null($data->getAttributes())) {
            foreach ($data->getAttributes() as $att) {
                $attribute .= " {$att['name']}=\"{$att['value']}\"";
            }
        }

        // Value
        $value = '';
        if (is_array($data->getValues())) {
            foreach ($data->getValues() as $values) {
                $value .= $this->buildInputField($values);
            }
        } else {
            $value .= $data->getValues();
        }

        return "<{$name}{$attribute}>{$value}</{$name}>";
    }

}