<?php
/**
 * Abstract class to handle params
 *
 * This function can be used to handle params for queries, filter, facets
 *
 * @category Xodoa
 * @package Elastica
 * @author Nicolas Ruflin <spam@ruflin.com>
 */
abstract class Elastica_Param
{
	/**
	 * Params
	 *
	 * @var array
	 */
	protected $_params = array();

	/**
	 * Converts the params to an array. A default implementation exist to create
	 * the an array out of the class name (last part of the class name)
	 * and the params
	 *
	 * @return array Filter array
	 */
	public function toArray() {
		// Picks the last part of the class name and makes it snake_case
		$classNameParts = explode('_', get_class($this));
		$partClassName = Elastica_Util::toSnakeCase(array_pop($classNameParts));

		return array($partClassName => $this->getParams());
	}

	/**
	 * Sets (overwrites) the value at the given key
	 *
	 * @param string $key Key to set
	 * @param mixed $value Key Value
	 */
	public function setParam($key, $value) {
		$this->_params[$key] = $value;
		return $this;
	}

	/**
	 * Sets (overwrites) all params of this object
	 *
	 * @param array $params Parameter list
	 * @return Elastica_Param
	 */
	public function setParams(array $params) {
		$this->_params = $params;
		return $this;
	}

	/**
	 * Adds a param to the list
	 *
	 * This function can be used to add an array of params
	 *
	 * @param string $key Param key
	 * @param mixed $value Value to set
	 * @return Elastica_Param
	 */
	public function addParam($key, $value) {
		if (!isset($this->_params[$key])) {
			$this->_params[$key] = array();
		}

		$this->_params[$key][] = $value;

		return $this;
	}

	/**
	 * Returns a specific param
	 *
	 * @param string $key Key to return
	 * @return mixed Key value
	 * @throws Elastica_Exception_Invalid If requested key is not set
	 */
	public function getParam($key) {
		if (!isset($this->_params[$key])) {
			throw new Elastica_Exception_Invalid('Param ' . $key . ' does not exist');
		}

		return $this->_params[$key];
	}

	/**
	 * Returns the params array
	 *
	 * @return array Params
	 */
	public function getParams() {
		return $this->_params;
	}
}