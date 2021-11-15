<?php

abstact class FormElement
{
	private $name;
	private $id;
	private $class;
	private $style;
	public function __construct(string $name, string $id, string $class, string $style){

    public function render();
}
